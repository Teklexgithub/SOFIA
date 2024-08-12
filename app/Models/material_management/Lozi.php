<?php

namespace App\Models\material_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class lozi extends Model
{
    use HasFactory;
    protected $table = "lozi";
	protected $fillable = [
		"name" , "price" , "status"  , "is_deleted" ,  "created_at" , "updated_at"
	];

    
}
