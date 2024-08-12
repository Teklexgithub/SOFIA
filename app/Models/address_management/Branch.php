<?php

namespace App\Models\address_management;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\user_management\User;

class Branch extends Model
{
	use HasFactory;

	protected $table = "branch";
	protected $fillable = [
		"name" ,"phone_number_1" , "phone_number_2" , "woreda_id" , "location", "status"
		 , "created_at" , "updated_at"
	];

	

	public function Woreda()
	{
		return $this->belongsTo(Woreda::class,'woreda_id','id');
	}

	
    

}
