<?php

namespace App\Models\user_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\address_management\Branch;
use App\Models\address_management\Woreda;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employee";
	protected $fillable = [
		"name" , "woreda_id" , "branch_id" , "kebele" , "phone_no" , "broker_name" , "broker_phone_no" ,
		"guarantor" , "guarantor_phone_no" , "employee_id_card" , "guarantor_id_card" ,
		"guarante_form" , "work_type" , "is_deleted" , "created_at" , "updated_at"
	];


    public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}
    public function Woreda()
	{
		return $this->belongsTo(Woreda::class,'woreda_id','id');
	}

	

}
