<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pretest';
    protected $table = 'pretest';


    protected $fillable = [
        'id_unit',
        'score_pretest',
    ];


    public $timestamps = false;



}
