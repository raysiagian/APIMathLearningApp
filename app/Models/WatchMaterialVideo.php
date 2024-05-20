<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchMaterialVideo extends Model
{
    use HasFactory;

    protected $table = 'watch_material_video';
    protected $primaryKey = 'id_WatchMaterialVideo';

    
    protected $fillable = [
        'id_unit',
        'id_user',
        'id_completed',
        'id_material_video',
    ];

    public $timestamps = false;

}
