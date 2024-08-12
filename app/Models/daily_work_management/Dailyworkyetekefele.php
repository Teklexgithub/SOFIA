<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;
use App\Models\daily_work_management\Dailyworkcredit;

class Dailyworkyetekefele extends Model
{
    use HasFactory;
    protected $table = "daily_work_yetekefele";
	protected $fillable = [
		"branch_id" ,"credit_id" ,"paid_amount" , "is_deleted" , "date" , "created_at" , "updated_at"
	];


	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

    public function Credit()
	{
		return $this->belongsTo(Dailyworkcredit::class,'credit_id','id');
	}

    
}
