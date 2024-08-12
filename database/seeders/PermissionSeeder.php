<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission Seeder
        $permissions = [
            'view users', 'view role', 'view employee', 'view employee salary',
            'view employee credit', 'view region', 'view zone', 'view woreda', 
            'view branch', 'view khat', 'view soft drink', 'view cigarate', 
            'view lozi', 'view store', 'view yemeta khat','view khat hisabi',
            'view soft drink hisabi', 'view lozi hisabi', 'view cigarate hisabi', 'view account', 
            'view credit', 'view yetekefele','view woci', 'view gudilet', 'view birr', 'view branch report',
            'view exporter report', 'view deleted file',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // Creating Role
        $roles = [
                        'admin' => ['view users', 'view role', 'view employee', 'view employee salary',
                                    'view employee credit', 'view region', 'view zone', 'view woreda', 
                                    'view branch', 'view khat', 'view soft drink', 'view cigarate', 
                                    'view lozi', 'view store', 'view yemeta khat','view khat hisabi',
                                    'view soft drink hisabi', 'view lozi hisabi', 'view cigarate hisabi', 'view account', 
                                    'view credit', 'view yetekefele','view woci','view gudilet', 'view birr', 'view branch report',
                                    'view exporter report', 'view deleted file'
                                    ],
            
                ];

        foreach ($roles as $role => $rolePermissions) {
            $roleInstance = Role::create(['name' => $role]);
            $roleInstance->givePermissionTo($rolePermissions);
        }

        $adminUser = User::create([
            'name' => 'Mubarek Nasir',
            'email' => 'mubarek@gmail.com',
            'password' => bcrypt('mube125126'), // use a secure way to handle passwords in real applications
        ]);

        // Assign the admin role to the user
        // $adminUser->assignRole('admin');
        // $adminUser.role_id->$roleInstance.id;
        // $adminUser->syncPermissions(Permission::all());

        $adminRole = Role::where('name', 'admin')->first();
        $adminUser->assignRole($adminRole);

        // Optional: Directly set the role_id if the column exists in the users table
        if (Schema::hasColumn('users', 'role_id')) {
            $adminUser->role_id = $adminRole->id;
            $adminUser->save();
        }
        $adminUser->syncPermissions($adminRole->permissions);



    }
}
