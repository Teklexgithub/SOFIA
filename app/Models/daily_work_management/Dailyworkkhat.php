<?php

namespace App\Models\daily_work_management;
use Carbon\Carbon;
use Illuminate\Http\Request;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\user_management\User;
use App\Models\address_management\Branch;
use App\Models\material_management\Khat;

class Dailyworkkhat extends Model
{
    use HasFactory;
    protected $table = "daily_work_khat";
	protected $fillable = [
		"branch_id" ,"wede_branch_id", "lela_branch_yetelake" , "yetelake_amount" ,"type", "yemeta" , "total_khat" ,"yalew_khat", "yeteshete_khat" ,
		"is_deleted" , "birr" , "date" , "created_at" , "updated_at"
	];

	
	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}


	public function LelaBranch()
	{
		return $this->belongsTo(Branch::class,'wede_branch_id','id');
	}

	protected static function booted()
    {
		parent::booted();

		// Use an instance method call via the closure's parameter
		static::created(function ($dailyworkkhat) {
			$dailyworkkhat->checkAndUpdateAllSums(); // Call it on the instance
		});
	
		static::saved(function ($dailyworkkhat) {
			$dailyworkkhat->checkAndUpdateAllSums(); // Same here
		});
        static::updated(function ($dailyworkkhat) {
			$dailyworkkhat->checkAndUpdateAllSums(); // Same here
		});
	
		static::deleting(function ($dailyworkkhat) {
			$dailyworkkhat->checkAndUpdateAllSums(); // And here
		});
    }
    public function checkAndUpdateAllSums()
    {
        set_time_limit(180);
        $records = self::where('is_deleted', '0')->where('date', $this->date)->where('branch_id', $this->wede_branch_id)->where('type', $this->type)->get();

        foreach ($records as $record) {
            $record->checkAndUpdateSum();
            $record->save();
        }
    }

    public function checkAndUpdateSum()
    {
        
        $date = new Carbon($this->date);
        $dayBefore = $date->subDay()->toDateString();

        $yadere = self::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $this->branch_id)->where('type', $this->type)->first(['yalew_khat']); // Select only needed column
        $yadere_khat = $yadere ? $yadere->yalew_khat : 0;

        $yemeta = Yemetakhat::where('is_deleted', '0')->where('date', $this->date)->where('branch_id', $this->branch_id)
            ->whereHas('Khat', function ($query) {
                $query->where('selling_price', $this->type);
            })->sum('yemeta_khat');


        $kelela_yemeta = self::where('is_deleted', '0')->where('date', $this->date)->where('wede_branch_id', $this->branch_id)->where('type', $this->type)->sum('yetelake_amount');

        if($yemeta > 0){
            $yalew = $this->yalew_khat ?? 0;
            $yetelake_amount = $this->yetelake_amount ?? 0;

            $mikenesi_khat = $yetelake_amount + $yalew;
            $total_khat = $yemeta + $yadere_khat + $kelela_yemeta;

            $yeteshete_khat = $total_khat - $mikenesi_khat;
            $khat_type = $this->type;
            $birr = $khat_type * $yeteshete_khat;

            $this->yeteshete_khat = $yeteshete_khat;
            $this->total_khat = $total_khat;
            $this->birr = $birr;

        }

        
		

        
    }
	

	

}
