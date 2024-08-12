<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

use App\models\material_management\Khat;
use App\models\material_management\Softdrink;
use App\models\material_management\Cigarates;
use App\models\material_management\Lozi;
use App\models\material_management\Store;
use App\models\address_management\Branch;

use App\models\daily_work_management\Dailyworkaccount;
use App\models\daily_work_management\Dailyworkbirr;
use App\models\daily_work_management\Dailyworkcigarates;
use App\models\daily_work_management\Dailyworkcredit;
use App\models\daily_work_management\Dailyworkkhat;
use App\models\daily_work_management\Dailyworkreport;
use App\models\daily_work_management\Dailyworksoftdrink;
use App\models\daily_work_management\Dailyworklozi;
use App\models\daily_work_management\Dailyworkwoci;
use App\models\daily_work_management\Dailyworkyetekefele;
use App\models\daily_work_management\Yemetakhat;

use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function view_branchreport()
    {
        return view('report.branchreport.index');
    }

    public function create_branchreport(Request $request)
    {
            $Date = $request->input('date');
            

            if ($request->has('branch_id') && !empty($request->branch_id)) {
                $BranchData = $request->input('branch_id');
             } else {
                $BranchData = Auth::user()->Branch->id;
             }

            $date = new Carbon($request->date);
            $dayBefore = $date->subDay()->toDateString();

            $branchNames = [];
            $khatBirrs = [];
            $softdrinkBirrs = [];
            $loziBirrs = [];
            $cigaratesBirrs = [];
            $wociBirrs = [];
            $accountBirrs = [];
            $creditBirrs = [];
            $yetekefeleBirrs = [];
            $yadereZirzirs = [];
            $cashBirrs = [];
            $zirzirBirrs = [];
            $yegebaBirrs = [];
            $adds = [];
            $minuses = [];
            $totalBirrs = [];
            $gudilets = [];

            if($BranchData == 'all'){
                $branches = Branch::all();
                foreach ($branches as $branch) {
                    $branchId = $branch->id;
                    $branchName = $branch->name;
                    
                    $khatBirr = Dailyworkkhat::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                    $softdrinkBirr = Dailyworksoftdrink::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                    $loziBirr = Dailyworklozi::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                    $cigaratesBirr = Dailyworkcigarates::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                    $wociBirr = Dailyworkwoci::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr_amount');
                    $accountBirr = Dailyworkaccount::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr_amount');
                    $creditBirr = Dailyworkcredit::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('birr_amount');
                    $yetekefeleBirr = Dailyworkyetekefele::where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->sum('paid_amount');
                    $yadereZirzir = Dailyworkbirr::where('branch_id', $branchId)->where('date', $dayBefore)->where('is_deleted', '0')->value('zirzir_birr');

                    $Birr = Dailyworkbirr::select('cash_birr', 'zirzir_birr')->where('branch_id', $branchId)->where('date', $Date)->where('is_deleted', '0')->first();
                    $cashBirr = $Birr ? $Birr->cash_birr : 0;
                    $zirzirBirr = $Birr ? $Birr->zirzir_birr : 0;
                    $yegebaBirr = $cashBirr + $zirzirBirr;

                    $add = $khatBirr + $softdrinkBirr + $cigaratesBirr + $yadereZirzir + $yetekefeleBirr + $loziBirr;
                    $minus = $wociBirr + $accountBirr + $creditBirr;

                    $totalBirr = $add - $minus;
                    $gudilet = $totalBirr - $yegebaBirr;
                    if ($totalBirr < $yegebaBirr) {
                        $gudilet = $gudilet * -1;
                        $gudilet .= 'ትሪፍ ነው';
                    }else{
                        $gudilet = ($gudilet * -1);
                    }
                    $branchNames[] = $branchName;
                    $khatBirrs[] = $khatBirr;
                    $softdrinkBirrs[] = $softdrinkBirr;
                    $loziBirrs[] = $loziBirr;
                    $cigaratesBirrs[] = $cigaratesBirr;
                    $wociBirrs[] = $wociBirr;
                    $accountBirrs[] = $accountBirr;
                    $creditBirrs[] = $creditBirr;
                    $yetekefeleBirrs[] = $yetekefeleBirr;
                    $yadereZirzirs[] = $yadereZirzir;
                    $cashBirrs[] = $cashBirr;
                    $zirzirBirrs[] = $zirzirBirr;
                    $yegebaBirrs[] = $yegebaBirr;
                    $adds[] = $add;
                    $minuses[] = $minus;
                    $totalBirrs[] = $totalBirr;
                    $gudilets[] = $gudilet;
                }


                $tableHtml = '<table class="table table-bordered table-condensed table-striped" id="branch_report_table">';
                $tableHtml .= '<thead>';
                $tableHtml .= '<tr>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ቁጥር</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ብራንች</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ቀን</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ጫት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ውሃ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ሎዝ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ሲጋራ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ወጭ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">አካውንት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ዱቤ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የተከፈለ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ጠቅላላ ብር</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የገባ ብር</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ጉድለት</th>';
                $tableHtml .= '</tr>';
                $tableHtml .= '</thead>';
                $tableHtml .= '<tbody>';

                foreach ($branchNames as $index => $branchName) {
                    $rowNumber = $index + 1;
                    $tableHtml .= '<tr>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $rowNumber . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $branchName . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $Date . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $khatBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $softdrinkBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $loziBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $cigaratesBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $wociBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $accountBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $creditBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $yetekefeleBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $totalBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $yegebaBirrs[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $gudilets[$index] . '</td>';
                    $tableHtml .= '</tr>';
                }

                $tableHtml .= '</tbody>';
                $tableHtml .= '</table>';

                // Return table HTML as JSON response
                return response()->json([ 
                    'table_html' => $tableHtml, 
                ]);







            }else
            {

                $branchName = Branch::where('id', $BranchData)->value('name');
                $branch_name = $branchName ? $branchName : '-';

                $khatBirr = Dailyworkkhat::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                $khat_birr = $khatBirr ? $khatBirr : 0;

                $softdrinkBirr = Dailyworksoftdrink::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                $softdrink_birr = $softdrinkBirr ? $softdrinkBirr : 0;

                $loziBirr = Dailyworklozi::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                $lozi_birr = $loziBirr ? $loziBirr : 0;

                $cigaratesBirr = Dailyworkcigarates::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr');
                $cigarates_birr = $cigaratesBirr ? $cigaratesBirr : 0;

                $wociBirr = Dailyworkwoci::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr_amount');
                $woci_birr = $wociBirr ? $wociBirr : 0;

                $accountBirr = Dailyworkaccount::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr_amount');
                $account_birr = $accountBirr ? $accountBirr : 0;

                $creditBirr = Dailyworkcredit::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('birr_amount');
                $credit_birr = $creditBirr ? $creditBirr : 0;

                $yetekefeleBirr = Dailyworkyetekefele::where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->sum('paid_amount');
                $yetekefele_birr = $yetekefeleBirr ? $yetekefeleBirr : 0;

                $yadereZirzir = Dailyworkbirr::where('branch_id', $BranchData)->where('date', $dayBefore)->where('is_deleted', '0')->value('zirzir_birr');
                $yadere_zirzir = $yadereZirzir ? $yadereZirzir : 0;
                

                $Birr = Dailyworkbirr::select('cash_birr', 'zirzir_birr')->where('branch_id', $BranchData)->where('date', $Date)->where('is_deleted', '0')->first();
                $cash_birr = $Birr ? $Birr->cash_birr : 0;
                $zirzir_birr = $Birr ? $Birr->zirzir_birr : 0;
                $yegebaBirr = $cash_birr + $zirzir_birr;

                $add = $khat_birr + $softdrink_birr + $cigarates_birr + $yadere_zirzir + $yetekefele_birr + $lozi_birr;
                $minus = $woci_birr + $account_birr + $credit_birr;

                $totalBirr = $add - $minus;
                $gudilet = $totalBirr - $yegebaBirr;

                if ($totalBirr < $yegebaBirr) {
                    $gudilet = $gudilet * -1;
                    $gudilet .= ' ትሪፍ ነው';
                }else{
                    $gudilet = ($gudilet * -1);
                }
        
                    
                


                $tableHtml = '<table class=" table table-bordered table-condensed  table-striped " id="branch_report_table">';
                $tableHtml .= '<thead>';
                $tableHtml .= '<tr>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ቁጥር</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ብራንች</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ቀን</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ጫት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ውሃ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ሎዝ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ሲጋራ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ወጭ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">አካውንት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ዱቤ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የተከፈለ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ጠቅላላ ብር</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የገባ ብር</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ጉድለት</th>';
                $tableHtml .= '</tr>';
                $tableHtml .= '</thead>';
                $tableHtml .= '<tbody>';

                $rowNumber = 1;
                $tableHtml .= '<tr>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $rowNumber . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $branchName . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $Date . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $khatBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $softdrinkBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $loziBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $cigaratesBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $wociBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $accountBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $creditBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $yetekefeleBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $totalBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $yegebaBirr . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $gudilet . '</td>';
                $tableHtml .= '</tr>';


                $tableHtml .= '</tbody>';
                $tableHtml .= '</table>';

                

                // Return table HTML as JSON response
                return response()->json([ 

                    'table_html' => $tableHtml, 
                    

                ]);




            }
 
           
            
     
        
    }

    // Exporter Report Functiom
    // $schedule_ids = Schedule::whereBetween('exam_date', [$startingDate, $endDate])->pluck('id')->toArray();


    public function view_exportereport()
    {
        return view('report.exportereport.index');
    }

    public function create_exportereport(Request $request)
    {
            $StartingDate = $request->input('starting_date');
            $EndDate = $request->input('end_date');
            $KhatData = $request->input('khat_id');

            $start = new DateTime($StartingDate);
            $end = new DateTime($EndDate);
            $interval = $start->diff($end);
            $numberOfDays = $interval->days + 1;

            

            $khatNames = [];
            $khatPrices = [];
            $khatBirrs = [];
            $khatNumbers = [];
            
           

            if($KhatData == 'all'){
                $khats = Khat::all();
                foreach ($khats as $khat) {
                    $khatId = $khat->id;
                    $khatName = $khat->name;
                    $khatPrice = $khat->buying_price;
                    $khatPrice = $khatPrice? $khatPrice: 0;

                    $khatNumber = Yemetakhat::whereBetween('date', [$StartingDate, $EndDate])->where('khat_id', $khatId)->where('is_deleted', '0')->sum('yemeta_khat');
                    $khatNumber = $khatNumber? $khatNumber: 0;
                    // $khatPrice = Khat::where('id', $khatId)->where('status', '1')->value('buying_price');
                    
                    $khatBirr = $khatPrice * $khatNumber; 
                    
                    

                    $khatNames[] = $khatName;
                    $khatPrices[] = $khatPrice;
                    $khatBirrs[] = $khatBirr;
                    $khatNumbers[] = $khatNumber;
                    
                   
                }


                $tableHtml = '<table class="table table-bordered table-condensed table-striped" id="exporter_report_table">';
                $tableHtml .= '<thead>';
                $tableHtml .= '<tr>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ቁጥር</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ጫት</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ከቀን</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ኢስከ ቀን</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">የቀን ብዛት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የጫት ብዛት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የአንዱ ዋጋ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ብር</th>';
                $tableHtml .= '</tr>';
                $tableHtml .= '</thead>';
                $tableHtml .= '<tbody>';

                foreach ($khatNames as $index => $khatName) {
                    $rowNumber = $index + 1;
                    $tableHtml .= '<tr>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $rowNumber . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $khatName . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $StartingDate . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $EndDate . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $numberOfDays . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $khatNumbers[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $khatPrices[$index] . '</td>';
                    $tableHtml .= '<td style="border: 1px solid black;">' . $khatBirrs[$index] . '</td>';
                    $tableHtml .= '</tr>';
                }

                $tableHtml .= '</tbody>';
                $tableHtml .= '</table>';

                // Return table HTML as JSON response
                return response()->json([ 
                    'table_html' => $tableHtml, 
                ]);







            }else
            {

                $khatName = Khat::where('id', $KhatData)->where('status', '1')->value('name');
                $khatNumber = Yemetakhat::whereBetween('date', [$StartingDate, $EndDate])->where('khat_id', $KhatData)->where('is_deleted', '0')->sum('yemeta_khat');
                $khatNumber = $khatNumber? $khatNumber: 0;
                $khatPrice = Khat::where('id', $KhatData)->where('status', '1')->value('buying_price');
                $khatPrice = $khatPrice? $khatPrice:0;
                $khatBirr = $khatPrice * $khatNumber; 

                
                


                $tableHtml = '<table class=" table table-bordered table-condensed  table-striped " id="exporter_report_table">';
                $tableHtml .= '<thead>';
                $tableHtml .= '<tr>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ቁጥር</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ጫት</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ከቀን</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">ኢስከ ቀን</th>';
                $tableHtml .= '<th rowspan="1" style="border: 1px solid black;">የቀን ብዛት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የጫት ብዛት</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">የአንዱ ዋጋ</th>';
                $tableHtml .= '<th colspan="1" style="border: 1px solid black;">ብር</th>';
                $tableHtml .= '</tr>';
                $tableHtml .= '</thead>';
                $tableHtml .= '<tbody>';

                $rowNumber = 1;
                $tableHtml .= '<tr>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $rowNumber . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $khatName . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $StartingDate . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $EndDate . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $numberOfDays . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $khatNumber . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $khatPrice . '</td>';
                $tableHtml .= '<td style="border: 1px solid black;">' . $khatBirr . '</td>';
                $tableHtml .= '</tr>';


                $tableHtml .= '</tbody>';
                $tableHtml .= '</table>';

                

                // Return table HTML as JSON response
                return response()->json([ 

                    'table_html' => $tableHtml, 
                    

                ]);




            }
 
           
            
                        
        

        

                 
        
    }




}
