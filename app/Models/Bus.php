<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $table = 'bus';
    protected $primaryKey = 'id';
    protected $fillable = ['tipe','lambung','sumber_energi','muatan', 'jam_operasional','foto','koridor_id'];

    public function Koridor()
    {
        return $this->belongsTo('App\Models\Koridor', 'koridor_id', 'id');
    }
    
}
