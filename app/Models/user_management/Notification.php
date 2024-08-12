<?php

namespace App\Models\user_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Notification extends Model
{
	use HasFactory;

	protected $table = "notification";
	protected $fillable = [
		"user_id" , "message" , "is_seen" , "created_at" , "updated_at"
	];

	public function User()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}

}