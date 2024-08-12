<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\address_management\Region;
use App\Models\address_management\Zone;
use App\Models\address_management\Woreda;
use App\Models\address_management\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use DB;
use DataTables;
use Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['region'] = Region::get(["name","id"]);
        return view('region-zone-woreda-kebele',$data);
    }
    public function getZone(Request $request)
    {
        $data['zone'] = Zone::where("region_id",$request->region_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }
    public function getWoreda(Request $request)
    {
        $data['woreda'] = Woreda::where("zone_id",$request->zone_id)
                    ->get(["name","id"]);
        return response()->json($data);
    }

     // Function of Region
     public function view_region(Request $request)
     {
         if ($request->ajax()) {
             $N = 1;
             $data = Region::all();
             return Datatables::of($data)->addIndexColumn()
             ->addColumn('number', function($data) use(&$N){
                     return $N++;                      
              })
             ->addColumn('name', function($data){
                 return $data->name;                      
             })
             ->addColumn('type', function($data){
                 return $data->type;                      
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
  
         return view('address.region.index');
     }
 
    
     public function create_region()
     {
         
     }
 
     
     public function store_region(Request $request)
     {
         $rules = array(
             'type' => 'required',
             'name' => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/|unique:region,name'
            
         );
 
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         
        
         $form_data = array(
             'name'        =>  $request->name,
             'type'         =>  $request->type
         );
  
         Region::create($form_data);
  
         return response()->json(['success' => 'Region Added successfully.']);
   
       
     }
 
     
     public function show_region(Request $request, $id)
     {
         $attribute = Region::findOrFail($id);
        
         return response()->json([
             'attribute' => $attribute
             
         ]);
         
     }
 
     
     public function edit_region($id)
     {
         if(request()->ajax())
         {
             $data = Region::findOrFail($id);
             return response()->json([
                'result' => $data
            ]);
         }
     }
 
     
     public function update_region(Request $request)
     {
         $rules = array(
             'type' => 'required',
             'name' => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/|unique:region,name,'.$request->hidden_id
         );
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         
         $form_data = array(
             'name'    =>  $request->name,
             'type'     =>  $request->type
         );
  
         Region::whereId($request->hidden_id)->update($form_data);
  
         return response()->json(['success' => 'Region is successfully updated']);
     }
 
     
     public function delete_region($id)
     {
         $data = Region::findOrFail($id);
         $data->delete();
     }
 
 
     // Function of Zone
     public function view_zone(Request $request)
     {
         if ($request->ajax()) {
             $N = 1;
             $data = Zone::all();
             return Datatables::of($data)->addIndexColumn()
             ->addColumn('number', function($data) use(&$N){
                     return $N++;                      
              })
             ->addColumn('name', function($data){
                 return $data->name;                  
             })
             ->addColumn('region_id', function($data){
                return $data->Region->name;                  
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
  
         return view('address.zone.index');
     }
 
    
     public function create_zone()
     {
         
     }
 
     
     public function store_zone(Request $request)
     {
         $rules = array(
             'name'      => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
             'region_id' => 'required'
         );
 
         
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         
        
         $form_data = array(
             'name'       =>  $request->name,
             'region_id'  =>  $request->region_id
             
         );
  
         Zone::create($form_data);
  
         return response()->json(['success' => 'Zone Added successfully.']);
 
     }
 
     
     public function show_zone(Request $request, $id)
     {
         $attribute = Zone::findOrFail($id);
         $regioname = $attribute->Region->name;
         return response()->json([
             'attribute' => $attribute,
             'regioname' => $regioname
             
         ]);
     }
 
     
     public function edit_zone($id)
     {
         if(request()->ajax())
         {
             $data = Zone::findOrFail($id);
             return response()->json([
                'result' => $data
            ]);
         }
     }
 
     
     public function update_zone(Request $request)
     {
         $rules = array(
             'name'      => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
             'region_id' => 'required'
         );
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         
        
         $form_data = array(
             'name'       =>  $request->name,
             'region_id'  =>  $request->region_id
         );
  
         Zone::whereId($request->hidden_id)->update($form_data);
  
         return response()->json(['success' => 'Zone is successfully updated']);
 
     }
 
     
     public function delete_zone($id)
     {
         $data = Zone::findOrFail($id);
         $data->delete();
     }
 
    
    // Function of Woreda
    public function view_woreda(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            
            $data = Woreda::all();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
            })
            ->addColumn('name', function($data){
                return $data->name;                  
            })
            ->addColumn('zone_id', function($data){
                return $data->Zone->name;                  
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
    
        return view('address.woreda.index');
    }
    
    
    public function create_woreda()
    {
        
    }
    
    
    public function store_woreda(Request $request)
    {
        $rules = array(
            'name'    => 'required|regex:/^[A-Za-z\s\d\-_]{2,255}$/',
            'zone_id' => 'required'
        );
    
        
    
        $error = Validator::make($request->all(), $rules);
    
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        
        $form_data = array(
            'name'        =>  $request->name,
            'zone_id'     =>  $request->zone_id
        );
    
        Woreda::create($form_data);
    
        return response()->json(['success' => 'Woreda Added successfully.']);
    
    }
    
    
    public function show_woreda(Request $request, $id)
    {
        $attribute = Woreda::findOrFail($id);
        $zonename = $attribute->Zone->name;

        return response()->json([
            'attribute' => $attribute,
            'zonename' => $zonename
            
        ]);
    }
    
    
    public function edit_woreda($id)
    {
        if(request()->ajax())
        {
            $data = Woreda::findOrFail($id);
            $region_id = $data->Zone->region_id;
            // $region_id = Zone::where('id',$data->zone_id)->value('region_id');
            
            return response()->json([
                'result' => $data,
                'region_id' => $region_id
            ]);
        }
    }
    
    
    public function update_woreda(Request $request)
    {
        $rules = array(
            'name'    => 'required|regex:/^[A-Za-z\s\d\-_]{2,255}$/',
            'zone_id' => 'required'
        );
    
        $error = Validator::make($request->all(), $rules);
    
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        
        $form_data = array(
            'name'       =>  $request->name,
            'zone_id'    =>  $request->zone_id
        );
    
        Woreda::whereId($request->hidden_id)->update($form_data);
    
        return response()->json(['success' => 'Woreda is successfully updated']);
    
    }
    
    
    public function delete_woreda($id)
    {
        $data = Woreda::findOrFail($id);
        $data->delete();
    }
 
    
       // Function of Branch
       public function view_branch(Request $request)
       {
           if ($request->ajax()) {
               $N = 1;
               
               $data = Branch::all();
               return Datatables::of($data)->addIndexColumn()
               ->addColumn('number', function($data) use(&$N){
                       return $N++;                      
               })
               ->addColumn('name', function($data){
                   return $data->name;                  
               })
               ->addColumn('phone_number_1', function($data){
                return $data->phone_number_1;                  
                })
               ->addColumn('woreda_id', function($data){
                   return $data->Woreda->name;                  
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
       
           return view('address.branch.index');
       }
       
       
       public function create_branch()
       {
           
       }
       
       
       public function store_branch(Request $request)
       {
           $rules = array(
               'name'           => ['required','regex:/^[A-Za-z\s\d\-_]{2,255}$/','unique:branch,name'],
               'phone_number_1' => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/','unique:branch,phone_number_1'],
               'phone_number_2' => 'required',
               'location'       => 'required',
               'woreda_id'      => 'required'

           );
       
           
       
           $error = Validator::make($request->all(), $rules);
       
           if($error->fails())
           {
               return response()->json(['errors' => $error->errors()->all()]);
           }
           
           
           $form_data = array(
               'name'           =>  $request->name,
               'phone_number_1' =>  $request->phone_number_1,
               'phone_number_2' =>  $request->phone_number_2,
               'location'       =>  $request->location,
               'woreda_id'      =>  $request->woreda_id

           );
       
           Branch::create($form_data);
       
           return response()->json(['success' => 'Branch Added successfully.']);
       
       }
       
       
       public function show_branch(Request $request, $id)
       {
           $attribute = Branch::findOrFail($id);
           $woredaname = $attribute->Woreda->name;
           
           return response()->json([
               'attribute' => $attribute,
               'woredaname' => $woredaname
               
           ]);
       }
       
       
       public function edit_branch($id)
       {
           if(request()->ajax())
           {
               $data = Branch::findOrFail($id);
               $zone_id = $data->Woreda->zone_id;
            //    $zone_id = Woreda::where('id',$data->woreda_id)->value('zone_id');
               $region_id = Zone::where('id',$zone_id)->value('region_id');
               return response()->json([
                   'result' => $data,
                   'zone_id' => $zone_id,
                   'region_id' => $region_id
               ]);
           }
       }
       
       
       public function update_branch(Request $request)
       {
           $rules = array(
               'name'           => ['required','regex:/^[A-Za-z\s\d\-_]{2,255}$/','unique:branch,name,'.$request->hidden_id],
               'phone_number_1' => ['required','regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/','unique:branch,phone_number_1,'.$request->hidden_id],
               'phone_number_2' => ['required', 'regex:/^(09\d{8}|2519\d{8}|07\d{8}|2517\d{8})$/'],
               'location'       => 'required',
               'woreda_id'      => 'required'
           );
       
           $error = Validator::make($request->all(), $rules);
       
           if($error->fails())
           {
               return response()->json(['errors' => $error->errors()->all()]);
           }
           
           
           $form_data = array(
               'name'            =>  $request->name,
               'phone_number_1'  =>  $request->phone_number_1,
               'phone_number_2'  =>  $request->phone_number_2,
               'location'        =>  $request->location,
               'woreda_id'       =>  $request->woreda_id


               
           );
       
           Branch::whereId($request->hidden_id)->update($form_data);
       
           return response()->json(['success' => 'Branch is successfully updated']);
       
       }
       
       
       public function delete_branch($id)
       {
           $data = Branch::findOrFail($id);
           $data->delete();
       }

       public function changeStatusBranch(Request $request){
       
        $id = $request->input('id');
        $getStatus = Branch::select('status')->where('id',$id)->first();
        // Retrieve the record from the database
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        // Toggle the status
        $getStatus->save();
        
        Branch::where('id',$id)->update(['status' => $status]);
        // Return the new status as a JSON response
        return response()->json([
            'success' => true
        ]);

        }
 





}
