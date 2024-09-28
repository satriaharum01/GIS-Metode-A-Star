<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;
    protected $table = 'node';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['latitude','longitude'];
    
    public function Graf()
    {
     return $this->hasMany('App\Models\Graf', 'id');  
    }

    public function Halte()
    {
     return $this->hasMany('App\Models\Halte', 'id');  
    }

}

