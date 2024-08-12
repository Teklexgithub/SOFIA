<?php

namespace App\Models\address_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\user_management\User;

class Zone extends Model
{
	use HasFactory;

	protected $table = "zone";
	protected $fillable = [
		"name" , "region_id" , "created_at" , "updated_at"
	];

	public function Region()
	{
		return $this->belongsTo(Region::class,'region_id','id');
	}

    public function Woredas()
	{
		return $this->hasMany(Woreda::class,'zone_id','id');
	}

}
