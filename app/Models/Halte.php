<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halte extends Model
{
    use HasFactory;
    protected $table = 'halte';
    protected $primaryKey = 'id';
    protected $fillable = ['koridor', 'kode', 'nama','lokasi','node_id'];

    public function Node()
    {
        return $this->belongsTo('App\Models\Node', 'node_id', 'id');
    }

    public function Koridor()
    {
        return $this->belongsTo('App\Models\Koridor', 'koridor', 'id');
    }
}
