<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve permissions data from your database
        $permissions = Permission::all();

        // Group permissions based on the last word of their names
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $lastWord = explode(' ', $permission->name);
            $lastWord = end($lastWord);

            // Check if the last word exists as a key in the groupedPermissions array
            if (!isset($groupedPermissions[$lastWord])) {
                $groupedPermissions[$lastWord] = [];
            }

            // Add the permission to the corresponding group
            $groupedPermissions[$lastWord][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                // Add more fields if needed
            ];
        }

        // Arrange permissions into rows with four columns
        $tableData = [];
        $row = [];
        $columnCount = 0;
        foreach ($groupedPermissions as $permissions) {
            foreach ($permissions as $permission) {
                $row[] = $permission;
                $columnCount++;

                // If we reach 4 permissions in the row, start a new row
                if ($columnCount == 4) {
                    $tableData[] = $row;
                    $row = [];
                    $columnCount = 0;
                }
            }
        }

        // If there are remaining permissions, add them to the last row
        if (!empty($row)) {
            $tableData[] = $row;
        }

        // Return the grouped and formatted permissions data as JSON
        return response()->json(['data' => $tableData]);
        
    }

    // Permission Functions
    public function view_permission(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = permission::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('users.permissions.index');
    }

    public function store_permission(Request $request)
    {
        $rules = array(
            'name' => 'required|string|unique:permissions,name'
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'name'        =>  $request->name
           
        );
 
        permission::create($form_data);
 
        return response()->json(['success' => 'Permission Added successfully.']);
  
      
    }

    
    public function show_permission(Request $request, $id)
    {
        $attribute = permission::findOrFail($id);
        return response()->json([
            'attribute' => $attribute
            
        ]);
        
    }

    
    public function edit_permission($id)
    {
        if(request()->ajax())
        {
            $data = permission::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    
    public function update_permission(Request $request)
    {
        $rules = array(
            'name' => 'required|string|unique:permissions,name,'.$request->hidden_id
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
    
        $form_data = array(
            'name'         =>  $request->name
            
        );
 
        permission::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Permission is successfully updated']);
    }

    
    public function delete_permission($id)
    {

        $data = permission::findOrFail($id);
        $data->delete();
        
    }

    // Role Functions

    public function view_role(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = role::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('users.roles.index');
    }

    public function store_role(Request $request)
    {
        $rules = array(
            'name' => 'required|string|unique:roles,name'
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        
       
        $form_data = array(
            'name'        =>  $request->name
           
        );
 
        $role = Role::create($form_data); 
        $roleId = $role->id;

        
        $checkedPermissions = $request->input('permissions', []);

        
        foreach ($checkedPermissions as $permissionId) {
            // Check if the permission ID is valid (optional)
            $permission = Permission::find($permissionId);
            if ($permission) {
                // Attach the permission to the role
                $role->permissions()->attach($permissionId);
            }
        }
 
        return response()->json(['success' => 'Role Added Successfully.']);
  
      
    }

    
    public function show_role(Request $request, $id)
    {
        $attribute = Role::findOrFail($id);
        $permissions = $attribute->permissions()->get();
        return response()->json([
            'attribute' => $attribute,
            'permissions' => $permissions
            
        ]);
        
    }

    
    public function edit_role($id)
    {
        if(request()->ajax())
        {
            $data = Role::findOrFail($id);

        // Get all permissions available
        $permissions = Permission::all();

        // Group permissions based on the last word of their names
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $lastWord = explode(' ', $permission->name);
            $lastWord = end($lastWord);

            // Check if the last word exists as a key in the groupedPermissions array
            if (!isset($groupedPermissions[$lastWord])) {
                $groupedPermissions[$lastWord] = [];
            }

            // Add the permission to the corresponding group
            $groupedPermissions[$lastWord][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'checked' => $data->permissions->contains('id', $permission->id) ? true : false
                // Add more fields if needed
            ];
        }

        // Arrange permissions into rows with four columns
        $tableData = [];
        $row = [];
        $columnCount = 0;
        foreach ($groupedPermissions as $permissions) {
            foreach ($permissions as $permission) {
                $row[] = $permission;
                $columnCount++;

                // If we reach 4 permissions in the row, start a new row
                if ($columnCount == 4) {
                    $tableData[] = $row;
                    $row = [];
                    $columnCount = 0;
                }
            }
        }

        // If there are remaining permissions, add them to the last row
        if (!empty($row)) {
            $tableData[] = $row;
        }

        // Return the role, grouped permissions, and role permissions as JSON
        return response()->json([
            'result' => $data,
            'groupedPermissions' => $tableData
        ]);

            
        }
    }

    
    public function update_role(Request $request)
    {
        $rules = array(
            'name' => 'required|string|unique:roles,name,'.$request->hidden_id
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
    
        $form_data = array(
            'name'         =>  $request->name
            
        );
    
        // $role = Role::whereId($request->hidden_id)->update($form_data);
        // $role->permissions()->sync($request->permissions);
        $role = Role::findOrFail($request->hidden_id);
        $role->update($form_data);
        $role->permissions()->sync($request->permissions);
        
        return response()->json(['success' => 'Role is successfully updated']);
    }

    
    public function delete_role($id)
    {

        $data = role::findOrFail($id);
        $data->delete();
        $data->permissions()->detach();
        
    }


    // User Functions

    public function view_user(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $user_id = Auth::id();
            // $data = User::all();
            // $data = User::where('id', '!=', $user_id)->get();
            $data = User::whereNotIn('id', [$user_id])->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('branch_id', function($data){
                if ($data->Branch && $data->Branch->name) {
                    return $data->Branch->name;
                    }else{
                        return '-'; 
                    }
                                         
            })
            ->addColumn('status', function($data){
                if($data->status==1)
                {
                    $button = '<div class="form-check form-switch">
                                    <input class="status form-check-input" type="checkbox" name="status" data-id="'.$data->id.'" checked>
                                    <label style="color: blue;">active</label>
                                </div>';
                    return $button;
                }
                else
                {
                    $button = '<div class="form-check form-switch">
                                    <input class="status form-check-input" type="checkbox" name="status" data-id="'.$data->id.'" unchecked>
                                    <label style="color: red;">deactive</label>
                                </div>';
                    return $button;
                }
            })
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
 
        return view('users.user.index');
    }

    public function store_user(Request $request)
    {
        $rules = array(
            'name'      => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'email'     => 'required|string|unique:users,email',
            'branch_id' => 'required',
            'role_id'   => 'required|exists:roles,id'
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $password = Hash::make('12345678');
       
        $form_data = array(
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'role_id'   =>  $request->role_id,
            'branch_id' =>  $request->branch_id,
            'password'  =>  $password
           
        );

 
        $user = User::create($form_data); 
        $role = Role::findById($request->role_id);
        $user->assignRole($role);

        $rolePermissions = $role->permissions; 
        $user->syncPermissions($rolePermissions); 
        
 
        return response()->json(['success' => 'User Added successfully.']);
  
      
    }

    
    public function show_user(Request $request, $id)
    {
        $attribute = User::findOrFail($id);
        if ($attribute->Branch && $attribute->Branch->name) {
            $branchname = $attribute->Branch->name;
            }else{
                $branchname = '-'; 
            }
        if ($attribute->Role && $attribute->Role->name) {
            $rolename = $attribute->Role->name;
            }else{
                $rolename = '-'; 
            }
        return response()->json([
            'attribute'  => $attribute,
            'rolename'   => $rolename,
            'branchname' => $branchname
            
        ]);
        
    }

    
    public function edit_user($id)
    {
        if(request()->ajax())
        {
            $data = User::findOrFail($id);

            return response()->json([
                'result' => $data
                
            ]);

            
        }
    }

    
    public function update_user(Request $request)
    {
        $rules = array(
            'email'     => 'required|string|unique:users,email,'.$request->hidden_id,
            'name'      => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'branch_id' => 'required',
            'role_id'   => 'required|exists:roles,id'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $password = Hash::make('12345678');
        $form_data = array(
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'role_id'   =>  $request->role_id,
            'branch_id' =>  $request->branch_id
            
        );

        if ($request->has('password') && !empty($request->password)) {
            $form_data['password'] = Hash::make($request->password);
        }
    
        $user = User::whereId($request->hidden_id)->first();
        $user->update($form_data);
        $role = Role::findById($request->role_id);
        $user->syncRoles(Role::findById($request->role_id));

        $rolePermissions = $role->permissions; 
        $user->syncPermissions($rolePermissions);

        // $user = User::create($form_data); 
        // $role = Role::findById($request->role_id);
        // $user->assignRole($role);

        // $rolePermissions = $role->permissions; 
        // $user->syncPermissions($rolePermissions); 
       
        
        
        return response()->json(['success' => 'User is successfully updated']);
    }

    
    public function delete_user($id)
    {

        $data = User::findOrFail($id);
        if (method_exists($data, 'roles')) {
            $data->roles()->detach();
            $data->Permissions()->detach();
        }
        $data->delete();
        
        
    }
    
    public function changeStatusUser(Request $request){
       
        $id = $request->input('id');
        $getStatus = User::select('status')->where('id',$id)->first();
        // Retrieve the record from the database
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        // Toggle the status
        $getStatus->save();
        
        User::where('id',$id)->update(['status' => $status]);
        // Return the new status as a JSON response
        return response()->json([
            'success' => true
        ]);

        }





   
}
