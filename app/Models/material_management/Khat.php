<?php

namespace App\Models\material_management;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\user_management\User;
use App\Models\daily_work_management\Yemetakhat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class khat extends Model
{
    use HasFactory;
    protected $table = "khat";
	protected $fillable = [
		"name" , "buying_price" , "selling_price" , "status" , "is_deleted" ,  "created_at" , "updated_at"
	];

	public function Yemeta()
	{
		return $this->hasMany(Yemetakhat::class,'khat_id','id');
	}


}
