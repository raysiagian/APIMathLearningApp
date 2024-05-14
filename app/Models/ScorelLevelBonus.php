<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScorelLevelBonus extends Model
{
    use HasFactory;
    
    protected $table = 'score_level_bonus';
    protected $primaryKey = 'id_ScoreLevelBonus'; 

    protected $fillable = [
        'id_unit_Bonus',
        'id_user',
        'score',
        'id_level_bonus',
    ];

    public $timestamps = false;

}
