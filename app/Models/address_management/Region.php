<?php

namespace App\Models\address_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\user_management\User;
use App\Models\address_management\Zone;

class Region extends Model
{
	use HasFactory;

	protected $table = "region";
	protected $fillable = [
		"name" , "type" , "created_at" , "updated_at"
	];

	
    public function Zones()
	{
		return $this->hasMany(Zone::class,'region_id','id');
	}


}
