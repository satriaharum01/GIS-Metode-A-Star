<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cordinat extends Model
{
    use HasFactory;
    protected $table = 'cordinat';
    protected $primaryKey = 'id_cords';
    protected $fillable = ['latitude','longitude','keterangan','halte_id'];
    
}

