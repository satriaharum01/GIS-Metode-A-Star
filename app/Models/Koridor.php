<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koridor extends Model
{
    use HasFactory;
    protected $table = 'koridor';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['kode','nama'];

    public function Halte()
    {
        return $this->hasMany('App\Models\Halte', 'id');
    }
    
    public function Bus()
    {
        return $this->hasMany('App\Models\Bus', 'id');
    }
}
