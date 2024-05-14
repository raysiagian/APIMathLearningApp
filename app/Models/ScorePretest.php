<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScorePretest extends Model
{   
    use HasFactory;
    
    protected $table = 'score_pretest';
    protected $primaryKey = 'id_ScorePreTest'; 


    protected $fillable = [
        'id_unit',
        'id_user',
        'score',
        'id_pretest',
    ];

    public $timestamps = false;

}
