<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_unit';
    protected $table = 'unit';

    protected $fillable = [
        'id_materi',
        'title',
        'explanation',
    ];

    public $timestamps = false;

}
