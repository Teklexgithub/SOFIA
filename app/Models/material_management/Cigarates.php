<?php

namespace App\Models\material_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class cigarates extends Model
{
    use HasFactory;
    protected $table = "cigarates";
	protected $fillable = [
		"name" , "half_price" , "packet_price", "number_in_pack" , "is_deleted" ,"status" ,  "created_at" , "updated_at"
	];


   }
