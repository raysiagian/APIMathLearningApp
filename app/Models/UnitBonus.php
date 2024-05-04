<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitBonus extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_unit_Bonus';
    protected $table = 'unit_bonus';

    protected $fillable = [
        'id_materi',
        'title',
        'explanation',
    ];

    public $timestamps = false;

}
