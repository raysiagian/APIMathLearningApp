<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionPretest extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_question_pretest';
    protected $table = 'question_pretest';

    protected $fillable = [
        'id_pretest',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
    ];

    public $timestamps = false;
}
