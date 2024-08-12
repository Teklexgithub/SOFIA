<?php

namespace App\Models\material_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\address_management\Branch;
use App\Models\material_management\Softdrink;
use App\Models\material_management\Cigarates;

class store extends Model
{
    use HasFactory;
    protected $table = "store";
	protected $fillable = [
		"branch_id" , "material_type" , "soft_drink_id" , "cigarates_id" , "number" , "is_deleted" , "created_at" , "updated_at"
	];

    

    public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}

    public function SoftDrink()
	{
		return $this->belongsTo(Softdrink::class,'soft_drink_id','id');
	}

    public function Cigarates()
	{
		return $this->belongsTo(Cigarates::class,'cigarates_id','id');
	}
	


}
