<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionPosttest extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_question_posttest';
    protected $table = 'question_posttest';

    protected $fillable = [
        'id_posttest',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'correct_index',
    ];

    public $timestamps = false;
}
