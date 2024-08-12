<?php

namespace App\Models\daily_work_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;
use App\Models\material_management\Softdrink;


class Dailyworksoftdrink extends Model
{
    use HasFactory;
    protected $table = "daily_work_soft_drink";
	protected $fillable = [
		"branch_id" ,"soft_drink_id" , "yetefeta" , "total_soft_drink" , "yeteshete_soft_drink" ,
		"is_deleted" ,"yadere_soft_drink" , "birr" , "date" , "created_at" , "updated_at"
	];

	

	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

	public function SoftDrink()
	{
		return $this->belongsTo(Softdrink::class,'soft_drink_id','id');
	}

}
