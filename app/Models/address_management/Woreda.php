<?php

namespace App\Models\address_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\user_management\User;

class Woreda extends Model
{
	use HasFactory;

	protected $table = "woreda";
	protected $fillable = [
		"name" , "zone_id" , "created_at" , "updated_at"
	];

	public function Zone()
	{
		return $this->belongsTo(Zone::class,'zone_id','id');
	}

	

}