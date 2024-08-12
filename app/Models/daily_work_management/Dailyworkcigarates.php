<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;
use App\Models\material_management\Cigarates;

class Dailyworkcigarates extends Model
{
    use HasFactory;
    protected $table = "daily_work_cigarates";
	protected $fillable = [
		"branch_id" ,"cigarates_id" , "yetekefete_cigarates" , "total_cigarates" , "yeteshete_cigarates" ,
		"is_deleted" ,"yadere_packet", "yadere_half" , "birr" , "date" , "created_at" , "updated_at"
	];

	
	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

	public function Cigarates()
	{
		return $this->belongsTo(Cigarates::class,'cigarates_id','id');
	}

}
