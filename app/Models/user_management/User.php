<?php

namespace App\Models\user_management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;

use App\Models\address_management\Branch;
use Spatie\Permission\Models\Role;
use App\Library\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait, HasRoles;


	protected $table = "users";
	protected $fillable = [
		"name" , "email" , "role_id", "email_verified_at" , "password" , "remember_token" , 
        "branch_id" , "status" ,"created_at" , "updated_at"
	];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
	

	public function Branch()
	{
		return $this->belongsTo(Branch::class,'branch_id','id');
	}
    public function Role()
	{
		return $this->belongsTo(role::class,'role_id','id');
	}

    public function Notifications() : HasMany
    {
        return $this->hasMany(Notification::class,'user_id','id');
    }


}
