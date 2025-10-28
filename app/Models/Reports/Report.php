<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Everth\UserStamps\UserStampsTrait;

class Report extends Model
{

    use UserStampsTrait;
    protected $table = 'reports';

    protected $fillable = [
        'end_date',
        'report_type',
        'start_date',
        'create_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
