<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Style extends Model
{
     //use SoftDeletes;

     protected $table = 'style';

     public $timestamps = true;
     public function PoDetails()
     {
         return $this->hasMany(PoDetail::class,'style_id','id');
     }
     public function AdditionalImage()
     {
         return $this->hasMany(AdditionalImages::class,'style_id','id');
     }
     public function Observation()
     {
         return $this->hasMany(Observations::class,'style_id','id');
     }
	 public function additional_images()
	 {
		 return $this->hasMany(AdditionalImages::class,'style_id','id');
	 }
	 protected $appends = ['aicQaImageUrl','factoryRepresentativeImageUrl'];
	 public function getaicQaImageUrlAttribute()
	 {
		if($this->aicQaImage != null || $this->aicQaImage != '')
		{
			return asset('public/uploads/aqi/compressed/'.$this->aicQaImage);
		}else{
			return '';
		}
	 }
	 public function getfactoryRepresentativeImageUrlAttribute()
	 {
		if($this->factoryRepresentativeImage != null || $this->factoryRepresentativeImage != '')
		{
			return asset('public/uploads/fri/compressed/'.$this->factoryRepresentativeImage);
		}else{
			return '';
		}
	 }
     


}