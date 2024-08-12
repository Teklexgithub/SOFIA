<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;
use App\Models\material_management\Khat;

class Yemetakhat extends Model
{
    use HasFactory;
    protected $table = "yemeta_khat";
	protected $fillable = [
		"branch_id" ,"khat_id" , "yemeta_khat" , "date" , "is_deleted"  , "created_at" , "updated_at"
	];

	

	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

	public function Khat()
	{
		return $this->belongsTo(Khat::class,'khat_id','id');
	}

}
