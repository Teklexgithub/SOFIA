<?php

namespace App\Models\user_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user_management\Salary;

class Employeecredit extends Model
{
    use HasFactory;
    protected $table = "employee_credit";
	protected $fillable = [
		"salary_id" , "credit" , "reason", "date" ,"is_deleted" , "created_at" , "updated_at"
	];

    public function Salary()
	{
		return $this->belongsTo(Salary::class,'salary_id','id');
	}

	protected static function boot()
    {
        parent::boot();

        // Event listener for the created event
        static::created(function ($credit) {
            $credit->updateSalaryLeft();
        });

        // Event listener for the updated event
        static::saved(function ($credit) {
			$credit->updateSalaryLeft();
		});
        // Event listener for the deleted event
        static::deleted(function ($credit) {
            $credit->updateSalaryLeft();
        });
    }

    // Method to update salary_left field
    public function updateSalaryLeft()
    {
        // Retrieve the associated salary
        $salary = $this->Salary;

        // Calculate the total credit for the salary
        $total_credit = $salary->Credit->sum('credit');

        // Calculate the remaining balance
        $remaining_balance = $salary->salary_total - $total_credit;

        // Update the salary_left field
        $salary->update(['salary_left' => $remaining_balance]);
    }





}
