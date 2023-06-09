<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Observations extends Model
{


     protected $table = 'observations';

     public $timestamps = false;
     
    public function Color()
     {
         return $this->hasMany(Colors::class,'defect_id','id');
     }
	public function colors()
	{
		return $this->hasMany(Colors::class,'defect_id','id');
	}

}