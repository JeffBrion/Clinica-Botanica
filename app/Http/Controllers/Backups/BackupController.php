<?php

namespace App\Http\Controllers\Backups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    protected string $disk = 'local'; // storage/app
    protected string $dir = 'backups';

    public function index()
    {
        $path = storage_path('app/'.$this->dir);
        if (!is_dir($path)) { @mkdir($path, 0775, true); }

        $files = collect(Storage::files($this->dir))
            ->filter(fn ($f) => Str::endsWith($f, ['.sql', '.json', '.zip']))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::size($file),
                    'updated' => Storage::lastModified($file),
                    'ext' => pathinfo($file, PATHINFO_EXTENSION),
                ];
            })
            ->sortByDesc('updated')
            ->values();

        return view('backups.index', compact('files'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type', 'sql'); // 'sql' | 'json' | 'images'
        $timestamp = now()->format('Ymd_His');

        if ($type === 'sql') {
            $name = "backup_{$timestamp}.sql";
            $target = storage_path('app/'.$this->dir.'/'.$name);
            $ok = $this->dumpSql($target);
            if (!$ok) {
                // fallback JSON
                $name = "backup_{$timestamp}.json";
                $target = storage_path('app/'.$this->dir.'/'.$name);
                $this->dumpJson($target);
                return back()->with('message', 'No se pudo generar SQL, se creó respaldo JSON como alternativa.')->with('type', 'warning');
            }
            return back()->with('message', 'Respaldo SQL generado correctamente.')->with('type', 'success');
        } elseif ($type === 'images') {
            $name = "images_{$timestamp}.zip";
            $target = storage_path('app/'.$this->dir.'/'.$name);
            $imagesPath = public_path('img');
            if (!is_dir($imagesPath)) {
                return back()->with('message', 'La carpeta de imágenes no existe (public/img).')->with('type', 'danger');
            }
            $ok = $this->zipDirectory($imagesPath, $target);
            if (!$ok) {
                return back()->with('message', 'No se pudo generar el respaldo de imágenes o la carpeta está vacía.')->with('type', 'warning');
            }
            return back()->with('message', 'Respaldo de imágenes generado correctamente.')->with('type', 'success');
        } else {
            $name = "backup_{$timestamp}.json";
            $target = storage_path('app/'.$this->dir.'/'.$name);
            $this->dumpJson($target);
            return back()->with('message', 'Respaldo JSON generado correctamente.')->with('type', 'success');
        }
    }

    public function download(string $name)
    {
        $file = $this->dir.'/'.$name;
        abort_unless(Storage::exists($file), 404);
        return response()->download(storage_path('app/'.$file));
    }

    public function destroy(string $name)
    {
        $file = $this->dir.'/'.$name;
        if (Storage::exists($file)) {
            Storage::delete($file);
            return back()->with('message', 'Respaldo eliminado.')->with('type', 'success');
        }
        return back()->with('message', 'Archivo no encontrado.')->with('type', 'danger');
    }

    public function import(Request $request)
    {
        // "truncate" vendrá como checkbox ("on") cuando está marcado.
        // Usamos accepted para no fallar si no viene y convertir con boolean().
        $request->validate([
            'backup_file' => 'required|file',
            'truncate' => 'sometimes|accepted',
        ]);
        $truncate = $request->boolean('truncate');
        $file = $request->file('backup_file');
        $ext = strtolower($file->getClientOriginalExtension());
        $path = $file->storeAs($this->dir, 'import_'.now()->format('Ymd_His').'.'.$ext);

        try {
            if ($ext === 'sql') {
                $sql = file_get_contents(storage_path('app/'.$path));
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                if ($truncate) {
                    $this->truncateAll();
                }
                DB::unprepared($sql);
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                return back()->with('message', 'Importación SQL completada.')->with('type', 'success');
            } elseif ($ext === 'json') {
                $json = json_decode(file_get_contents(storage_path('app/'.$path)), true);
                if (!is_array($json)) {
                    return back()->with('message', 'Archivo JSON inválido.')->with('type', 'danger');
                }
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                if ($truncate) {
                    $this->truncateAll(array_keys($json));
                }
                foreach ($json as $table => $rows) {
                    if (!is_array($rows) || empty($rows)) continue;
                    $chunks = array_chunk($rows, 500);
                    foreach ($chunks as $chunk) {
                        DB::table($table)->insert($chunk);
                    }
                }
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                return back()->with('message', 'Importación JSON completada.')->with('type', 'success');
            } else {
                return back()->with('message', 'Formato no soportado. Usa .sql o .json').with('type', 'danger');
            }
        } catch (\Throwable $e) {
            return back()->with('message', 'Error al importar: '.$e->getMessage())->with('type', 'danger');
        }
    }

    protected function dumpSql(string $target): bool
    {
        $conn = config('database.connections.mysql');
        if (!$conn || ($conn['driver'] ?? '') !== 'mysql') { return false; }

        $host = $conn['host'] ?? '127.0.0.1';
        $port = (string)($conn['port'] ?? 3306);
        $db   = $conn['database'] ?? '';
        $user = $conn['username'] ?? '';
        $pass = $conn['password'] ?? '';

        if (!$db || !$user) { return false; }

        // Ejecutar mysqldump sin usar shell y redirección para evitar archivos vacíos por fallas de PATH/quoting
        $args = [
            'mysqldump',
            "--user={$user}",
            "--host={$host}",
            "--port={$port}",
            '--routines',
            '--triggers',
            '--single-transaction',
            '--skip-lock-tables',
            $db,
        ];

        try {
            $process = new Process($args, null, ['MYSQL_PWD' => $pass]);
            $process->setTimeout(300);
            $process->run();

            if (!$process->isSuccessful()) {
                return false;
            }

            $output = $process->getOutput();
            if ($output === '' || $output === null) {
                return false;
            }

            @file_put_contents($target, $output);
            return file_exists($target) && filesize($target) > 0;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function dumpJson(string $target): void
    {
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(function ($row) {
                return array_values((array) $row)[0] ?? null;
            })
            ->filter()
            ->values();

        $data = [];
        foreach ($tables as $table) {
            $rows = DB::table($table)->get()->map(fn ($r) => (array) $r)->toArray();
            $data[$table] = $rows;
        }
        @file_put_contents($target, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }

    protected function truncateAll(?array $onlyTables = null): void
    {
        $tables = $onlyTables ?: collect(DB::select('SHOW TABLES'))
            ->map(function ($row) { return array_values((array) $row)[0] ?? null; })
            ->filter()->values()->all();

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }

    /**
     * Comprime un directorio en un archivo ZIP. Devuelve true si se creó con contenido.
     */
    protected function zipDirectory(string $sourceDir, string $zipTarget): bool
    {
        $sourceDir = rtrim($sourceDir, DIRECTORY_SEPARATOR);
        if (!is_dir($sourceDir)) { return false; }

        // Recolectar archivos
        $files = [];
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($sourceDir, \FilesystemIterator::SKIP_DOTS));
        foreach ($rii as $file) {
            if ($file->isDir()) continue;
            $files[] = $file->getPathname();
        }
        if (empty($files)) { return false; }

        // Crear ZIP
        $zip = new \ZipArchive();
        if ($zip->open($zipTarget, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return false;
        }
        $baseLen = strlen($sourceDir) + 1;
        foreach ($files as $path) {
            $local = substr($path, $baseLen);
            $zip->addFile($path, $local);
        }
        $zip->close();
        return file_exists($zipTarget) && filesize($zipTarget) > 0;
    }
}
