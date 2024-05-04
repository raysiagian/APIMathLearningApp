<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVideo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_material_video';
    protected $table = 'material_video';


    protected $fillable = [
        'video_Url',
        'title',
        'explanation',
        'id_level'
    ];


    public $timestamps = false;



}
