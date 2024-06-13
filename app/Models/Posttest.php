<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posttest extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_posttest';
    protected $table = 'posttest';


    protected $fillable = [
        'id_unit',
        // 'score_posttest',
        // 'is_completed',
    ];


    public $timestamps = false;



}
