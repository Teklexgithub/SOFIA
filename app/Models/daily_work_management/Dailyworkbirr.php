<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;


class Dailyworkbirr extends Model
{
    use HasFactory;
    protected $table = "daily_work_birr";
	protected $fillable = [
		"branch_id" ,"cash_birr" , "zirzir_birr" , "date" , "is_deleted" , "created_at" , "updated_at"
	];


	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

    

}
