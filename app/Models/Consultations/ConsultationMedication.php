<?php

namespace App\Models\Consultations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Items\Item;

class ConsultationMedication extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'item_id',
        'quantity',
        'instructions',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
