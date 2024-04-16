<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_materi'; 
    protected $table = 'materi';

    protected $fillable = [
        'title',
        'imageCard',
        'imageBackground',
        'imageCardAdmin',
        'imageStatistic',
    ];

    public $timestamps = false;
}
