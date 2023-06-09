<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AdditionalImages extends Model
{
     //use SoftDeletes;

     protected $table = 'additional_images';

     public $timestamps = false;
     protected $appends = ['additional_image_url'];
	 public function getAdditionalImageUrlAttribute()
	 {
		if($this->additional_image != null || $this->additional_image != '')
		{
			return asset('public/uploads/additional/compressed/'.$this->additional_image);
		}else{
			return '';
		}
	 }


}