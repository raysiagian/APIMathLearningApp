<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_statistic'; 
    protected $table = 'statistic';

    protected $fillable = [
        'id_user',
        'id_unit',
        'id_materi',
        'score_pretest',
        'score_posttest',
    ];

    public $timestamps = false;
}
