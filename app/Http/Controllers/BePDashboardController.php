<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Style\Fill;




// use DB;
use Session;
use Auth;
use Excel;
use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use App\utility;

class BePDashboardController extends Controller
{
    public function home_ui(){
        $municipality = array();
        $provinces = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                    ->select('province')
                    ->groupBy('province')
                    ->pluck('province');
        foreach($provinces as $province){
            $municipalities = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                    ->select('municipality')
                    ->where('province', "LIKE", $province)
                    ->groupBy('municipality')
                    ->get();
                    foreach($municipalities as $mun){
                    array_push($municipality,$mun->municipality);
                    }
            
        }

        $targetBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                            ->select(DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'))
                            ->get();
                            $beneficiariesCount = $targetBeneficiaries[0]->beneficiaries;
        
        $targetBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
        ->select(DB::raw('SUM(bags) as bags'))
        ->get();
        $bagsCount = $targetBags[0]->bags;

        $targetArea = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
        ->select(DB::raw('SUM(area) as area'))
        ->get();
        $areaCount = $targetArea[0]->area;

        $actualBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.paymaya_total_beneficiaries')
                            ->sum("total_beneficiaries");

        $actualBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.paymaya_total_bags')
                    ->sum("total_bags");

        $actualArea = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.paymaya_claim_area')
                    ->sum("sum(area)");

        $beneficiariesCount = number_format($beneficiariesCount);
        $bagsCount = number_format($bagsCount);
        $areaCount = number_format($areaCount, 2);
        $actualBeneficiaries = number_format($actualBeneficiaries);
        $actualBags = number_format($actualBags);
        $actualArea = number_format($actualArea, 2);

        if ($beneficiariesCount != 0) {
            $beneficiariesPercentage = ($actualBeneficiaries / $beneficiariesCount) * 100;
        } else {
            $beneficiariesPercentage = 0;
        }
        
        if ($bagsCount != 0) {
            $bagsPercentage = ($actualBags / $bagsCount) * 100;
        } else {
            $bagsPercentage = 0;
        }
        
        if ($areaCount != 0) {
            $areaPercentage = ($actualArea / $areaCount) * 100;
        } else {
            $areaPercentage = 0;
        }
        
        $beneficiariesPercentage = number_format($beneficiariesPercentage);
        $bagsPercentage = number_format($bagsPercentage);
        $areaPercentage = number_format($areaPercentage);

        $provTgt = array();          
        foreach($provinces as $row)
        {
            $provTarget = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                            ->select('province','municipality',DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'),DB::raw('SUM(area) as area'),DB::raw('SUM(bags) as bags'))
                            ->where("province",$row)
                            ->get();

            $provTgtBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.paymaya_total_beneficiaries')
                                        ->where("province",$row)
                                        ->sum("total_beneficiaries");

            $provTgtBeneficiaries = $provTgtBeneficiaries !== null ? $provTgtBeneficiaries : 0;

            $provTgtBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.paymaya_total_bags')
                                        ->where("province",$row)
                                        ->sum("total_bags");

            $provTgtBags = $provTgtBags !== null ? $provTgtBags : 0;

            $provTgtArea = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.paymaya_claim_area')
                                        ->where("province",$row)
                                        ->sum("sum(area)");

            $provTgtArea = $provTgtArea !== null ? $provTgtArea : 0;

            
            if($provTgtArea!=0){
            $amount = $provTgtBags * 760;
            array_push($provTgt,array(
            "province" => $provTarget[0]->province,
            "municipality" => $provTarget[0]->municipality,
            "beneficiaries" => number_format($provTarget[0]->beneficiaries),
            "bags" => number_format($provTarget[0]->bags),
            "area" => number_format($provTarget[0]->area,2),
            "actualBeneficiaries" =>number_format($provTgtBeneficiaries),
            "actualBags"=>number_format($provTgtBags),
            "amount"=>"₱".(number_format($amount,2)),
            "actualArea"=>number_format($provTgtArea,2)
            )); 
            }            
                

        }


        return view('BePDashboard.home',
        compact('provinces','beneficiariesCount','bagsCount','areaCount','actualBeneficiaries','actualBags','actualArea','provTgt','provAct','municipality','beneficiariesPercentage','bagsPercentage','areaPercentage'));
        
    }

    
    

    public function getMunicipalData(Request $request)
    {   
        $munTgt = array();
        $municipalities = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
        ->select('municipality')
        ->where('province',$request->province)
        ->groupBy('municipality')
        ->get();
        
        foreach($municipalities as $row)
        {
            
            $munTarget = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                            ->select('province','municipality',DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'),DB::raw('SUM(area) as area'),DB::raw('SUM(bags) as bags'))
                            ->where("municipality",$row->municipality)
                            ->get();


            $munTgtBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                        ->select(DB::raw(('COUNT(DISTINCT(paymaya_code)) as beneficiaries')))
                                        ->where("municipality",$row->municipality)
                                        // ->whereBetween('date_created', [$date1, $date2])
                                        ->get();
            
            $munTgtBeneficiaries = $munTgtBeneficiaries !== null ? $munTgtBeneficiaries : 0;

            $munTgtBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                        ->select(DB::raw(('COUNT(qr_code) as bags')))
                                        ->where("municipality",$row->municipality)
                                        // ->whereBetween('date_created', [$date1, $date2])
                                        ->get();
            
            $munTgtBags = $munTgtBags !== null ? $munTgtBags : 0;

            $query = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                    ->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province as province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality as municipality')
                    ->selectRaw('SUM(ws2024_rcep_paymaya.tbl_beneficiaries.area) as `area`')
                    ->whereIn($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.paymaya_code', function ($subquery) {
                        $subquery->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim.paymaya_code')
                            ->from($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim');
                    })
                    ->where('tbl_beneficiaries.municipality', $row->municipality)
                    // ->whereBetween(DB::raw("DATE_FORMAT(tbl_beneficiaries.schedule_start, '%m/%d/%Y')"), [$date1, $date2])
                    ->groupBy($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality')
                    ->get();

            $munTgtArea2 = 0;
                if(count($query) > 0){
                    $munTgtArea2 = $query[0]->area;
                }
                else{
                    $munTgtArea = json_decode('[{"province": "","municipality": "","area": "0.00"}]');
                    foreach($munTgtArea as $row){
                        $munTgtArea2 = $row->area;
                    }
                }
                // $provTgtArea = $provTgtArea !== null ? $provTgtArea : 0;

                $amount = $munTgtBags[0]->bags * 760;
                array_push($munTgt,array(
                    "province" => $munTarget[0]->province,
                    "municipality" => $munTarget[0]->municipality,
                    "beneficiaries" => number_format($munTarget[0]->beneficiaries),
                    "bags" => number_format($munTarget[0]->bags),
                "area" => number_format($munTarget[0]->area,2),
                "actualBeneficiaries" =>number_format($munTgtBeneficiaries[0]->beneficiaries),
                "actualBags"=>number_format($munTgtBags[0]->bags),
                "amount"=>"₱".(number_format($amount,2)),
                "actualArea"=>number_format($munTgtArea2,2)
            )); 
        }
        
        $munTgt = collect($munTgt);

        // return $munTgt;
        return Datatables::of($munTgt)
        ->addColumn('action', function($row){
            $link = route('downloadData', ['province' => $row["province"],'municipality' => $row["municipality"]]);
            return  "<a href='$link' target='_blank' class='btn btn-success btn-sm'id='btn_download'>Download data</a>";            
        })
        ->make(true);

    }

    public function getDatedMunData(Request $request)
    {   
        $date1 = Carbon::createFromFormat('m/d/Y', $request->date1)->format('Y-m-d');
        $date2 = Carbon::createFromFormat('m/d/Y', $request->date2)->format('Y-m-d');
        if($request->selectedView == 'provincial'){
            $munTgt = array();
            $municipalities = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
            ->select('municipality')
            ->where('province',$request->province)
            ->groupBy('municipality')
            ->pluck('municipality');
            
            
            foreach($municipalities as $row)
            {   
    
                $munTarget = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                                ->select('province','municipality',DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'),DB::raw('SUM(area) as area'),DB::raw('SUM(bags) as bags'))
                                ->where("municipality",$row)
                                ->get();
                
               
                $munTgtBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(DISTINCT(paymaya_code)) as beneficiaries')))
                                            ->where("municipality",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $munTgtBeneficiaries = $munTgtBeneficiaries !== null ? $munTgtBeneficiaries : 0;
    
                $munTgtBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(qr_code) as bags')))
                                            ->where("municipality",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $munTgtBags = $munTgtBags !== null ? $munTgtBags : 0;
    
                $query = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                        ->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province as province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality as municipality')
                        ->selectRaw('SUM(ws2024_rcep_paymaya.tbl_beneficiaries.area) as `area`')
                        ->whereIn($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.paymaya_code', function ($subquery) {
                            $subquery->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim.paymaya_code')
                                ->from($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim');
                        })
                        ->where('tbl_beneficiaries.municipality', $row)
                        ->whereBetween(DB::raw("DATE_FORMAT(tbl_beneficiaries.schedule_start, '%m/%d/%Y')"), [$date1, $date2])
                        ->groupBy($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality')
                        ->get();
    
                $munTgtArea2 = 0;
                    if(count($query) > 0){
                        $munTgtArea2 = $query[0]->area;
                    }
                    else{
                        $munTgtArea = json_decode('[{"province": "","municipality": "","area": "0.00"}]');
                        foreach($munTgtArea as $row){
                            $munTgtArea2 = $row->area;
                        }
                    }
                    if($munTgtArea2!=0){
                        $amount = $munTgtBags[0]->bags * 760;
                        array_push($munTgt,array(
                            "province" => $munTarget[0]->province,
                            "municipality" => $munTarget[0]->municipality,
                            "date1" => date("m-d-Y", strtotime($request->date1)),
                            "date2" => date("m-d-Y", strtotime($request->date2)),
                            "beneficiaries" => number_format($munTarget[0]->beneficiaries),
                            "bags" => number_format($munTarget[0]->bags),
                            "area" => number_format($munTarget[0]->area,2),
                            "actualBeneficiaries" =>number_format($munTgtBeneficiaries[0]->beneficiaries),
                            "actualBags"=>number_format($munTgtBags[0]->bags),
                            "amount"=>"₱".(number_format($amount,2)),
                            "actualArea"=>number_format($munTgtArea2,2),
                            "selectedView" => $request->selectedView
                        ));
                    }
                    
                
            }
            
            $munTgt = collect($munTgt);
    
    
            return Datatables::of($munTgt)
            ->addColumn('action', function($row){
                $link = route('downloadDatedData', ['province' => $row["province"],'municipality' => $row["municipality"], 'date1' => $row["date1"], 'date2' => $row["date2"], 'selectedView' => $row["selectedView"]]);
                return  "<a href='$link' target='_blank' class='btn btn-success btn-sm'>Download data</a>";            
            })
            ->make(true);
        }
        else if($request->selectedView == 'coop'){
            $coop = $request->province;
        
            $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
                    ->select('accreditation_no')
                    ->where('coopName','=', $coop)
                    ->get();
        
            $coop = $getCoop[0]->accreditation_no;
        
            $munTgt = array();
            $municipalities = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
            ->select('municipality')
            ->where('coopAccreditation',$coop)
            ->whereBetween('date_created', [$date1, $date2])
            ->groupBy('municipality')
            ->pluck('municipality');
            
            
            foreach($municipalities as $row)
            {   
        
                $munTarget = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                                ->select('coop_accreditation','municipality',DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'),DB::raw('SUM(area) as area'),DB::raw('SUM(bags) as bags'))
                                ->where("municipality",$row)
                                ->get();
                
            
                $munTgtBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(DISTINCT(paymaya_code)) as beneficiaries')))
                                            ->where("municipality",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $munTgtBeneficiaries = $munTgtBeneficiaries !== null ? $munTgtBeneficiaries : 0;
        
                $munTgtBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(qr_code) as bags')))
                                            ->where("municipality",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $munTgtBags = $munTgtBags !== null ? $munTgtBags : 0;

                $paymaya_codes = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('DISTINCT(paymaya_code) as beneficiaries')))
                                            ->where("municipality",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                // dd($paymaya_codes);

                $actualArea = 0;
                // $test = array();

                foreach($paymaya_codes as $code)
                {
                    $getArea = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                    ->select('area')
                    ->where("municipality",$row)
                    ->where('paymaya_code',$code->beneficiaries)
                    ->first();
                    $actualArea = $actualArea + $getArea->area;
        
                }
        
                // $query = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                //         ->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province as province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality as municipality')
                //         ->selectRaw('SUM(ws2024_rcep_paymaya.tbl_beneficiaries.area) as `area`')
                //         ->whereIn($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.paymaya_code', function ($subquery) {
                //             $subquery->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim.paymaya_code')
                //                 ->from($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim');
                //         })
                //         ->where('tbl_beneficiaries.municipality', $row)
                //         ->whereBetween(DB::raw("DATE_FORMAT(tbl_beneficiaries.schedule_start, '%m/%d/%Y')"), [$date1, $date2])
                //         ->groupBy($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality')
                //         ->get();
        
                // $munTgtArea2 = 0;
                //     if(count($query) > 0){
                //         $munTgtArea2 = $query[0]->area;
                //     }
                //     else{
                //         $munTgtArea = json_decode('[{"province": "","municipality": "","area": "0.00"}]');
                //         foreach($munTgtArea as $row){
                //             $munTgtArea2 = $row->area;
                //         }
                //     }
                //     if($munTgtArea2!=0){
                        $amount = $munTgtBags[0]->bags * 760;

                        $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
                        ->select('coopName')
                        ->where('accreditation_no','=', $munTarget[0]->coop_accreditation)
                        ->get();

                        $coop = $getCoop[0]->coopName;

                        array_push($munTgt,array(
                            "coop" => $coop,
                            "municipality" => $munTarget[0]->municipality,
                            "date1" => date("m-d-Y", strtotime($request->date1)),
                            "date2" => date("m-d-Y", strtotime($request->date2)),
                            "beneficiaries" => number_format($munTarget[0]->beneficiaries),
                            "bags" => number_format($munTarget[0]->bags),
                            "area" => number_format($munTarget[0]->area,2),
                            "actualBeneficiaries" =>number_format($munTgtBeneficiaries[0]->beneficiaries),
                            "actualBags"=>number_format($munTgtBags[0]->bags),
                            "amount"=>"₱".(number_format($amount,2)),
                            "actualArea"=>number_format($actualArea,2),
                            "selectedView" => $request->selectedView
                        ));
                    // }
                    
                
            }
            
            $munTgt = collect($munTgt);
        
        
            return Datatables::of($munTgt)
            ->addColumn('action', function($row){
                $link = route('downloadDatedData', ['coop' => $row["coop"],'municipality' => $row["municipality"], 'date1' => $row["date1"], 'date2' => $row["date2"], 'selectedView' => $row["selectedView"]]);
                return  "<a href='$link' target='_blank' class='btn btn-success btn-sm'>Download data</a>";            
            })
            ->make(true);
        }

    }

    public function getDatedData(Request $request)
    {   
        
        $date1 = Carbon::createFromFormat('m/d/Y H:i:s', $request->date1 . ' 00:00:00')->format('Y-m-d H:i:s');
        $date2 = Carbon::createFromFormat('m/d/Y H:i:s', $request->date2 . ' 00:00:00')->format('Y-m-d H:i:s');


        if ($date1 == $date2) {
            $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $date2)->endOfDay()->format('Y-m-d H:i:s');
        }
        // dd($date1,$date2);
        if($request->selectedView == 'provincial'){
            $provTgt = array();
            $provinces = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
            ->select('province')
            ->groupBy('province')
            ->pluck('province');
    
            
            foreach($provinces as $row)
            {
                $provTarget = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                                ->select('province','municipality',DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'),DB::raw('SUM(area) as area'),DB::raw('SUM(bags) as bags'))
                                ->where("province",$row)
                                ->get();
    
    
                $provTgtBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(DISTINCT(paymaya_code)) as beneficiaries')))
                                            ->where("province",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $provTgtBeneficiaries = $provTgtBeneficiaries !== null ? $provTgtBeneficiaries : 0;
    
                $provTgtBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(qr_code) as bags')))
                                            ->where("province",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $provTgtBags = $provTgtBags !== null ? $provTgtBags : 0;
    
                $query = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                        ->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province as province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality as municipality')
                        ->selectRaw('SUM(ws2024_rcep_paymaya.tbl_beneficiaries.area) as `area`')
                        ->whereIn($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.paymaya_code', function ($subquery) {
                            $subquery->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim.paymaya_code')
                                ->from($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim');
                        })
                        ->where('tbl_beneficiaries.province', $row)
                        ->whereBetween(DB::raw("DATE_FORMAT(tbl_beneficiaries.schedule_start, '%m/%d/%Y')"), [$date1, $date2])
                        ->groupBy($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality')
                        ->get();
    
                $provTgtArea2 = 0;
                    if(count($query) > 0){
                        $provTgtArea2 = $query[0]->area;
                    }
                    else{
                        $provTgtArea = json_decode('[{"province": "","municipality": "","area": "0.00"}]');
                        foreach($provTgtArea as $row){
                            $provTgtArea2 = $row->area;
                        }
                    }
                    
                    if($provTgtArea2!=0){
                        $amount = $provTgtBags[0]->bags * 760;
                        array_push($provTgt,array(
                            "province" => $provTarget[0]->province,
                            "municipality" => $provTarget[0]->municipality,
                            "date1" => date("m-d-Y", strtotime($request->date1)),
                            "date2" => date("m-d-Y", strtotime($request->date2)),
                            "beneficiaries" => number_format($provTarget[0]->beneficiaries),
                            "bags" => number_format($provTarget[0]->bags),
                            "area" => number_format($provTarget[0]->area,2),
                            "actualBeneficiaries" =>number_format($provTgtBeneficiaries[0]->beneficiaries),
                            "actualBags"=>number_format($provTgtBags[0]->bags),
                            "amount"=>"₱".(number_format($amount,2)),
                            "actualArea"=>number_format($provTgtArea2,2)
                        )); 
                    }
            }
                    
            $provTgt = collect($provTgt);
                return Datatables::of($provTgt)
            ->addColumn('action', function($row){
                $link = route('downloadDatedPrvData', ['province' => $row["province"],'municipality' => $row["municipality"], 'date1' => $row["date1"], 'date2' => $row["date2"]]);
                return  "<a href='$link' class='btn btn-success btn-sm'><i class='fa fa-download'></i> Download provincial data</a>
                <a href='#' target='_blank' data-province='{$row['province']}' data-toggle='modal' data-target='#download_modal2' id='view_mun' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> View municipal data</a>";            
            })
            ->make(true);
        }
        else if($request->selectedView == 'coop')
        {
            // dd($request->selectedView);
            // dd($date1, $date2);
            $provTgt = array();
            $coops = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
            ->select('coopAccreditation')
            ->whereBetween('date_created', [$date1, $date2])
            ->groupBy('coopAccreditation')
            ->pluck('coopAccreditation');
            // dd($coops);
            // dd($coops);
            foreach($coops as $row)
            {
                
                $provTarget = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                                ->select('coop_accreditation',DB::raw('COUNT(DISTINCT(paymaya_code)) as beneficiaries'),DB::raw('SUM(area) as area'),DB::raw('SUM(bags) as bags'))
                                ->where("coop_accreditation",$row)
                                ->get();
    
                // dd($provTarget);
                $provTgtBeneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(DISTINCT(paymaya_code)) as beneficiaries')))
                                            ->where("coopAccreditation",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $provTgtBeneficiaries = $provTgtBeneficiaries !== null ? $provTgtBeneficiaries : 0;
    
                $provTgtBags = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('COUNT(qr_code) as bags')))
                                            ->where("coopAccreditation",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                
                $provTgtBags = $provTgtBags !== null ? $provTgtBags : 0;
                
                $paymaya_codes = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                                            ->select(DB::raw(('DISTINCT(paymaya_code) as beneficiaries')))
                                            ->where("coopAccreditation",$row)
                                            ->whereBetween('date_created', [$date1, $date2])
                                            ->get();
                // dd($paymaya_codes);

                $actualArea = 0;
                // $test = array();

                foreach($paymaya_codes as $code)
                {
                    $getArea = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                    ->select('area')
                    ->where("coop_accreditation",$row)
                    ->where('paymaya_code',$code->beneficiaries)
                    ->first();
                    if($getArea){
                        $actualArea = $actualArea + $getArea->area;
                    }
        
                }
                // dd($actualArea, $test);
                // $query = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries')
                //         ->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.province as province', $GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.municipality as municipality',$GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.coop_accreditation as coop')
                //         ->selectRaw('SUM(ws2024_rcep_paymaya.tbl_beneficiaries.area) as `area`')
                //         ->whereIn($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.paymaya_code', function ($subquery) {
                //             $subquery->select($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim.paymaya_code')
                //                 ->from($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim');
                //         })
                //         ->where('tbl_beneficiaries.coop_accreditation', $row)
                //         ->whereBetween(DB::raw("DATE_FORMAT(tbl_beneficiaries.schedule_start, '%m/%d/%Y')"), [$date1, $date2])
                //         ->orWhereBetween(DB::raw("DATE_FORMAT(tbl_beneficiaries.schedule_end, '%m/%d/%Y')"), [$date1, $date2])
                //         ->groupBy($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries.coop_accreditation')
                //         ->get();

                // // dd($query);
                // $provTgtArea2 = 0;
                //     if(count($query) > 0){
                        
                //         foreach($query as $q)
                //         {
                //             if($q->coop == $row){
                //                 $provTgtArea2 = $q->area;
                //             }
                //         }
                //     }
                //     else{
                //         $provTgtArea = json_decode('[{"province": "","municipality": "","area": "0.00"}]');
                //         foreach($provTgtArea as $row){
                //             $provTgtArea2 = $row->area;
                //         }
                //     }
                    
                    // if($provTgtArea2!=0){
                        $amount = $provTgtBags[0]->bags * 760;

                        $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
                        ->select('coopName')
                        ->where('accreditation_no','=', $provTarget[0]->coop_accreditation)
                        ->get();

                        $coop = $getCoop[0]->coopName;

                        array_push($provTgt,array(
                            "coop" => $coop,
                            "coopAccreditation" => $provTarget[0]->coop_accreditation,
                            "date1" => date("m-d-Y", strtotime($request->date1)),
                            "date2" => date("m-d-Y", strtotime($request->date2)),
                            "beneficiaries" => number_format($provTarget[0]->beneficiaries),
                            "bags" => number_format($provTarget[0]->bags),
                            "area" => number_format($provTarget[0]->area,2),
                            "actualBeneficiaries" =>number_format($provTgtBeneficiaries[0]->beneficiaries),
                            "actualBags"=>number_format($provTgtBags[0]->bags),
                            "amount"=>"₱".(number_format($amount,2)),
                            "actualArea"=>number_format($actualArea,2)
                        )); 
                    // }
            }
            // dd($provTgt);
            $provTgt = collect($provTgt);
                return Datatables::of($provTgt)
            ->addColumn('action', function($row){
                $link = route('downloadDatedCoopData', ['coop' => $row["coop"], 'date1' => $row["date1"], 'date2' => $row["date2"]]);
                return  "<a href='$link' class='btn btn-success btn-sm'><i class='fa fa-download'></i> Download cooperative data</a>";            
            })
            ->make(true);
        }
            
    }

    public function downloadData(Request $request)
    {
        
        $getInfo = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"), 'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.province', '=', $request->province)
                ->where('tbl_claim.municipality', '=', $request->municipality)
                ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') >= '16:00:00'")
                ->get();
                
        $getInfo2 = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"), 'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.province', '=', $request->province)
                ->where('tbl_claim.municipality', '=', $request->municipality)
                ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') < '16:00:00'")
                ->get();
        
        $getInfo = array_merge($getInfo,$getInfo2);
        
        foreach($getInfo as $row)
        {

            $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
            ->select('coopName')
            ->where('accreditation_no','=', $row->Cooperative_Name)
            ->get();

            $row->Cooperative_Name = $getCoop[0]->coopName;

        }     
        
        $excel_data = json_decode(json_encode($getInfo), true);
        $filename = 'eBinhi_'.$request->province.'_'.$request->municipality;
        return Excel::create($filename, function($excel) use ($excel_data) {
        $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
            $sheet->fromArray($excel_data);
            $sheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');

            foreach ($excel_data as $key => $value) {
                $hour = date("H:i:s", strtotime($value["Date_Claimed"]));
                if (strtotime($hour) > strtotime("16:00:00")) {
                    $rowIndex = $key + 2; 
                    $cellRange = 'A' . $rowIndex . ':Q' . $rowIndex;
                    $sheet->getStyle($cellRange)->applyFromArray([
                        'fill' => [
                            'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFFFB01F']
                        ]
                    ]);
                }
            }
            $border_style = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '000000'),
                    ),
                ),
            );
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
        });
    })->setActiveSheetIndex(0)->download('xlsx');
    }

    public function downloadPrvData(Request $request)
    {

        $getInfo = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.province', '=', $request->province)
                ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') >= '16:00:00'")
                ->get();
                
        $getInfo2 = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.province', '=', $request->province)
                ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') < '16:00:00'")
                ->get();

        $getInfo = array_merge($getInfo,$getInfo2);

        foreach($getInfo as $row)
        {

            $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
            ->select('coopName')
            ->where('accreditation_no','=', $row->Cooperative_Name)
            ->get();

            $row->Cooperative_Name = $getCoop[0]->coopName;

        }
             
        // dd($getInfo);
        $excel_data = json_decode(json_encode($getInfo), true);
        $filename = 'eBinhi_'.$request->province;
        return Excel::create($filename, function($excel) use ($excel_data) {
        $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
            $sheet->fromArray($excel_data);
            $sheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');

            foreach ($excel_data as $key => $value) {
                $hour = date("H:i:s", strtotime($value["Date_Claimed"]));
                if (strtotime($hour) > strtotime("16:00:00")) {
                    $rowIndex = $key + 2; 
                    $cellRange = 'A' . $rowIndex . ':Q' . $rowIndex;
                    $sheet->getStyle($cellRange)->applyFromArray([
                        'fill' => [
                            'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFFFB01F']
                        ]
                    ]);
                }
            }
            $border_style = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '000000'),
                    ),
                ),
            );
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
        });
    })->setActiveSheetIndex(0)->download('xlsx');
    }

    public function downloadDatedData(Request $request)
    {
        if($request->selectedView == 'provincial'){
            $date1 = str_replace('-', '/', $request->date1);
            $date2 = str_replace('-', '/', $request->date2);
            
            $getInfo = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                    ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
                    'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                    'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                    'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                    ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                    ->where('tbl_claim.province', '=', $request->province)
                    ->where('tbl_claim.municipality', '=', $request->municipality)
                    ->whereBetween(DB::raw("DATE_FORMAT(tbl_claim.date_created, '%m/%d/%Y')"), [$date1, $date2])
                    ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') >= '16:00:00'")
                    ->get();
    
            $getInfo2 = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
            ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
            'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
            'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
            'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
            ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
            ->where('tbl_claim.province', '=', $request->province)
            ->where('tbl_claim.municipality', '=', $request->municipality)
            ->whereBetween(DB::raw("DATE_FORMAT(tbl_claim.date_created, '%m/%d/%Y')"), [$date1, $date2])
            ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') < '16:00:00'")
            ->get();
    
            $getInfo = array_merge($getInfo,$getInfo2);
    
            foreach($getInfo as $row)
            {
    
                $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
                ->select('coopName')
                ->where('accreditation_no','=', $row->Cooperative_Name)
                ->get();
    
                $row->Cooperative_Name = $getCoop[0]->coopName;
    
            }     
    
            $excel_data = json_decode(json_encode($getInfo), true);
            $filename = 'eBinhi_'.$request->province.'_'.$request->municipality.'('.$date1.' - '.$date2.')';
            return Excel::create($filename, function($excel) use ($excel_data) {
            $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
                $sheet->fromArray($excel_data);
                $sheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
                foreach ($excel_data as $key => $value) {
                    $hour = date("H:i:s", strtotime($value["Date_Claimed"]));
                    if (strtotime($hour) > strtotime("16:00:00")) {
                        $rowIndex = $key + 2; 
                        $cellRange = 'A' . $rowIndex . ':Q' . $rowIndex;
                        $sheet->getStyle($cellRange)->applyFromArray([
                            'fill' => [
                                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => ['argb' => 'FFFFB01F']
                            ]
                        ]);
                    }
                }
                $border_style = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                );
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
            });
        })->setActiveSheetIndex(0)->download('xlsx');
        }
        else if($request->selectedView == 'coop'){
            $coop = $request->province;
        
            $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
                    ->select('accreditation_no')
                    ->where('coopName','=', $coop)
                    ->get();
        
            $coop = $getCoop[0]->accreditation_no;

            $date1 = str_replace('-', '/', $request->date1);
            $date2 = str_replace('-', '/', $request->date2);
            
            $getInfo = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                    ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
                    'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                    'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                    'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                    ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                    ->where('tbl_claim.coopAccreditation', '=', $coop)
                    ->where('tbl_claim.municipality', '=', $request->municipality)
                    ->whereBetween(DB::raw("DATE_FORMAT(tbl_claim.date_created, '%m/%d/%Y')"), [$date1, $date2])
                    ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') >= '16:00:00'")
                    ->get();    
    
            $getInfo2 = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
            ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
            'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
            'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
            'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
            ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
            ->where('tbl_claim.coopAccreditation', '=', $coop)
            ->where('tbl_claim.municipality', '=', $request->municipality)
            ->whereBetween(DB::raw("DATE_FORMAT(tbl_claim.date_created, '%m/%d/%Y')"), [$date1, $date2])
            ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') < '16:00:00'")
            ->get();
    
            $getInfo = array_merge($getInfo,$getInfo2);
    
            foreach($getInfo as $row)
            {
    
                $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
                ->select('coopName')
                ->where('accreditation_no','=', $row->Cooperative_Name)
                ->get();
    
                $row->Cooperative_Name = $getCoop[0]->coopName;
    
            }     
    
            $excel_data = json_decode(json_encode($getInfo), true);
            $filename = 'eBinhi_'.$request->province.'_'.$request->municipality.'('.$date1.' - '.$date2.')';
            return Excel::create($filename, function($excel) use ($excel_data) {
            $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
                $sheet->fromArray($excel_data);
                $sheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
                foreach ($excel_data as $key => $value) {
                    $hour = date("H:i:s", strtotime($value["Date_Claimed"]));
                    if (strtotime($hour) > strtotime("16:00:00")) {
                        $rowIndex = $key + 2; 
                        $cellRange = 'A' . $rowIndex . ':Q' . $rowIndex;
                        $sheet->getStyle($cellRange)->applyFromArray([
                            'fill' => [
                                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => ['argb' => 'FFFFB01F']
                            ]
                        ]);
                    }
                }
                $border_style = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                );
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
                });
            })->setActiveSheetIndex(0)->download('xlsx');
        }
    }

    public function downloadDatedPrvData(Request $request)
    {
        $date1 = str_replace('-', '/', $request->date1);
        $date2 = str_replace('-', '/', $request->date2);
        
        $getInfo = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
                'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.province', '=', $request->province)
                ->whereBetween(DB::raw("DATE_FORMAT(tbl_claim.date_created, '%m/%d/%Y')"), [$date1, $date2])
                ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') >= '16:00:00'")
                ->get();

                $getInfo2 = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
                'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.province', '=', $request->province)
                ->whereBetween(DB::raw("DATE_FORMAT(tbl_claim.date_created, '%m/%d/%Y')"), [$date1, $date2])
                ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') < '16:00:00'")
                ->get();


        $getInfo = array_merge($getInfo,$getInfo2);
        foreach($getInfo as $row)
        {

            $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
            ->select('coopName')
            ->where('accreditation_no','=', $row->Cooperative_Name)
            ->get();

            $row->Cooperative_Name = $getCoop[0]->coopName;

        }     

        $excel_data = json_decode(json_encode($getInfo), true);
        $filename = 'eBinhi_'.$request->province.'('.$date1.' - '.$date2.')';
        return Excel::create($filename, function($excel) use ($excel_data) {
        $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
            $sheet->fromArray($excel_data);
            $sheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
            foreach ($excel_data as $key => $value) {
                $hour = date("H:i:s", strtotime($value["Date_Claimed"]));
                if (strtotime($hour) > strtotime("16:00:00")) {
                    $rowIndex = $key + 2; 
                    $cellRange = 'A' . $rowIndex . ':Q' . $rowIndex;
                    $sheet->getStyle($cellRange)->applyFromArray([
                        'fill' => [
                            'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFFFB01F']
                        ]
                    ]);
                }
            }
            $border_style = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '000000'),
                    ),
                ),
            );
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
        });
    })->setActiveSheetIndex(0)->download('xlsx');
    }

    public function downloadDatedCoopData($coop,$date1,$date2)
    {   

        $date1 = Carbon::createFromFormat('m-d-Y H:i:s', $date1 . ' 00:00:00')->format('Y-m-d H:i:s');
        $date2 = Carbon::createFromFormat('m-d-Y H:i:s', $date2 . ' 00:00:00')->format('Y-m-d H:i:s');


        if ($date1 == $date2) {
            $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $date2)->endOfDay()->format('Y-m-d H:i:s');
        }
        
        $getCoopAccred = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
            ->select('accreditation_no')
            ->where('coopName','=', $coop)
            ->first();
        $coopAccred = $getCoopAccred->accreditation_no;
        // dd($coopAccred);
        $getInfo = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
                'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as eBinhiCode', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', DB::raw('0 as Bags'), 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                ->where('tbl_claim.coopAccreditation', '=', $coopAccred)
                ->whereBetween('date_created', [$date1, $date2])
                // ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') >= '16:00:00'")
                ->groupBy('tbl_claim.paymaya_code')
                ->get();

                // $getInfo2 = DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
                // ->select('tbl_claim.coopAccreditation as Cooperative_Name', DB::raw("CONCAT(DATE_FORMAT(tbl_beneficiaries.schedule_start, '%M %d, %Y'), ' - ', DATE_FORMAT(tbl_beneficiaries.schedule_end, '%M %d, %Y')) as Schedule"),
                // 'tbl_claim.rsbsa_control_no as RSBSA_Number', 'tbl_beneficiaries.firstname as First_Name', 'tbl_beneficiaries.middname as Middle_Name',
                // 'tbl_beneficiaries.lastname as Last_Name', 'tbl_beneficiaries.extname as Ext_Name', 'tbl_claim.paymaya_code as e-Binhi_Code', 'tbl_claim.date_created as Date_Claimed', 'tbl_claim.province as Province','tbl_claim.municipality as Municipality',
                // 'tbl_claim.barangay as Barangay', 'tbl_claim.claimLocation as Pick-up_Point', 'tbl_claim.phoneNumber as Phone_Number', 'tbl_beneficiaries.area as Area', 'tbl_beneficiaries.bags as Bags', 'tbl_claim.seedVariety as Seed_Variety', DB::raw("IF(is_paid = 1, 'Procossed via RSMS', '-') as Remarks"))
                // ->join($GLOBALS['season_prefix'].'rcep_paymaya.tbl_beneficiaries', 'tbl_claim.paymaya_code', '=', 'tbl_beneficiaries.paymaya_code')
                // ->where('tbl_claim.coopAccreditation', '=', $coopAccred)
                // ->whereBetween('date_created', [$date1, $date2])
                // ->whereRaw("DATE_FORMAT(tbl_claim.date_created, '%H:%i:%s') < '16:00:00'")
                // ->groupBy('tbl_claim.paymaya_code')
                // ->get();


        // $getInfo = array_merge($getInfo,$getInfo2);
        foreach($getInfo as $row)
        {
            $getBags = count(DB::table($GLOBALS['season_prefix'].'rcep_paymaya.tbl_claim')
            ->where('paymaya_code',$row->eBinhiCode)
            ->where('coopAccreditation','=', $row->Cooperative_Name)
            ->get());


            $getCoop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
            ->select('coopName')
            ->where('accreditation_no','=', $row->Cooperative_Name)
            ->get();
            $row->Bags = $getBags;
            $row->Cooperative_Name = $getCoop[0]->coopName;

        }     

        $excel_data = json_decode(json_encode($getInfo), true);
        $filename = 'eBinhi_'.$coop.'('.$date1.' - '.$date2.')';
        return Excel::create($filename, function($excel) use ($excel_data) {
        $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
            $sheet->fromArray($excel_data);
            $sheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
            foreach ($excel_data as $key => $value) {
                $hour = date("H:i:s", strtotime($value["Date_Claimed"]));
                if (strtotime($hour) > strtotime("16:00:00")) {
                    $rowIndex = $key + 2; 
                    $cellRange = 'A' . $rowIndex . ':Q' . $rowIndex;
                    $sheet->getStyle($cellRange)->applyFromArray([
                        'fill' => [
                            'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => 'FFFFB01F']
                        ]
                    ]);
                }
            }
            $border_style = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '000000'),
                    ),
                ),
            );
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
        });
    })->setActiveSheetIndex(0)->download('xlsx');
    }
    
}
