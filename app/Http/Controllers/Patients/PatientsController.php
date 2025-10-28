<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patients\Patient;

class PatientsController extends Controller
{
    public function index($pagination = 25)
    {
        $patients = Patient::orderBy('created_at', 'desc')->paginate($pagination);
        return view('patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:M,F,O',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        Patient::create($data);

        return back()->with('success', 'Paciente creado correctamente.');
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:M,F,O',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $patient->update($data);

        return back()->with('success', 'Paciente actualizado correctamente.');
    }

    public function delete(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'Paciente eliminado.');
    }
}
