<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class PackImages extends Model
{
     //use SoftDeletes;

     protected $table = 'packimages';

     public $timestamps = false;
     protected $appends = ['packimage_url'];
	 public function getPackImageUrlAttribute()
	 {
		if($this->packimage != null || $this->packimage != '')
		{
			return asset('public/uploads/packimage/compressed/'.$this->packimage);
		}else{
			return '';
		}
	 }


}