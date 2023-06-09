<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{


     protected $table = 'colors';

     public $timestamps = false;
     protected $appends = ['photo_url'];
	 public function getPhotoUrlAttribute()
	 {
		if($this->photo != null || $this->photo != '')
		{
			return asset('public/uploads/defect/compressed/'.$this->photo);
		}else{
			return '';
		}
	 }


}