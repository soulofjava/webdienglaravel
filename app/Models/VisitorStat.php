<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorStat extends Model
{
    protected $table = 'visitor_stats';
    protected $primaryKey = 'date';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'date',
        'total_visits',
        'unique_visitors',
    ];
}
