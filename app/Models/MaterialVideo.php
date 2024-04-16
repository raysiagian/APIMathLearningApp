<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVideo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_material_videp';
    protected $table = 'material_video';

    protected $fillable = [
        'id_level',
        'video_Url',
        'title',
        'explanation',
    ];

    public $timestamps = false;
}
