<?php

namespace App\Models\material_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Softdrink extends Model
{
    use HasFactory;
    protected $table = "soft_drink";
	protected $fillable = [
		"name" , "price", "number_in_pack" , "status" , "is_deleted"  , "created_at" , "updated_at"
	];

    
}
