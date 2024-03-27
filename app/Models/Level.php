<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_level';
    protected $table = 'level';

    protected $fillable = [
        'id_unit',
        'level_number',
    ];

    public $timestamps = false;

}
