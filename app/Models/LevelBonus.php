<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelBonus extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_level_bonus';
    protected $table = 'level_bonus';

    protected $fillable = [
        'id_unit_Bonus',
        'level_number',
        'score_bonus',
    ];

    public $timestamps = false;

}
