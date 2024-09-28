<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graf extends Model
{
    use HasFactory;
    protected $table = 'graf';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['start','end','rute'];
    
    public function Start()
    {
     return $this->belongsTo('App\Models\Node', 'start','id');  
    }

    public function End()
    {
     return $this->belongsTo('App\Models\Node', 'end','id');  
    }
    
}

