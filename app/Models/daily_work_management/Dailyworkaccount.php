<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;



class Dailyworkaccount extends Model
{
    use HasFactory;
    protected $table = "daily_work_account";
	protected $fillable = [
		"branch_id" ,"type" , "name" , "birr_amount" , "date" , "is_deleted" , "created_at" , "updated_at"
	];
	

	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

    


}
