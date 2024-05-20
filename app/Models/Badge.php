<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_bagde';
    protected $table = 'badge';

    protected $fillable =[
        'id_penggunaWeb',
        'image',
        'title',
        'explanation',
        'id_posttest',
        'imageUrl',
        'id_materi'
    ];
    
    public $timestamps = false;
}