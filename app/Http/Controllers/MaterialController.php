<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\material_management\Khat;
use App\Models\material_management\Softdrink;
use App\Models\material_management\Cigarates;
use App\Models\material_management\Lozi;
use App\Models\material_management\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use DB;
use DataTables;
use Validator;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // Function of Khat
    public function view_khat(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = Khat::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('selling_price', function($data){
                return $data->selling_price;                      
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
 
        return view('material.khat.index');
    }

   
    public function create_khat()
    {
        
    }

    
    public function store_khat(Request $request)
    {
        $rules = array(
            'name'          => 'required|unique:khat,name',
            'buying_price'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
       
        $form_data = array(
            'name'          => $request->name,
            'buying_price'  => $request->buying_price,
            'selling_price' => $request->selling_price
        );
 
        Khat::create($form_data);
 
        return response()->json(['success' => 'Khat Added successfully.']);
  
      
    }

    
    public function show_khat(Request $request, $id)
    {
        $attribute = Khat::findOrFail($id);
       
        return response()->json([
            'attribute' => $attribute
            
        ]);
        
    }

    
    public function edit_khat($id)
    {
        if(request()->ajax())
        {
            $data = Khat::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_khat(Request $request)
    {
        $rules = array(
            
            'name' => 'required|unique:khat,name,'.$request->hidden_id,
            'buying_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'name'          =>  $request->name,
            'buying_price'  =>  $request->buying_price,
            'selling_price' =>  $request->selling_price
        );
 
        Khat::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Khat is successfully updated']);
    }

    
    public function delete_khat($id)
    {
        $data = Khat::findOrFail($id);
        $data->delete();
    }

    public function changeStatusKhat(Request $request){
       
        $id = $request->input('id');
        $getStatus = Khat::select('status')->where('id',$id)->first();
        // Retrieve the record from the database
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        // Toggle the status
        $getStatus->save();
        
        Khat::where('id',$id)->update(['status' => $status]);
        // Return the new status as a JSON response
        return response()->json([
            'success' => true
        ]);

    }

    // Function of Soft drink
    public function view_soft_drink(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = Softdrink::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('price', function($data){
                return $data->price;                      
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
 
        return view('material.softdrink.index');
    }

   
    public function create_soft_drink()
    {
        
    }

    
    public function store_soft_drink(Request $request)
    {
        $rules = array(
            'name'            => 'required|regex:/^[A-Za-z\s\-_.\d{1,2}]{2,255}$/|unique:soft_drink,name',
            'price'           => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'number_in_pack'  => 'required|regex:/^\d+(\.\d{1,2})?$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
       
        $form_data = array(
            'name'            => $request->name,
            'price'           => $request->price,
            'number_in_pack'  => $request->number_in_pack
        );
 
        Softdrink::create($form_data);
 
        return response()->json(['success' => 'Soft Drink Added successfully.']);
  
      
    }

    
    public function show_soft_drink(Request $request, $id)
    {
        $attribute = Softdrink::findOrFail($id);
       
        return response()->json([
            'attribute' => $attribute
            
        ]);
        
    }

    
    public function edit_soft_drink($id)
    {
        if(request()->ajax())
        {
            $data = Softdrink::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_soft_drink(Request $request)
    {
        $rules = array(
            
            'name'            => 'required|regex:/^[A-Za-z\s\-_.\d{1,2}]{2,255}$/|unique:soft_drink,name,'.$request->hidden_id,
            'price'           => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'number_in_pack'  => 'required|regex:/^\d+(\.\d{1,2})?$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'name'            =>  $request->name,
            'price'           =>  $request->price,
            'number_in_pack'  =>  $request->number_in_pack

        );
 
        Softdrink::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Soft Drink is successfully updated']);
    }

    
    public function delete_soft_drink($id)
    {
        $data = Softdrink::findOrFail($id);
        $data->delete();
    }

    public function changeStatusSoftdrink(Request $request){
       
        $id = $request->input('id');
        $getStatus = Softdrink::select('status')->where('id',$id)->first();
        // Retrieve the record from the database
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        // Toggle the status
        $getStatus->save();
        
        Softdrink::where('id',$id)->update(['status' => $status]);
        
        // Return the new status as a JSON response
        return response()->json([
            'success' => true
        ]);

    }

    // Function of Cigarate
    public function view_cigarate(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = Cigarates::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('packet_price', function($data){
                return $data->packet_price;                      
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
 
        return view('material.cigarates.index');
    }

   
    public function create_cigarate()
    {
        
    }

    
    public function store_cigarate(Request $request)
    {
        $rules = array(
            'name'           => 'required|regex:/^[A-Za-z\s\-_\d{1,2}]{2,255}$/|unique:cigarates,name',
            'number_in_pack' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'packet_price'   => 'required|regex:/^\d+(\.\d{1,2})?$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('packet_price') && !empty($request->packet_price)) {
            $packet_price = $request->packet_price;
            $half_price  = round(($packet_price) / 2); 
         } else {
            $half_price = 0;
         }
       
        $form_data = array(
            'name'           => $request->name,
            'packet_price'   => $request->packet_price,
            'half_price'     => $half_price,
            'number_in_pack' => $request->number_in_pack
        );
 
        Cigarates::create($form_data);
 
        return response()->json(['success' => 'Cigarate Added successfully.']);
  
      
    }

    
    public function show_cigarate(Request $request, $id)
    {
        $attribute = Cigarates::findOrFail($id);
       
        return response()->json([
            'attribute' => $attribute
            
        ]);
        
    }

    
    public function edit_cigarate($id)
    {
        if(request()->ajax())
        {
            $data = Cigarates::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_cigarate(Request $request)
    {
        $rules = array(
            
            'name'           => 'required|regex:/^[A-Za-z\s\-_\d{1,2}]{2,255}$/|unique:cigarates,name,'.$request->hidden_id,
            'number_in_pack' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'packet_price'   => 'required|regex:/^\d+(\.\d{1,2})?$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('packet_price') && !empty($request->packet_price)) {
            $packet_price = $request->packet_price;
            $half_price  = round(($packet_price) / 2); 
         } else {
            $half_price = 0;
         }
        
        $form_data = array(
            'name'           => $request->name,
            'number_in_pack' => $request->number_in_pack,
            'packet_price'   => $request->packet_price,
            'half_price'     => $half_price

        );
 
        Cigarates::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Cigarate is successfully updated']);
    }

    
    public function delete_cigarate($id)
    {
        $data = Cigarates::findOrFail($id);
        $data->delete();
    }

    public function changeStatusCigarate(Request $request){
       
        $id = $request->input('id');
        $getStatus = Cigarates::select('status')->where('id',$id)->first();
        // Retrieve the record from the database
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        // Toggle the status
        $getStatus->save();
        
        Cigarates::where('id',$id)->update(['status' => $status]);
        
        // Return the new status as a JSON response
        return response()->json([
            'success' => true
        ]);

    }
    // Function of Lozi
    public function view_lozi(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = Lozi::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('name', function($data){
                return $data->name;                      
            })
            ->addColumn('price', function($data){
                return $data->price;                      
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
 
        return view('material.lozi.index');
    }

   
    public function create_lozi()
    {
        
    }

    
    public function store_lozi(Request $request)
    {
        $rules = array(
            'name'   => 'required|regex:/^[A-Za-z\s\-_\d{1,2}]{2,255}$/|unique:lozi,name',
            'price'  => 'required|regex:/^\d+(\.\d{1,2})?$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
       
        $form_data = array(
            'name'   => $request->name,
            'price'  => $request->price
        );
 
        Lozi::create($form_data);
 
        return response()->json(['success' => 'Lozi Added successfully.']);
  
      
    }

    
    public function show_lozi(Request $request, $id)
    {
        $attribute = Lozi::findOrFail($id);
       
        return response()->json([
            'attribute' => $attribute
            
        ]);
        
    }

    
    public function edit_lozi($id)
    {
        if(request()->ajax())
        {
            $data = Lozi::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_lozi(Request $request)
    {
        $rules = array(
            
            'name'  => 'required|regex:/^[A-Za-z\s\-_\d{1,2}]{2,255}$/|unique:lozi,name,'.$request->hidden_id,
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'name'   =>  $request->name,
            'price'  =>  $request->price

        );
 
        Lozi::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Lozi is successfully updated']);
    }

    
    public function delete_lozi($id)
    {
        $data = Lozi::findOrFail($id);
        $data->delete();
    }

    public function changeStatusLozi(Request $request){
       
        $id = $request->input('id');
        $getStatus = Lozi::select('status')->where('id',$id)->first();
        // Retrieve the record from the database
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        // Toggle the status
        $getStatus->save();
        
        Lozi::where('id',$id)->update(['status' => $status]);
        
        // Return the new status as a JSON response
        return response()->json([
            'success' => true
        ]);

    }

    // Function of Store

    public function view_store(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $data = Store::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
            ->addColumn('branch_id', function($data){
                if($data->branch_id != null){
                    return $data->Branch->name;
                }
                                      
            })
            ->addColumn('material_type', function($data){
                return $data->material_type;                      
            })
            ->addColumn('beverage', function($data) {
                
                if ($data->soft_drink_id && $data->SoftDrink) {
                    return $data->SoftDrink->name;
                } elseif ($data->cigarates_id && $data->Cigarates) {
                    return $data->Cigarates->name;
                }
                return null;  
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
 
        return view('material.store.index');
    }

   
    public function create_store()
    {
        
    }

    
    public function store_store(Request $request)
    {
        $rules = array(
            'branch_id'      => 'required',
            'material_type'  => 'required',
            'number'         => 'required|regex:/^\d+(\.\d{1,2})?$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $soft_drink_id = null;
        $cigarates_id = null;

        if($request->material_type == 'soft_drink'){
            $soft_drink_id = $request->soft_drink_id;
            $cigarates_id = null;
        }elseif($request->material_type == 'cigarates'){
            $cigarates_id = $request->cigarates_id;
            $soft_drink_id = null;
        }
        
       
        $form_data = array(
            'branch_id'   => $request->branch_id,
            'material_type'  => $request->material_type,
            'soft_drink_id'  => $soft_drink_id,
            'cigarates_id'  => $cigarates_id,
            'number'       => $request->number
        );
 
        Store::create($form_data);
 
        return response()->json(['success' => 'Store Added successfully.']);
  
      
    }

    
    public function show_store(Request $request, $id)
    {
        $attribute = Store::findOrFail($id);
        $branchname = $attribute->Branch->name;
        if($attribute->soft_drink_id != null){
            $Materialname = $attribute->SoftDrink->name;
        }else{
            $Materialname = $attribute->Cigarates->name;
        }
        
        
       
        return response()->json([
            'attribute' => $attribute,
            'Materialname' => $Materialname,
            'branchname'  => $branchname
            
        ]);
        
    }

    
    public function edit_store($id)
    {
        if(request()->ajax())
        {
            $data = Store::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_store(Request $request)
    {
        $rules = array(
            
            'branch_id'     => 'required',
            'material_type' => 'required',
            'number'        => 'required|regex:/^\d+(\.\d{1,2})?$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $soft_drink_id = null;
        $cigarates_id = null;
        if($request->material_type == 'soft_drink'){
            $soft_drink_id = $request->soft_drink_id;
            $cigarates_id = null;
        }elseif($request->material_type == 'cigarates'){
            $cigarates_id = $request->cigarates_id;
            $soft_drink_id = null;
        }

       
        
       
        $form_data = array(
            'branch_id'     =>  $request->branch_id,
            'material_type' => $request->material_type,
            'soft_drink_id' => $soft_drink_id,
            'cigarates_id'  => $cigarates_id,
            'number'        =>  $request->number

        );
 
        Store::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Store is successfully updated']);
    }

    
    public function delete_store($id)
    {
        $data = Store::findOrFail($id);
        $data->delete();
    }





    





}
