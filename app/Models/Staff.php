<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Class Staff extends Model{

     use SoftDeletes;

     protected $table = 'staff';
     protected $primaryKey = 'id';

     public $timestamps = true;

     protected $dates = ['deleted_at'];

   

}
?>