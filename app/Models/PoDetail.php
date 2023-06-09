<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PoDetail extends Model
{


     protected $table = 'po_detail';

     public $timestamps = false;
	//appends
	protected $appends = ['po_photo_url'];
	public function getPoPhotoUrlAttribute()
	{
		if($this->po_photo != null || $this->po_photo != '')
		{
    		return asset('public/uploads/po/compressed/'.$this->po_photo);
		}else{
			return '';
		}
	}

}