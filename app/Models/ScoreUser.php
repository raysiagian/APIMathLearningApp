<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'score_pretest';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_pretest', 'id_unit', 'score',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}