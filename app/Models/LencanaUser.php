<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LencanaUser extends Model
{
    protected $table = 'lencana_pengguna'; 
    protected $primaryKey = 'id_LencanaPengguna';

    protected $fillable = [
        'id_bagde',
        'id_user',
    ];

    public $timestamps = false;

}