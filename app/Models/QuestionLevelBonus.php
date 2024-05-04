<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionLevelBonus extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_question_level_bonus';
    protected $table = 'question_level_bonus';

    protected $fillable = [
        'id_level_bonus',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'correct_index'
    ];

    public $timestamps = false;
}
