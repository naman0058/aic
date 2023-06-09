<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Trim extends Model
{
     //use SoftDeletes;

     protected $table = 'trim';

     public $timestamps = false;
     protected $appends = ['trim_image_url'];
	 public function getTrimImageUrlAttribute()
	 {
		if($this->trim_image != null || $this->trim_image != '')
		{
			return asset('public/uploads/trim/compressed/'.$this->trim_image);
		}else{
			return '';
		}
	 }


}