<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;
use App\Models\material_management\Lozi;


class Dailyworklozi extends Model
{
    use HasFactory;
    protected $table = "daily_work_lozi";
	protected $fillable = [
		"branch_id" ,"lozi_id" , "yemeta" , "total_lozi" , "yeteshete_lozi" ,
		"yadere_lozi" , "birr" ,  "date" , "is_deleted" , "created_at" , "updated_at"
	];

	

	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

	public function Lozi()
	{
		return $this->belongsTo(Lozi::class,'lozi_id','id');
	}

}
