<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\models\material_management\Khat;
use App\models\material_management\Softdrink;
use App\models\material_management\Cigarates;
use App\models\material_management\Lozi;
use App\models\material_management\Store;

use App\models\daily_work_management\Dailyworkaccount;
use App\models\daily_work_management\Dailyworkbirr;
use App\models\daily_work_management\Dailyworkcigarates;
use App\models\daily_work_management\Dailyworkcredit;
use App\models\daily_work_management\Dailyworkkhat;
use App\models\daily_work_management\Dailyworkgudilet;
use App\models\daily_work_management\Dailyworksoftdrink;
use App\models\daily_work_management\Dailyworklozi;
use App\models\daily_work_management\Dailyworkwoci;
use App\models\daily_work_management\Dailyworkyetekefele;
use App\models\daily_work_management\Yemetakhat;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DailyWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function view_yemetakhat(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Yemetakhat::where('branch_id', $branch_id)->where('is_deleted', '0')->get();
            }else{
                $data = Yemetakhat::where('is_deleted', '0')->get();
            }
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('khat_id', function($data){
                if ($data->Khat && $data->Khat->name) {
                    return $data->Khat->name;
                    }else{
                        return '-'; 
                    }                    
            })
            ->addColumn('yemeta_khat', function($data){
                return $data->yemeta_khat;                      
            })
           
            ->addColumn('action', function($data){

                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
                
                
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.yemetakhat.index');
    }

   
    public function create_yemetakhat()
    {
        
    }

    
    public function store_yemetakhat(Request $request)
    {
        $rules = array(
            'khat_id'     => 'required',
            'yemeta_khat' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'        => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        
        $form_data = array(
            'khat_id'     =>  $request->khat_id,
            'yemeta_khat' =>  $request->yemeta_khat,
            'branch_id'   =>  $branch_id,
            'date'        =>  $request->date
        );
 
        Yemetakhat::create($form_data);
 
        return response()->json(['success' => 'Yemete khat Added successfully.']);
  
      
    }

    
    public function show_yemetakhat(Request $request, $id)
    {
        $attribute = Yemetakhat::findOrFail($id);
        $khatname = $attribute->Khat->name;
        $branchname = $attribute->Branch->name;
       
        return response()->json([
            'attribute'  => $attribute,
            'khatname'   => $khatname,
            'branchname' => $branchname
            
        ]);
        
    }

    
    public function edit_yemetakhat($id)
    {
        if(request()->ajax())
        {
            $data = Yemetakhat::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_yemetakhat(Request $request)
    {
        $rules = array(
           'khat_id'     => 'required',
           'yemeta_khat' => 'required|regex:/^\d+(\.\d{1,2})?$/',
           'date'        => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
               $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        $form_data = array(
            'khat_id'     =>  $request->khat_id,
            'yemeta_khat' =>  $request->yemeta_khat,
            'branch_id'   =>  $branch_id,
            'date'        =>  $request->date
        );
 
        Yemetakhat::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Yemeta khat is successfully updated']);
    }

    
    public function delete_yemetakhat($id)
    {
        // $data = Yemetakhat::findOrFail($id);
        // $data->delete();

        $getDeleted = Yemetakhat::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Yemetakhat::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }




    public function view_dailyworkkhat(Request $request)
     {
         if ($request->ajax()) {
             $N = 1;
             $branch_id = Auth::user()->branch_id;
             if($branch_id){
                $data = Dailyworkkhat::where('branch_id', $branch_id)->where('is_deleted', '0')->get();
             }else{
                $data = Dailyworkkhat::where('is_deleted', '0')->get();
             }
             
             return Datatables::of($data)->addIndexColumn()
             ->addColumn('number', function($data) use(&$N){
                     return $N++;                      
              })
              ->addColumn('branch_id', function($data){
                if ($data->Branch && $data->Branch->name) {
                    return $data->Branch->name;
                    }else{
                        return '-'; 
                    }                     
            })
             ->addColumn('type', function($data){
                 return $data->type;                   
             })
             ->addColumn('total_khat', function($data){
                 return $data->total_khat;                      
             })
             ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
             })
             ->rawColumns(['action'])
             ->make(true);
         }
  
         return view('dailywork.dailyworkkhat.index');
     }
 
    
     public function create_dailyworkkhat()
     {
         
     }
 
     
     public function store_dailyworkkhat(Request $request)
     {
        $rules = array(
            'type'       => 'required',
            'yalew_khat' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'       => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
        
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
        $branch_id = $request->branch_id; 
        } else {
        $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('wede_branch_id') && !empty($request->wede_branch_id)) {
        $wede_branch_id = $request->wede_branch_id; 
        } else {
        $wede_branch_id = null;
        }
        if ($request->has('yetelake_amount') && !empty($request->yetelake_amount)) {
        $yetelake_amount = $request->yetelake_amount; 
        } else {
        $yetelake_amount = 0;
        }
        if ($request->has('yalew_khat') && !empty($request->yalew_khat)) {
        $yalew_khat = $request->yalew_khat; 
        } else {
        $yalew_khat = 0;
        }
    
        $yemeta = Yemetakhat::where('is_deleted', '0')->where('date', $request->date)->where('branch_id', $branch_id)
                ->whereHas('Khat', function ($query) use ($request) {
                    $query->where('selling_price', $request->type);
                })->sum('yemeta_khat');
        if ($yemeta > 0) {
            
        $date = new Carbon($request->date);
        $dayBefore = $date->subDay()->toDateString();

        $yadere = Dailyworkkhat::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('type', $request->type)->first(['yalew_khat']); // Select only needed column
        $yadere_khat = $yadere ? $yadere->yalew_khat : 0;

        
        $kelela_yemeta = Dailyworkkhat::where('is_deleted', '0')->where('date', $request->date)->where('wede_branch_id', $branch_id)->where('type', $request->type)->sum('yetelake_amount');
        
					 
        $mikenesi_khat = $yetelake_amount + $yalew_khat;
        $total_khat = $yemeta + $yadere_khat + $kelela_yemeta;

        $yeteshete_khat = $total_khat - $mikenesi_khat;
        $khat_type = $request->type;
        $birr = $khat_type * $yeteshete_khat;

        if($total_khat < $mikenesi_khat){
            return response()->json(['errors' => 'ያለው ጫት ከአጠቃላይ ጫት መብለጥ ስተት ነው']);

        }else{

            $form_data = array(
                'type'                  =>  $request->type,
                'lela_branch_yetelake'  =>  $request->lela_branch_yetelake,
                'branch_id'             =>  $branch_id,
                'wede_branch_id'        =>  $wede_branch_id,
                'yemeta'                =>  $yemeta,
                'yalew_khat'            =>  $yalew_khat,
                'yetelake_amount'       =>  $yetelake_amount,
                'total_khat'            =>  $total_khat,
                'yeteshete_khat'        =>  $yeteshete_khat,
                'birr'                  =>  $birr,
                'date'                  =>  $request->date
            );
    
            
            $dailyworkkhat = Dailyworkkhat::create($form_data);
            $dailyworkkhat = $dailyworkkhat->fresh();
            $dailyworkkhat->save();
    
            return response()->json(['success' => ' Khat Hisabi Added successfully.']);

        }

    
       
    
        } else {
            return response()->json(['errors' => 'No sufficient data to create object.']);
        }

        
   
       
     }
 
     
     public function show_dailyworkkhat(Request $request, $id)
     {
         $attribute = Dailyworkkhat::findOrFail($id);
    
         if ($attribute->Branch && $attribute->Branch->name) {
            $branchname = $attribute->Branch->name;
            }else{
                $branchname = '-'; 
            }
        if ($attribute->LelaBranch && $attribute->LelaBranch->name) {
            $lelabranchname = $attribute->LelaBranch->name;
            }else{
                $lelabranchname = '-'; 
            }  
        
         return response()->json([
             'attribute'  => $attribute,
             'lelabranchname'   => $lelabranchname,
             'branchname' => $branchname
             
         ]);
         
     }
 
     
     public function edit_dailyworkkhat($id)
     {
         if(request()->ajax())
         {
             $data = Dailyworkkhat::findOrFail($id);
             return response()->json([
                'result' => $data
            ]);
         }
     }
 
     
     public function update_dailyworkkhat(Request $request)
     {
         $rules = array(
            'type'       => 'required',
            'yalew_khat' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'       => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
         );
  
         $error = Validator::make($request->all(), $rules);
  
         if($error->fails())
         {
             return response()->json(['errors' => $error->errors()->all()]);
         }
         if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch_id = $request->branch_id; 
         } else {
            $branch_id = Auth::user()->Branch->id;
         }
         if ($request->has('wede_branch_id') && !empty($request->wede_branch_id)) {
            $wede_branch_id = $request->wede_branch_id; 
         } else {
            $wede_branch_id = null;
         }
         if ($request->has('yetelake_amount') && !empty($request->yetelake_amount)) {
            $yetelake_amount = $request->yetelake_amount; 
         } else {
            $yetelake_amount = 0;
         }
         if ($request->has('yalew_khat') && !empty($request->yalew_khat)) {
            $yalew_khat = $request->yalew_khat; 
         } else {
            $yalew_khat = 0;
         }
        
         $yemeta = Yemetakhat::where('is_deleted', '0')->where('date', $request->date)->where('branch_id', $branch_id)
                    ->whereHas('Khat', function ($query) use ($request) {
                        $query->where('selling_price', $request->type);
                    })->sum('yemeta_khat');
        


        if ($yemeta > 0) {

            $date = new Carbon($request->date);
            $dayBefore = $date->subDay()->toDateString();
    
            $yadere = Dailyworkkhat::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('type', $request->type)->first(['yalew_khat']); // Select only needed column
            $yadere_khat = $yadere ? $yadere->yalew_khat : 0;
    
            
            $kelela_yemeta = Dailyworkkhat::where('is_deleted', '0')->where('date', $request->date)->where('wede_branch_id', $branch_id)->where('type', $request->type)->sum('yetelake_amount');
            
                            
            $mikenesi_khat = $yetelake_amount + $yalew_khat;
            $total_khat = $yemeta + $yadere_khat + $kelela_yemeta;
    
            $yeteshete_khat = $total_khat - $mikenesi_khat;
            $khat_type = $request->type;
            $birr = $khat_type * $yeteshete_khat;
    
            if($total_khat < $mikenesi_khat){
                return response()->json(['errors' => 'ያለው ጫት ከአጠቃላይ ጫት መብለጥ ስተት ነው']);
    
            }else{
    
                $form_data = array(
                    'type'                  =>  $request->type,
                    'lela_branch_yetelake'  =>  $request->lela_branch_yetelake,
                    'branch_id'             =>  $branch_id,
                    'wede_branch_id'        =>  $wede_branch_id,
                    'yemeta'                =>  $yemeta,
                    'yalew_khat'            =>  $yalew_khat,
                    'yetelake_amount'       =>  $yetelake_amount,
                    'total_khat'            =>  $total_khat,
                    'yeteshete_khat'        =>  $yeteshete_khat,
                    'birr'                  =>  $birr,
                    'date'                  =>  $request->date
                );

                $dailyworkkhat = Dailyworkkhat::find($request->hidden_id);
                $dailyworkkhat->update($form_data);
                $dailyworkkhat = $dailyworkkhat->fresh();
                $dailyworkkhat->save();
        
                return response()->json(['success' => ' Khat Hisabi is successfully updated']);
        
                
    
            }
    
        
            
        
        } else {
            return response()->json(['errors' => 'No sufficient data to create object.']);
        }            
    

        
        
        
       
         
     }
 
     
     public function delete_dailyworkkhat($id)
     {
        //  $data = Dailyworkkhat::findOrFail($id);
        //  $data->delete();
         

         
        $getDeleted = Dailyworkkhat::select('is_deleted')->where('id',$id)->first();
        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        $dailyworkkhat = Dailyworkkhat::find($id);
         $dailyworkkhat->update(['is_deleted' => $is_deleted]);
         $dailyworkkhat = $dailyworkkhat->fresh();
         $dailyworkkhat->save();
        return response()->json([
            'success' => true
        ]);

    }

    public function view_dailyworksoftdrink(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworksoftdrink::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworksoftdrink::where('is_deleted', '0')->get();

            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('soft_drink_id', function($data){
                if ($data->SoftDrink && $data->SoftDrink->name) {
                    return $data->SoftDrink->name;
                    }else{
                        return '-'; 
                    }                    
            })
            ->addColumn('total_soft_drink', function($data){
                return $data->total_soft_drink;                      
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworksoftdrink.index');
    }

   
    public function create_dailyworksoftdrink()
    {
        
    }

    
    public function store_dailyworksoftdrink(Request $request)
    {
        $rules = array(
            'soft_drink_id'     => 'required',
            'yetefeta'          => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_soft_drink' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'              => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('yetefeta') && !empty($request->yetefeta)) {
            $yetefeta = $request->yetefeta;
               
         } else {
            $yetefeta = 0;

         }
         if ($request->has('yadere_soft_drink') && !empty($request->yadere_soft_drink)) {
            $yalew_soft_drink = $request->yadere_soft_drink; 
         } else {
            $yalew_soft_drink = 0;
         }

        $price = Softdrink::where('id', $request->soft_drink_id)->value('price');
        $number = Softdrink::where('id', $request->soft_drink_id)->value('number_in_pack');

        $date = new Carbon($request->date);
        $dayBefore = $date->subDay()->toDateString();

        $yadere = Dailyworksoftdrink::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('soft_drink_id', $request->soft_drink_id)->first(['yadere_soft_drink']); // Select only needed column
        $yadere_soft_drink = $yadere ? $yadere->yadere_soft_drink : 0;

        $yetefeta_soft_drink = $yetefeta * $number;
        $total_soft_drink = $yadere_soft_drink + $yetefeta_soft_drink;
        $yeteshete_soft_drink = $total_soft_drink - $yalew_soft_drink;
        $birr = $yeteshete_soft_drink * $price;
        

        if($total_soft_drink < $yalew_soft_drink){
            return response()->json(['errors' => 'ያለው ለስላሳ መጠጥ ከአጠቃላይ ለስላሳ መጠጥ መብለጥ ስተት ነው']);

        }else
        {
            $form_data = array(
                'soft_drink_id'        =>  $request->soft_drink_id,
                'yetefeta'             =>  $yetefeta,
                'yadere_soft_drink'    =>  $yalew_soft_drink,
                'total_soft_drink'     =>  $total_soft_drink,
                'yeteshete_soft_drink' =>  $yeteshete_soft_drink,
                'branch_id'            =>  $branch_id,
                'birr'                 =>  $birr,
                'date'                 =>  $request->date
            );
     
            
    
            $Item = Store::select('id', 'number')->where('branch_id', $branch_id)->where('soft_drink_id', $request->soft_drink_id)->first();
            $item_in_store = $Item->number;
            $updated_item = $item_in_store - $yetefeta;
            
            Store::where('id',$Item->id)->update(['number' => $updated_item]);
            Dailyworksoftdrink::create($form_data);
            return response()->json(['success' => 'Data Added successfully.']);

        }
        
        
  
      
    }

    
    public function show_dailyworksoftdrink(Request $request, $id)
    {
        $attribute = Dailyworksoftdrink::findOrFail($id);
        $softdrinkname = $attribute->SoftDrink->name;
        $branchname = $attribute->Branch->name;
       
        return response()->json([
            'attribute'     => $attribute,
            'softdrinkname' => $softdrinkname,
            'branchname'    => $branchname
            
        ]);
        
    }

    
    public function edit_dailyworksoftdrink($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworksoftdrink::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworksoftdrink(Request $request)
    {
        $rules = array(
            'soft_drink_id'     => 'required',
            'yetefeta'          => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_soft_drink' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'              => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
               $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('yetefeta') && !empty($request->yetefeta)) {
            $yetefeta = $request->yetefeta;
               
         } else {
            $yetefeta = 0;
         }
         if ($request->has('yadere_soft_drink') && !empty($request->yadere_soft_drink)) {
            $yalew_soft_drink = $request->yadere_soft_drink; 
         } else {
            $yalew_soft_drink = 0;
         }
        
        $price = Softdrink::where('id', $request->soft_drink_id)->value('price');
        $number = Softdrink::where('id', $request->soft_drink_id)->value('number_in_pack');
        

        $date = new Carbon($request->date);
        $dayBefore = $date->subDay()->toDateString();

        $yadere = Dailyworksoftdrink::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('soft_drink_id', $request->soft_drink_id)->first(['yadere_soft_drink']); // Select only needed column
        $yadere_soft_drink = $yadere ? $yadere->yadere_soft_drink : 0;

        $yetefeta_soft_drink = $yetefeta * $number; 
        $total_soft_drink = $yadere_soft_drink + $yetefeta_soft_drink;
        $yeteshete_soft_drink = $total_soft_drink - $yalew_soft_drink;
        $birr = $yeteshete_soft_drink * $price;

        if($total_soft_drink < $yalew_soft_drink){
            return response()->json(['errors' => 'ያለው ለስላሳ መጠጥ ከአጠቃላይ ለስላሳ መጠጥ መብለጥ ስተት ነው']);

        }else
        {
            $form_data = array(
                'soft_drink_id'        =>  $request->soft_drink_id,
                'yetefeta'             =>  $yetefeta,
                'yadere_soft_drink'    =>  $yalew_soft_drink,
                'total_soft_drink'     =>  $total_soft_drink,
                'yeteshete_soft_drink' =>  $yeteshete_soft_drink,
                'branch_id'            =>  $branch_id,
                'birr'                 =>  $birr,
                'date'                 =>  $request->date
            );
     
     
            
            
            $before = Dailyworksoftdrink::select('yetefeta')->where('is_deleted', '0')->where('id',$request->hidden_id)->first();
            $yetefeta_first = $before->yetefeta;
            if ($yetefeta > $yetefeta_first) {
                $new = $yetefeta - $yetefeta_first;
                $Item = Store::select('id', 'number')->where('branch_id', $branch_id)->where('soft_drink_id', $request->soft_drink_id)->first();
                $item_in_store = $Item->number;
                $updated_item = $item_in_store - $new;
                
                Store::where('id',$Item->id)->update(['number' => $updated_item]);
    
            }elseif($yetefeta < $yetefeta_first) {
                $new = $yetefeta_first - $yetefeta;
                $Item = Store::select('id', 'number')->where('branch_id', $branch_id)->where('soft_drink_id', $request->soft_drink_id)->first();
                $item_in_store = $Item->number;
                $updated_item = $item_in_store + $new;
                
                Store::where('id',$Item->id)->update(['number' => $updated_item]);
                
            }
    
            
            Dailyworksoftdrink::whereId($request->hidden_id)->update($form_data);
            return response()->json(['success' => 'Data is successfully updated']);
            
        }

        
        
    }

    
    public function delete_dailyworksoftdrink($id)
    {
        // $data = Dailyworksoftdrink::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworksoftdrink::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworksoftdrink::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    public function view_dailyworklozi(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworklozi::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworklozi::where('is_deleted', '0')->get();

            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('lozi_id', function($data){
                if ($data->Lozi && $data->Lozi->name) {
                    return $data->Lozi->name;
                    }else{
                        return '-'; 
                    }                    
            })
            ->addColumn('total_lozi', function($data){
                return $data->total_lozi;                      
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworklozi.index');
    }

   
    public function create_dailyworklozi()
    {
        
    }

    
    public function store_dailyworklozi(Request $request)
    {
        $rules = array(
            'lozi_id'           => 'required',
            'yemeta'            => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_lozi'       => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'              => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('yemeta') && !empty($request->yemeta)) {
            $yemeta = $request->yemeta;
               
         } else {
            $yemeta = 0;

         }
         if ($request->has('yadere_lozi') && !empty($request->yadere_lozi)) {
            $yalew_lozi = $request->yadere_lozi; 
         } else {
            $yalew_lozi = 0;
         }

        $price = Lozi::where('id', $request->lozi_id)->value('price');

        $date = new Carbon($request->date);
        $dayBefore = $date->subDay()->toDateString();

        $yadere = Dailyworklozi::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('lozi_id', $request->lozi_id)->first(['yadere_lozi']); // Select only needed column
        $yadere_lozi = $yadere ? $yadere->yadere_lozi : 0;

        
        $total_lozi = $yadere_lozi + $yemeta;
        $yeteshete_lozi = $total_lozi - $yalew_lozi;
        $birr = $yeteshete_lozi * $price;

        if($total_lozi < $yalew_lozi){
            return response()->json(['errors' => 'ያለው ለሎዝ ከአጠቃላይ ሎዝ መብለጥ ስተት ነው']);

        }else{
            $form_data = array(
                'lozi_id'              =>  $request->lozi_id,
                'yemeta'               =>  $yemeta,
                'yadere_lozi'          =>  $yalew_lozi,
                'total_lozi'           =>  $total_lozi,
                'yeteshete_lozi'       =>  $yeteshete_lozi,
                'branch_id'            =>  $branch_id,
                'birr'                 =>  $birr,
                'date'                 =>  $request->date
            );
     
            
    
            
            Dailyworklozi::create($form_data);
            return response()->json(['success' => 'Data Added successfully.']);

        }

        
        
  
      
    }

    
    public function show_dailyworklozi(Request $request, $id)
    {
        $attribute = Dailyworklozi::findOrFail($id);
        $loziname = $attribute->Lozi->name;
        $branchname = $attribute->Branch->name;
       
        return response()->json([
            'attribute'     => $attribute,
            'loziname'      => $loziname,
            'branchname'    => $branchname
            
        ]);
        
    }

    
    public function edit_dailyworklozi($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworklozi::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworklozi(Request $request)
    {
        $rules = array(
            'lozi_id'         => 'required',
            'yemeta'          => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_lozi'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'            => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
               $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('yemeta') && !empty($request->yemeta)) {
            $yemeta = $request->yemeta;
               
         } else {
            $yemeta = 0;
         }
         if ($request->has('yadere_lozi') && !empty($request->yadere_lozi)) {
            $yalew_lozi = $request->yadere_lozi; 
         } else {
            $yalew_lozi = 0;
         }
        
        $price = Lozi::where('id', $request->lozi_id)->value('price');
        

        $date = new Carbon($request->date);
        $dayBefore = $date->subDay()->toDateString();

        $yadere = Dailyworklozi::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('lozi_id', $request->lozi_id)->first(['yadere_lozi']); // Select only needed column
        $yadere_lozi = $yadere ? $yadere->yadere_lozi : 0;

        
        $total_lozi = $yadere_lozi + $yemeta;
        $yeteshete_lozi = $total_lozi - $yalew_lozi;
        $birr = $yeteshete_lozi * $price;

        if($total_lozi < $yalew_lozi){
            return response()->json(['errors' => 'ያለው ለሎዝ ከአጠቃላይ ሎዝ መብለጥ ስተት ነው']);

        }else{

            $form_data = array(
                'lozi_id'            =>  $request->lozi_id,
                'yemeta'             =>  $yemeta,
                'yadere_lozi'        =>  $yalew_lozi,
                'total_lozi'         =>  $total_lozi,
                'yeteshete_lozi'     =>  $yeteshete_lozi,
                'branch_id'          =>  $branch_id,
                'birr'               =>  $birr,
                'date'               =>  $request->date
            );
     
     
            
            
    
            
            Dailyworklozi::whereId($request->hidden_id)->update($form_data);
            return response()->json(['success' => 'Data is successfully updated']);

        }

        
        
    }

    
    public function delete_dailyworklozi($id)
    {
        // $data = Dailyworklozi::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworklozi::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworklozi::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    public function view_dailyworkcigarates(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkcigarates::where('branch_id', $branch_id)->where('is_deleted', '0')->get();
            }else{
                $data = Dailyworkcigarates::where('is_deleted', '0')->get();
            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('cigarates_id', function($data){
                if ($data->Cigarates && $data->Cigarates->name) {
                    return $data->Cigarates->name;
                    }else{
                        return '-'; 
                    }                    
            })
            ->addColumn('total_cigarates', function($data){
                return $data->total_cigarates;                      
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkcigarates.index');
    }

   
    public function create_dailyworkcigarates()
    {
        
    }

    
    public function store_dailyworkcigarates(Request $request)
    {
        $rules = array(
            'cigarates_id'          => 'required',
            'yetekefete_cigarates'  => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_packet'         => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_half'           => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'                  => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('yetekefete_cigarates') && !empty($request->yetekefete_cigarates)) {
            $yetekefete_cigarates = $request->yetekefete_cigarates;
               
         } else {
            $yetekefete_cigarates = 0;

         }
         if ($request->has('yadere_packet') && !empty($request->yadere_packet)) {
            $yalew_packet = $request->yadere_packet; 
         } else {
            $yalew_packet = 0;
         }
         if ($request->has('yadere_half') && !empty($request->yadere_half)) {
            $yalew_half = $request->yadere_half; 
         } else {
            $yalew_half = 0;
         }

        $packet_price = Cigarates::where('id', $request->cigarates_id)->value('packet_price');
        $half_price = Cigarates::where('id', $request->cigarates_id)->value('half_price');
        $number = Cigarates::where('id', $request->cigarates_id)->value('number_in_pack');

        $date = new Carbon($request->date);
        $dayBefore = $date->subDay()->toDateString();

        $cigarates_packet = Dailyworkcigarates::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first(['yadere_packet']); // Select only needed column
        $yadere_packet = $cigarates_packet ? $cigarates_packet->yadere_packet : 0;
        $cigarates_half = Dailyworkcigarates::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first(['yadere_half']); // Select only needed column
        $yadere_half = $cigarates_half ? $cigarates_half->yadere_half : 0;

        $yetekefete = $yetekefete_cigarates * $number;
        $total_packet = $yetekefete + $yadere_packet;
        $total_cigarates = $total_packet ." packet and " . $yadere_half . " half";
        $yeteshete_packet = $total_packet - $yalew_packet;
        $yeteshete_half = (($yeteshete_packet * 2) + $yadere_half) - $yalew_half;
        if($yeteshete_half %2 == 0){
            $cigarates = $yeteshete_half / 2;
            $yeteshete_cigarates = $cigarates . " packet";
            $birr = $cigarates * $packet_price;
        }else{
            $yeteshete = $yeteshete_half - 1;
            $cigarates = $yeteshete / 2;
            $yeteshete_cigarates = $cigarates . " packet and" . " 1 half";
            $birr = ($cigarates * $packet_price) + $half_price;

        }


        if($total_packet < $yalew_packet){
            return response()->json(['errors' => 'ያለው ሲጋራ ከአጠቃላይ ሲጋራ መብለጥ ስተት ነው']);

        }else{

            $form_data = array(
                'cigarates_id'         =>  $request->cigarates_id,
                'yetekefete_cigarates' =>  $yetekefete_cigarates,
                'yadere_packet'        =>  $yalew_packet,
                'yadere_half'          =>  $yalew_half,
                'total_cigarates'      =>  $total_cigarates,
                'yeteshete_cigarates'  =>  $yeteshete_cigarates,
                'branch_id'            =>  $branch_id,
                'birr'                 =>  $birr,
                'date'                 =>  $request->date
            );
     
            
    
            $Item = Store::select('id', 'number')->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first();
            $item_in_store = $Item->number;
            $updated_item = $item_in_store - $yetekefete_cigarates;
            
            Store::where('id',$Item->id)->update(['number' => $updated_item]);
            Dailyworkcigarates::create($form_data);
            return response()->json(['success' => 'Data Added successfully.']);

        }
        
        
        

        
        
  
      
    }

    
    public function show_dailyworkcigarates(Request $request, $id)
    {
        $attribute = Dailyworkcigarates::findOrFail($id);
        $cigaratesname = $attribute->Cigarates->name;
        $branchname = $attribute->Branch->name;
       
        return response()->json([
            'attribute'     => $attribute,
            'cigaratesname' => $cigaratesname,
            'branchname'    => $branchname
            
        ]);
        
    }

    
    public function edit_dailyworkcigarates($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkcigarates::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkcigarates(Request $request)
    {
        $rules = array(
            'cigarates_id'          => 'required',
            'yetekefete_cigarates'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_packet'         => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'yadere_half'           => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'                  => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch_id = $request->branch_id; 
         } else {
            $branch_id = Auth::user()->Branch->id;
         }
         if ($request->has('yetekefete_cigarates') && !empty($request->yetekefete_cigarates)) {
             $yetekefete_cigarates = $request->yetekefete_cigarates;
                
          } else {
             $yetekefete_cigarates = 0;
 
          }
          if ($request->has('yadere_packet') && !empty($request->yadere_packet)) {
             $yalew_packet = $request->yadere_packet; 
          } else {
             $yalew_packet = 0;
          }
          if ($request->has('yadere_half') && !empty($request->yadere_half)) {
             $yalew_half = $request->yadere_half; 
          } else {
             $yalew_half = 0;
          }
 
         $packet_price = Cigarates::where('id', $request->cigarates_id)->value('packet_price');
         $half_price = Cigarates::where('id', $request->cigarates_id)->value('half_price');
         $number = Cigarates::where('id', $request->cigarates_id)->value('number_in_pack');
 
         $date = new Carbon($request->date);
         $dayBefore = $date->subDay()->toDateString();
 
         $cigarates_packet = Dailyworkcigarates::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first(['yadere_packet']); // Select only needed column
         $yadere_packet = $cigarates_packet ? $cigarates_packet->yadere_packet : 0;
         $cigarates_half = Dailyworkcigarates::where('is_deleted', '0')->where('date', $dayBefore)->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first(['yadere_half']); // Select only needed column
         $yadere_half = $cigarates_half ? $cigarates_half->yadere_half : 0;
 
         $yetekefete = $yetekefete_cigarates * $number;
         $total_packet = $yetekefete + $yadere_packet;
         $total_cigarates = $total_packet . " packet and " . $yadere_half . " half";
         $yeteshete_packet = $total_packet - $yalew_packet;
         $yeteshete_half = (($yeteshete_packet * 2) + $yadere_half) - $yalew_half;
         if($yeteshete_half %2 == 0){
             $cigarates = $yeteshete_half / 2;
             $yeteshete_cigarates = $cigarates . " packet";
             $birr = $cigarates * $packet_price;
         }else{
             $yeteshete = $yeteshete_half - 1;
             $cigarates = $yeteshete / 2;
             $yeteshete_cigarates = $cigarates . " packet and " . " 1 half";
             $birr = ($cigarates * $packet_price) + $half_price;
 
         }

         if($total_packet < $yalew_packet){
            return response()->json(['errors' => 'ያለው ሲጋራ ከአጠቃላይ ሲጋራ መብለጥ ስተት ነው']);

        }else
        {

            $form_data = array(
                'cigarates_id'         =>  $request->cigarates_id,
                'yetekefete_cigarates' =>  $yetekefete_cigarates,
                'yadere_packet'        =>  $yalew_packet,
                'yadere_half'          =>  $yalew_half,
                'total_cigarates'      =>  $total_cigarates,
                'yeteshete_cigarates'  =>  $yeteshete_cigarates,
                'branch_id'            =>  $branch_id,
                'birr'                 =>  $birr,
                'date'                 =>  $request->date
            );
    
    
           
           
           $before = Dailyworkcigarates::select('yetekefete_cigarates')->where('is_deleted', '0')->where('id',$request->hidden_id)->first();
           $yetekefete_first = $before->yetekefete_cigarates;
           if ($yetekefete_cigarates > $yetekefete_first) {
               $new = $yetekefete_cigarates - $yetekefete_first;
               $Item = Store::select('id', 'number')->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first();
               $item_in_store = $Item->number;
               $updated_item = $item_in_store - $new;
               
               Store::where('id',$Item->id)->update(['number' => $updated_item]);
   
           }elseif($yetekefete_cigarates < $yetekefete_first) {
               $new = $yetekefete_first - $yetekefete_cigarates;
               $Item = Store::select('id', 'number')->where('branch_id', $branch_id)->where('cigarates_id', $request->cigarates_id)->first();
               $item_in_store = $Item->number;
               $updated_item = $item_in_store + $new;
               
               Store::where('id',$Item->id)->update(['number' => $updated_item]);
               
           }
   
           
           Dailyworkcigarates::whereId($request->hidden_id)->update($form_data);
           return response()->json(['success' => 'Data is successfully updated']);

        }
         
         
         
 
         
        
    }

    
    public function delete_dailyworkcigarates($id)
    {
        // $data = Dailyworkcigarates::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkcigarates::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkcigarates::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }


    public function view_dailyworkaccount(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkaccount::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworkaccount::where('is_deleted', '0')->get();

            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('name', function($data){
                return $data->name;              
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkaccount.index');
    }

   
    public function create_dailyworkaccount()
    {
        
    }

    
    public function store_dailyworkaccount(Request $request)
    {
        $rules = array(
            'type'         => 'required',
            'name'         => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'birr_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        
        
        
        
        $form_data = array(
            'name'         =>  $request->name,
            'type'         =>  $request->type,
            'birr_amount'  =>  $request->birr_amount,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
 
        

        Dailyworkaccount::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
  
      
    }

    
    public function show_dailyworkaccount(Request $request, $id)
    {
        $attribute = Dailyworkaccount::findOrFail($id);
        $branchname = $attribute->Branch->name;
       
        return response()->json([
            'attribute'     => $attribute,
            'branchname'    => $branchname
            
        ]);
        
    }

    
    public function edit_dailyworkaccount($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkaccount::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkaccount(Request $request)
    {
        $rules = array(
            'type'         => 'required',
            'name'         => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'birr_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch_id = $request->branch_id; 
         } else {
            $branch_id = Auth::user()->Branch->id;
         }
         
         

         $form_data = array(
            'name'         =>  $request->name,
            'type'         =>  $request->type,
            'birr_amount'  =>  $request->birr_amount,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );

        
        Dailyworkaccount::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    
    public function delete_dailyworkaccount($id)
    {
        // $data = Dailyworkaccount::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkaccount::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkaccount::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    public function view_dailyworkcredit(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkcredit::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworkcredit::where('is_deleted', '0')->get();
                
            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('name', function($data){
                return $data->name;              
            })
            ->addColumn('birr_amount', function($data){
                
                if($data->birr_amount){
                    return $data->birr_amount;
                }else{
                    return '0';
                }              
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkcredit.index');
    }

   
    public function create_dailyworkcredit()
    {
        
    }

    
    public function store_dailyworkcredit(Request $request)
    {
        $rules = array(
            'name'         => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'birr_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        
        
        
        
        $form_data = array(
            'name'         =>  $request->name,
            'birr_amount'  =>  $request->birr_amount,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
 
        

        Dailyworkcredit::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
  
      
    }

    
    public function show_dailyworkcredit(Request $request, $id)
    {
        $attribute = Dailyworkcredit::findOrFail($id);
        $branchname = $attribute->Branch->name;
       
        return response()->json([
            'attribute'     => $attribute,
            'branchname'    => $branchname
            
        ]);
        
    }

    
    public function edit_dailyworkcredit($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkcredit::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkcredit(Request $request)
    {
        $rules = array(
            'name'         => 'required|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'birr_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch_id = $request->branch_id; 
         } else {
            $branch_id = Auth::user()->Branch->id;
         }
         
         

         $form_data = array(
            'name'         =>  $request->name,
            'birr_amount'  =>  $request->birr_amount,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );

        
        Dailyworkcredit::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    
    public function delete_dailyworkcredit($id)
    {
        // $data = Dailyworkcredit::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkcredit::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkcredit::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    public function view_dailyworkyetekefele(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkyetekefele::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworkyetekefele::where('is_deleted', '0')->get();
                
            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('credit_id', function($data){
                if ($data->Credit && $data->Credit->name) {
                    return $data->Credit->name;
                    }else{
                        return '-'; 
                    }              
            })
            ->addColumn('paid_amount', function($data){
                if ($data->paid_amount) {
                    return $data->paid_amount;
                    }else{
                        return '0'; 
                    }              
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkyetekefele.index');
    }

   
    public function create_dailyworkyetekefele()
    {
        
    }

    
    public function store_dailyworkyetekefele(Request $request)
    {
        $rules = array(
            'credit_id'    => 'required',
            'paid_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('paid_amount') && !empty($request->paid_amount)) {
            $paid_amount = $request->paid_amount; 
         } else {
            $paid_amount = 0;
         }
        
        $creditor = Dailyworkcredit::where('is_deleted', '0')->where('id', $request->credit_id)->first();
        $credit_amount = $creditor->birr_amount;
        $difference = $credit_amount - $paid_amount;
        $status = 1;
        if ($difference == 0) {
            Dailyworkcredit::where('is_deleted', '0')->where('id',$request->credit_id)->update(['birr_amount' => $difference, 'is_paid' => $status]);
        }elseif ($difference > 0) {
            Dailyworkcredit::where('is_deleted', '0')->where('id',$request->credit_id)->update(['birr_amount' => $difference]);
        }else {
            return response()->json(['errors' => 'The paid amount is greater than credit amount']);
        }
        
        
        $form_data = array(
            'credit_id'    =>  $request->credit_id,
            'paid_amount'  =>  $paid_amount,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
 
        

        Dailyworkyetekefele::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
  
      
    }

    
    public function show_dailyworkyetekefele(Request $request, $id)
    {
        $attribute = Dailyworkyetekefele::findOrFail($id);
        $branchname = $attribute->Branch->name;
        $creditname = $attribute->Credit->name;
       
        return response()->json([
            'attribute'    => $attribute,
            'branchname'   => $branchname,
            'creditname'   => $creditname
            
        ]);
        
    }

    
    public function edit_dailyworkyetekefele($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkyetekefele::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkyetekefele(Request $request)
    {
        $rules = array(
            'credit_id'    => 'required',
            'paid_amount'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch_id = $request->branch_id; 
         } else {
            $branch_id = Auth::user()->Branch->id;
         }
         if ($request->has('paid_amount') && !empty($request->paid_amount)) {
            $paid_amount = $request->paid_amount; 
         } else {
            $paid_amount = 0;
         }

        $previous = Dailyworkyetekefele::where('is_deleted', '0')->where('id', $request->hidden_id)->first();
        $prev_amount = $previous->paid_amount;
        
        $creditor = Dailyworkcredit::where('is_deleted', '0')->where('id', $request->credit_id)->first();
        $credit_amount = $creditor->birr_amount;
        
        if ($paid_amount > $prev_amount) {
            $new_amount = $paid_amount - $prev_amount;
            $difference = $credit_amount - $new_amount;
        }elseif ($paid_amount < $prev_amount) {
            $new_amount = $prev_amount - $paid_amount;
            $difference = $credit_amount + $new_amount;
            
        }
        $status = 1;
        if ($difference == 0) {
            Dailyworkcredit::where('is_deleted', '0')->where('id',$request->credit_id)->update(['birr_amount' => $difference, 'is_paid' => $status, 'is_paid' => $status]);
        }elseif ($difference > 0) {
            Dailyworkcredit::where('is_deleted', '0')->where('id',$request->credit_id)->update(['birr_amount' => $difference]);
        }else {
            return response()->json(['errors' => 'The paid amount is greater than credit amount']);
        }
         
         

         $form_data = array(
            'credit_id'    =>  $request->credit_id,
            'paid_amount'  =>  $paid_amount,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );

        
        Dailyworkyetekefele::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    
    public function delete_dailyworkyetekefele($id)
    {
        // $data = Dailyworkyetekefele::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkyetekefele::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkyetekefele::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    // Daily work birr function
    public function view_dailyworkbirr(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkbirr::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworkbirr::where('is_deleted', '0')->get();
                
            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('total_birr', function($data){
                if ($data->cash_birr && $data->zirzir_birr) {
                    $total_birr = $data->cash_birr + $data->zirzir_birr;
                    return number_format($total_birr, 2, '.', ',');
                    }else{
                        return '0.00'; 
                    }              
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkbirr.index');
    }

   
    public function create_dailyworkbirr()
    {
        
    }

    
    public function store_dailyworkbirr(Request $request)
    {
        $rules = array(
            'cash_birr'    => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'zirzir_birr'  => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('cash_birr') && !empty($request->cash_birr)) {
            $cash_birr = $request->cash_birr;
         } else {
            $cash_birr = 0;
         }
        if ($request->has('zirzir_birr') && !empty($request->zirzir_birr)) {
            $zirzir_birr = $request->zirzir_birr; 
         } else {
            $zirzir_birr = 0;
         }
        
        
        
        
        $form_data = array(
            'cash_birr'    =>  $cash_birr,
            'zirzir_birr'  =>  $zirzir_birr,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
 
        

        Dailyworkbirr::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
  
      
    }

    
    public function show_dailyworkbirr(Request $request, $id)
    {
        $attribute = Dailyworkbirr::findOrFail($id);
        $branchname = $attribute->Branch->name;
        $total_birr = $attribute->cash_birr + $attribute->zirzir_birr;
        $totalbirr = number_format($total_birr, 2, '.', ',');
        $cash_birr = number_format($attribute->cash_birr, 2, '.', ',');
        $zirzir_birr = number_format($attribute->zirzir_birr, 2, '.', ',');
        return response()->json([
            'attribute'    => $attribute,
            'branchname'   => $branchname,
            'totalbirr'    => $totalbirr,
            'zirzir_birr'  => $zirzir_birr,
            'cash_birr'    => $cash_birr
            
        ]);
        
    }

    
    public function edit_dailyworkbirr($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkbirr::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkbirr(Request $request)
    {
        $rules = array(
            'cash_birr'    => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'zirzir_birr'  => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch_id = $request->branch_id; 
         } else {
            $branch_id = Auth::user()->Branch->id;
         }
         if ($request->has('cash_birr') && !empty($request->cash_birr)) {
            $cash_birr = $request->cash_birr;
         } else {
            $cash_birr = 0;
         }
        if ($request->has('zirzir_birr') && !empty($request->zirzir_birr)) {
            $zirzir_birr = $request->zirzir_birr;
         } else {
            $zirzir_birr = 0;
         }


         $form_data = array(
            'cash_birr'    =>  $cash_birr,
            'zirzir_birr'  =>  $zirzir_birr,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
        
        Dailyworkbirr::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    
    public function delete_dailyworkbirr($id)
    {
        // $data = Dailyworkbirr::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkbirr::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkbirr::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    // Daily work woci function
    public function view_dailyworkwoci(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkwoci::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworkwoci::where('is_deleted', '0')->get();
                
            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('birr_amount', function($data){
                if ($data->birr_amount) {
                    return $data->birr_amount;
                    }else{
                        return '0.00'; 
                    }              
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkwoci.index');
    }

   
    public function create_dailyworkwoci()
    {
        
    }

    
    public function store_dailyworkwoci(Request $request)
    {
        $rules = array(
            'birr_amount'  => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'name'         => 'nullable|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('birr_amount') && !empty($request->birr_amount)) {
            $birr_amount = $request->birr_amount;
         } else {
            $birr_amount = 0;
         }
        
        
        
        $form_data = array(
            'birr_amount'  =>  $birr_amount,
            'name'         =>  $request->name,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
 
        

        Dailyworkwoci::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
  
      
    }

    
    public function show_dailyworkwoci(Request $request, $id)
    {
        $attribute = Dailyworkwoci::findOrFail($id);
        $branchname = $attribute->Branch->name;
        $birr_amount = number_format($attribute->birr_amount, 2, '.', ',');
        return response()->json([
            'attribute'    => $attribute,
            'branchname'   => $branchname,
            'birr_amount'  => $birr_amount
            
        ]);
        
    }

    
    public function edit_dailyworkwoci($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkwoci::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkwoci(Request $request)
    {
        $rules = array(
            'birr_amount'  => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'name'         => 'nullable|regex:/^[A-Za-z\s\-_]{2,255}$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('birr_amount') && !empty($request->birr_amount)) {
            $birr_amount = $request->birr_amount;
         } else {
            $birr_amount = 0;
         }
        
        
        
        $form_data = array(
            'birr_amount'  =>  $birr_amount,
            'name'         =>  $request->name,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
        
        Dailyworkwoci::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    
    public function delete_dailyworkwoci($id)
    {
        // $data = Dailyworkwoci::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkwoci::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkwoci::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }

    // Daily work Gudilet function
    public function view_dailyworkgudilet(Request $request)
    {
        if ($request->ajax()) {
            $N = 1;
            $branch_id = Auth::user()->branch_id;
            if($branch_id){
                $data = Dailyworkgudilet::where('branch_id', $branch_id)->where('is_deleted', '0')->get();

            }else{
                $data = Dailyworkgudilet::where('is_deleted', '0')->get();
                
            }
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('number', function($data) use(&$N){
                    return $N++;                      
             })
             ->addColumn('branch_id', function($data){
               if ($data->Branch && $data->Branch->name) {
                return $data->Branch->name;
                }else{
                    return '-'; 
                }                       
           })
            ->addColumn('gudilet', function($data){
                if ($data->gudilet) {
                    return $data->gudilet;
                    }else{
                        return '0.00'; 
                    }              
            })
            ->addColumn('date', function($data){
                
                if ($data->date) {
                    return $data->date;
                    }else{
                        return '-'; 
                    }             
            })
            ->addColumn('action', function($data){
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    $button .= '    <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                } else {
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '    <button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-info btn-sm"> <i class="bi bi-ticket-detailed"></i>Detail</button>';
                    return $button;
                    
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
 
        return view('dailywork.dailyworkgudilet.index');
    }

   
    public function create_dailyworkgudilet()
    {
        
    }

    
    public function store_dailyworkgudilet(Request $request)
    {
        $rules = array(
            'gudilet'      => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('gudilet') && !empty($request->gudilet)) {
            $gudilet = $request->gudilet;
         } else {
            $gudilet = 0;
         }
        
        
        
        $form_data = array(
            'gudilet'      =>  $gudilet,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
 
        

        Dailyworkgudilet::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
  
      
    }

    
    public function show_dailyworkgudilet(Request $request, $id)
    {
        $attribute = Dailyworkgudilet::findOrFail($id);
        $branchname = $attribute->Branch->name;
        $gudilet = number_format($attribute->gudilet, 2, '.', ',');
        return response()->json([
            'attribute'    => $attribute,
            'branchname'   => $branchname,
            'gudilet'      => $gudilet
            
        ]);
        
    }

    
    public function edit_dailyworkgudilet($id)
    {
        if(request()->ajax())
        {
            $data = Dailyworkgudilet::findOrFail($id);
            return response()->json([
               'result' => $data
           ]);
        }
    }

    
    public function update_dailyworkgudilet(Request $request)
    {
        $rules = array(
            'gudilet'      => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'date'         => 'required|regex:/^\d{4}-\d{2}-\d{2}$/'
           
        );

        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->has('branch_id') && !empty($request->branch_id)) {
           $branch_id = $request->branch_id; 
        } else {
           $branch_id = Auth::user()->Branch->id;
        }
        if ($request->has('gudilet') && !empty($request->gudilet)) {
            $gudilet = $request->gudilet;
         } else {
            $gudilet = 0;
         }
        
        
        
        $form_data = array(
            'gudilet'      =>  $gudilet,
            'branch_id'    =>  $branch_id,
            'date'         =>  $request->date
        );
        
        Dailyworkgudilet::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    
    public function delete_dailyworkgudilet($id)
    {
        // $data = Dailyworkgudilet::findOrFail($id);
        // $data->delete();

        $getDeleted = Dailyworkgudilet::select('is_deleted')->where('id',$id)->first();

        if($getDeleted->is_deleted == 1){
            $is_deleted = 0;
        }else{
            $is_deleted = 1;
        }

        $getDeleted->save();
        
        Dailyworkgudilet::where('id',$id)->update(['is_deleted' => $is_deleted]);
        

        return response()->json([
            'success' => true
        ]);
    }










    

    





}
