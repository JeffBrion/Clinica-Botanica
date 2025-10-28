<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Everth\UserStamps\UserStampsTrait;

use App\Models\Patients\Patient;
use App\Models\User;

class Consultation extends Model
{
    use HasFactory, UserStampsTrait;

    protected $fillable = [
        'patient_id',
        'patient_name',
        'consultation_date',
        'consultation_type',
        'symptoms',
        'diagnosis',
        'treatment',
        'is_chronic',
        'weight',
        'blood_pressure',
        'heart_rate',
    ];

    protected $casts = [
        'consultation_date' => 'datetime',
        'is_chronic' => 'boolean',
        'weight' => 'decimal:2',
        'heart_rate' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medications()
    {
        return $this->hasMany(ConsultationMedication::class);
    }

    // Usuario que creó la consulta (para impresiones y auditoría)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
