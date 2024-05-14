<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScorePosttest extends Model
{
    use HasFactory;

    protected $table = 'score_posttest';
    protected $primaryKey = 'id_ScorePosttest'; 


    protected $fillable = [
        'id_unit',
        'id_user',
        'score',
        'id_posttest',
    ];

    public $timestamps = false;

}
