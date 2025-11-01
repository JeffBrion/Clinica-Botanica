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
        $type = $request->input('type', 'sql'); // 'sql' | 'json'
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
        $request->validate([
            'backup_file' => 'required|file',
            'truncate' => 'nullable|boolean',
        ]);
        $truncate = (bool) $request->input('truncate', true);
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
        $port = $conn['port'] ?? 3306;
        $db   = $conn['database'] ?? '';
        $user = $conn['username'] ?? '';
        $pass = $conn['password'] ?? '';

        if (!$db || !$user) { return false; }

        $cmd = [
            'sh', '-c',
            sprintf(
                'MYSQL_PWD=%s mysqldump --user=%s --host=%s --port=%d --routines --triggers --single-transaction --skip-lock-tables %s > %s',
                escapeshellarg($pass),
                escapeshellarg($user),
                escapeshellarg($host),
                (int)$port,
                escapeshellarg($db),
                escapeshellarg($target)
            )
        ];

        try {
            $process = new Process($cmd, null, [ 'MYSQL_PWD' => $pass ]);
            $process->setTimeout(300);
            $process->run();
            return $process->isSuccessful() && file_exists($target) && filesize($target) > 0;
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
}
