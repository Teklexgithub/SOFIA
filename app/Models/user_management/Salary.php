<?php

namespace App\Models\user_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user_management\Employee;

class Salary extends Model
{
    use HasFactory;
    protected $table = "salary";
	protected $fillable = [
		"employee_id" , "hired_date" , "salary_per_month" , "salary_total" , "credit" , "salary_left" ,
		"is_deleted" , "created_at" , "updated_at"
	];

    public function Employee()
	{
		return $this->belongsTo(Employee::class,'employee_id','id');
	}
	public function Credit()
	{
		return $this->hasMany(Employeecredit::class,'salary_id','id');
	}


}
