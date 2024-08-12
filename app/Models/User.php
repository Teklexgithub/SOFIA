<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\address_management\Branch;
use Spatie\Permission\Models\Role;
use App\Models\user_management\Notification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "users";
	protected $fillable = [
		"name" , "email" , "role_id", "email_verified_at" , "password" , "remember_token" , 
        "branch_id" , "status" ,"created_at" , "updated_at"
	];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

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
     public function isActive()
     {
         return $this->status == 1;
     }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
