<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreUser extends Model
{
    use HasFactory;

    protected $table = 'score_user';

    protected $primaryKey = 'id_score_user';

    protected $fillable = [
        'id_user',
        'id_pretest',
        'id_posttest',
        'id_level',
        'id_unit',
        'score_pretest',
        'score_posttest',
        'title',
    ];

}
