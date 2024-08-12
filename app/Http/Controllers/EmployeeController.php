<?php

namespace App\Http\Controllers;

use App\Models\user_management\Employee;
use App\Models\user_management\Salary;
use App\Models\user_management\Employeecredit;
use App\Models\User;
use App\Models\address_management\Region;
use App\Models\address_management\Zone;
use App\Models\address_management\Woreda;
use App\Models\address_management\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use DB;
use DataTables;
use Validator;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function view_employee(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = Employee::where('is_deleted','0')->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                    return $data->name;                 
            })
            ->addColumn('phone_no', function($data){
                    return $data->phone_no;                      
            })
            ->addColumn('branch_id', function($data){
                return $data->Branch->name;                      
            })  
            ->addColumn('action', function($data){
               
                $button = '   <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                $button .= '  <button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i> Edit</button>';
                $button .= '  <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
                
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('employees.employee.index');


    }
    public function create_employee()
    {
        

    }
   

    public function store_employee(Request $request)
    {
        $rules = array(
            'name'               => ['required','regex:/^[A-Za-z\s\-_]{2,255}$/'],
            'branch_id'          => 'required',
            'woreda_id'          => 'required',
            'kebele'             => ['required','regex:/^[A-Za-z\s\d\-_]{2,255}$/'],
            'phone_no'           => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
            'broker_name'        => ['required','regex:/^[A-Za-z\s\-_]{2,255}$/'],
            'broker_phone_no'    => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
            'guarantor'          => ['required','regex:/^[A-Za-z\s\-_]{2,255}$/'],
            'guarantor_phone_no' => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
            'work_type'          => 'required',
            'employee_id_card'   => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'guarantor_id_card'  => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'guarantor_form'     => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048'
            

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       

            $fullpath1 = null;
            $fullpath2 = null;
            $fullpath3 = null;
        if ($request->hasFile('employee_id_card')) {
            $folder_1 = "employee_document";
            $randomname1 = Str::random(20);
            $filename1 = $randomname1 . '.' . $request->file('employee_id_card')->getClientOriginalExtension();
            $path1 = $request->file('employee_id_card')->storeAs('employee/' . $folder_1, $filename1, 'public');
            $fullpath1 = '/storage/' . $path1;
            
        }

        if ($request->hasFile('guarantor_id_card')) {
            $folder_2 = "employee_document";
            $randomname2 = Str::random(20);
            $filename2 = $randomname2 . '.' . $request->file('guarantor_id_card')->getClientOriginalExtension();
            $path2 = $request->file('guarantor_id_card')->storeAs('guarantor/' . $folder_2, $filename2, 'public');
            $fullpath2 = '/storage/' . $path2;
            
        }

        if ($request->hasFile('guarante_form')) {
            $folder_3 = "employee_document";
            $randomname3 = Str::random(20);
            $filename3 = $randomname3 . '.' . $request->file('guarante_form')->getClientOriginalExtension();
            $path3 = $request->file('guarante_form')->storeAs('form/' . $folder_3, $filename3, 'public');
            $fullpath3 = '/storage/' . $path3;
            
        }

        
        
        $form_data = array(
            'name'               => $request->name,
            'branch_id'          => $request->branch_id,
            'woreda_id'          => $request->woreda_id,
            'kebele'             => $request->kebele,
            'phone_no'           => $request->phone_no,
            'broker_name'        => $request->broker_name,
            'broker_phone_no'    => $request->broker_phone_no,
            'guarantor'          => $request->guarantor,
            'guarantor_phone_no' => $request->guarantor_phone_no,
            'work_type'          => $request->work_type,    
            'employee_id_card'   => $fullpath1,
            'guarantor_id_card'  => $fullpath2,
            'guarantor_form'     => $fullpath3
        );
       
 
        Employee::create($form_data);
 
        return response()->json(['success' => 'Employee Added successfully.']);

       

       
    }

    public function show_employee(Request $request, $id)
    {
        $attribute = Employee::findOrFail($id);
        $branchname = $attribute->Branch->name;
        $woredaname = $attribute->Woreda->name;
        // $branchname = Branch::where('id',$attribute->branch_id)->value('name');
        // $woredaname = Woreda::where('id',$attribute->occ_id)->value('name');
        
        return response()->json([
            'attribute' => $attribute,
            'branchname' => $branchname,
            'woredaname' => $woredaname
            
        ]);
       

    }
    
    public function edit_employee($id)
    {
        if(request()->ajax())
        {
            $data = Employee::findOrFail($id);
            $zone_id = $data->Woreda->zone_id;
            $region_id = Zone::where('id',$zone_id)->value('region_id');
            return response()->json([
                'result'    => $data,
                'region_id' => $region_id,
                'zone_id'   => $zone_id
            ]);
        }

    }
    public function update_employee(Request $request)
    {
        $rules = array(
            'name'               => ['required','regex:/^[A-Za-z\s\-_]{2,255}$/'],
            'branch_id'          => 'required',
            'woreda_id'          => 'required',
            'kebele'             => 'required|regex:/^[A-Za-z\s\d\-_]{2,255}$/',
            'phone_no'           => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
            'broker_name'        => ['required','regex:/^[A-Za-z\s\-_]{2,255}$/'],
            'broker_phone_no'    => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
            'guarantor'          => ['required','regex:/^[A-Za-z\s\-_]{2,255}$/'],
            'guarantor_phone_no' => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
            'work_type'          => 'required',
            'employee_id_card'   => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'guarantor_id_card'  => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'guarantor_form'     => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:2048'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $employee = Employee::findOrFail($request->hidden_id);

            $employee->name               = $request->name;
            $employee->branch_id          = $request->branch_id;
            $employee->woreda_id          = $request->woreda_id;
            $employee->kebele             = $request->kebele;
            $employee->phone_no           = $request->phone_no;
            $employee->broker_name        = $request->broker_name;
            $employee->broker_phone_no    = $request->broker_phone_no;
            $employee->guarantor          = $request->guarantor;
            $employee->guarantor_phone_no = $request->guarantor_phone_no;
            $employee->work_type          = $request->work_type;
           
            
           
        if ($request->hasFile('employee_id_card')) {
            $folder_1 = "employee_document";
            $randomname1 = Str::random(20);
            $filename1 = $randomname1 . '.' . $request->file('employee_id_card')->getClientOriginalExtension();
            $path1 = $request->file('employee_id_card')->storeAs('employee/' . $folder_1, $filename1, 'public');
            $fullpath1 = '/storage/' . $path1;
            $employee->employee_id_card  = $fullpath1;
            
            
            
        }
    
        if ($request->hasFile('guarantor_id_card')) {
            $folder_2 = "employee_document";
            $randomname2 = Str::random(20);
            $filename2 = $randomname2 . '.' . $request->file('guarantor_id_card')->getClientOriginalExtension();
            $path2 = $request->file('guarantor_id_card')->storeAs('guarantor/' . $folder_2, $filename2, 'public');
            $fullpath2 = '/storage/' . $path2;
            $employee->guarantor_id_card  = $fullpath2;
            
            
        }
    
        if ($request->hasFile('guarante_form')) {
            $folder_3 = "employee_document";
            $randomname3 = Str::random(20);
            $filename3 = $randomname3 . '.' . $request->file('guarante_form')->getClientOriginalExtension();
            $path3 = $request->file('guarante_form')->storeAs('form/' . $folder_3, $filename3, 'public');
            $fullpath3 = '/storage/' . $path3;
            $employee->guarante_form     = $fullpath3;
            
        }

        $employee->save();
 
        return response()->json(['success' => 'Employee Updated successfully.']);


    }
    public function delete_employee($id)
    {
        // $data = Employee::findOrFail($id);
        // $data->delete();

        $getDeleted = Employee::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Employee::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);

    }
        // Salary Function
    public function view_salary(Request $request)
     {
         if ($request->ajax()) {
             $N = 1;
             $data = Salary::all();
             return Datatables::of($data)->addIndexColumn()
             ->addColumn('number', function($data) use(&$N){
                     return $N++;                      
              })
             ->addColumn('employee_id', function($data){
                 return $data->Employee->name;                  
             })
             ->addColumn('salary_per_month', function($data){
                return $data->salary_per_month;                  
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
  
         return view('employees.salary.index');
     }
 
    
     public function create_salary()
     {
         
     }
 
     
     public function store_salary(Request $request)
     {
         $rules = array(
             'employee_id'      => 'required',
             'salary_per_month' => 'required|regex:/^\d+(\.\d+)?$/',
             'hired_date'       => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
         );
 
         
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }

          // Calculate the number of months worked
            $hired_date = new \DateTime($request->hired_date);
            $current_date = new \DateTime();    
            $interval = $current_date->diff($hired_date);
            $total_days_worked = $interval->days;
            $salary_per_month = $request->salary_per_month;
            $daily_rate = $salary_per_month / 30; // Assuming each month has 30 days
            $salary_total = round($daily_rate * $total_days_worked);

            
                    
        
         $form_data = array(
             'employee_id'       =>  $request->employee_id,
             'salary_per_month'  =>  $request->salary_per_month,
             'hired_date'        =>  $request->hired_date,
             'salary_total'      =>  $salary_total,
             'salary_left'       =>  $salary_total
             
         );
  
         $salary = Salary::create($form_data);
        //  $credit = Employeecredit::where('salary_id', $salary->id)->all();
        //  $total_credit = $credits->sum('credit');
        //  $remaining_balance = $salary->salary_total - $total_credit;
        //  $salary->update(['salary_left' => $remaining_balance]);
         
  
         return response()->json(['success' => 'Salary Added successfully.']);
 
     }
 
     
     public function show_salary(Request $request, $id)
     {
         $attribute = Salary::findOrFail($id);
         $employename = $attribute->Employee->name;
         return response()->json([
             'attribute' => $attribute,
             'employename' => $employename
             
         ]);
     }
 
     
     public function edit_salary($id)
     {
         if(request()->ajax())
         {
             $data = Salary::findOrFail($id);
             return response()->json([
                'result' => $data
            ]);
         }
     }
 
     
     public function update_salary(Request $request)
     {
         $rules = array(
            'employee_id'      => 'required',
            'salary_per_month' => 'required|regex:/^\d+(\.\d+)?$/',
            'hired_date'       => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
         );
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }

         // Calculate the number of months worked
         $hired_date = new \DateTime($request->hired_date);
         $current_date = new \DateTime();    
         $interval = $current_date->diff($hired_date);
         $total_days_worked = $interval->days;
         $salary_per_month = $request->salary_per_month;
         $daily_rate = $salary_per_month / 30; // Assuming each month has 30 days
         $salary_total = round($daily_rate * $total_days_worked);
         
        
         $form_data = array(
            'employee_id'       =>  $request->employee_id,
            'salary_per_month'  =>  $request->salary_per_month,
            'hired_date'        =>  $request->hired_date,
            'salary_total'      =>  $salary_total,
            'salary_left'       =>  $salary_total
         );
  
         Salary::whereId($request->hidden_id)->update($form_data);
  
         return response()->json(['success' => 'Salary is successfully updated']);
 
     }
 
     
     public function delete_salary($id)
     {
        //  $data = Salary::findOrFail($id);
        //  $data->delete();

         $getDeleted = Salary::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Salary::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
     }

     // Employee Credit Function
     public function view_credit(Request $request)
     {
         if ($request->ajax()) {
             $N = 1;
             $data = Employeecredit::all();
             return Datatables::of($data)->addIndexColumn()
             ->addColumn('number', function($data) use(&$N){
                     return $N++;                      
              })
             ->addColumn('salary_id', function($data){
                 return $data->Salary->Employee->name;                  
             })
             ->addColumn('credit', function($data){
                return $data->credit;                  
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
  
         return view('employees.employee_credit.index');
     }
 
    
     public function create_credit()
     {
         
     }
 
     
     public function store_credit(Request $request)
     {
         $rules = array(
             'salary_id' => 'required',
             'credit'    => 'required|regex:/^\d+(\.\d+)?$/',
             'reason'    => 'nullable|regex:/^[A-Za-z\s\d\-_]{2,255}$/',
             'date'      => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
         );
 
         
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         
        
         $form_data = array(
             'salary_id' =>  $request->salary_id,
             'credit'    =>  $request->credit,
             'reason'    =>  $request->reason,
             'date'      =>  $request->date
             
         );
  
         $credit = Employeecredit::create($form_data);
         $credit = $credit->fresh();
         $credit->save();
  
         return response()->json(['success' => 'Credit Added successfully.']);
 
     }
 
     
     public function show_credit(Request $request, $id)
     {
         $attribute = Employeecredit::findOrFail($id);
         $employename = $attribute->Salary->Employee->name;
         return response()->json([
             'attribute' => $attribute,
             'employename' => $employename
             
         ]);
     }
 
     
     public function edit_credit($id)
     {
         if(request()->ajax())
         {
             $data = Employeecredit::findOrFail($id);
             return response()->json([
                'result' => $data
            ]);
         }
     }
 
     
     public function update_credit(Request $request)
     {
         $rules = array(
            'salary_id' => 'required',
            'credit'    => 'required|regex:/^\d+(\.\d+)?$/',
            'reason'    => 'nullable|regex:/^[A-Za-z\s\d\-_]{2,255}$/',
            'date'      => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
         );
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         
        
         $form_data = array(
            'salary_id' =>  $request->salary_id,
            'credit'    =>  $request->credit,
            'reason'    =>  $request->reason,
            'date'      =>  $request->date
         );
  
        //  Employeecredit::whereId($request->hidden_id)->update($form_data);
         $credit = Employeecredit::find($request->hidden_id);
         $credit->update($form_data);
         $credit = $credit->fresh();
         $credit->save();
  
         return response()->json(['success' => 'Credit is successfully updated']);
 
     }
 
     
     public function delete_credit($id)
     {
        //  $data = Employeecredit::findOrFail($id);
        //  $data->delete();
        $getDeleted = Employeecredit::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Employeecredit::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
        
     }
 
 



}
