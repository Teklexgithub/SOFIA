<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;


class Dailyworkwoci extends Model
{
    use HasFactory;
    protected $table = "daily_work_woci";
	protected $fillable = [
		"name" ,"branch_id" ,"birr_amount" , "is_deleted" , "date" , "created_at" , "updated_at"
	];

	
	

	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

	
}
