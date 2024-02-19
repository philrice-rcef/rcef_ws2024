<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Session;
use Auth;

use Yajra\Datatables\Facades\Datatables;

class StationReportController extends Controller
{

    public function index(){
        return view('reports.station.index');
    }

    public function home(){
        //$covered_regions = DB::connection('mysql')->table('lib_stations_aoc')->where('station_id', Auth::user()->stationId)->get();
        $station_list = DB::table('geotag_db2.tbl_station')->get();
        return view('reports.station.home')
            ->with('station_list', $station_list);
    }

    public function load_coop_details(Request $request){
        $coop = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives')
            ->where('accreditation_no', $request->accreditation_no)
            ->first();

        return array(
            "coop_name" => $coop->coopName,
            "coop_accreditation" => $coop->accreditation_no
        );
    }

    /**
     * NEW FUNCTIONS - REVAMPED DASHBOARD
     */

    public function load_station_areas(Request $request){
        /*$station_areas = DB::table($GLOBALS['season_prefix'].'rcep_reports_mirror.lib_station_report')->where('station_id', $request->station)->get();
        $return_str = '';
        foreach($station_areas as $row){
            if($row->province_code == ''){
                $return_str .= "<option value='$row->id'>$row->region_name</option>";
            }else{
                $return_str .= "<option value='$row->id'>$row->region_name / $row->province_name</option>";
            }                
        }

        return $return_str;*/

        $return_str = '';
        $station_areas_regions = DB::table($GLOBALS['season_prefix'].'sdms_db_dev.lib_station')->where('stationID', $request->station)->groupBy('region')->get();
        foreach($station_areas_regions as $region_row){
            $return_str .= "<option value='REGION_$region_row->region'>$region_row->region</option>"; 
        }

        $station_areas_provinces = DB::table($GLOBALS['season_prefix'].'sdms_db_dev.lib_station')->where('stationID', $request->station)->groupBy('province')->get();
        foreach($station_areas_provinces as $row){
            $return_str .= "<option value='REGIONPROV_$row->province'>$row->region / $row->province</option>";            
        }

        return $return_str;
    }

    public function load_regional_report_values(Request $request){
        $id_str = explode("_", $request->area_id);
        $category = $id_str[0];
        $id = $id_str[1];
        $total_municipalities = 0;
        $transferred_bags = 0;
        $total_bags = 0;
        $total_confirmed = 0;
        $farmer_beneficiaries = 0;
        if($category == "REGION"){
            // $area = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')->where('id', $id)->first();
            $total_provinces = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')
                        ->where('region', $id)
                        ->groupBy('province')
                        ->get();

            foreach ($total_provinces as $key => $prs) {
                $total_municipalities += intval($prs->total_municipalities);
                // $confirmed_deliveries += intval($prs->total_confirmed_bags);
                $transferred_bags += intval($prs->total_transferred_bags);
                // $total_bags += intval($prs->total_bags) + intval($prs->total_bags_ebinhi);
                $total_confirmed += intval($prs->total_inspected_bags) + intval($prs->total_inspected_bags_ebinhi);
                $farmer_beneficiaries += intval($prs->total_farmers) + intval($prs->total_farmers_ebinhi);
            }

        
        }else{
            $total_provinces = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')
            ->where('province', $id)
            ->groupBy('province')
            ->get();

            foreach ($total_provinces as $key => $prs) {
                $total_municipalities += intval($prs->total_municipalities);
                // $confirmed_deliveries += intval($prs->total_confirmed_bags);
                $transferred_bags += intval($prs->total_transferred_bags);
                // $total_bags += intval($prs->total_bags) + intval($prs->total_bags_ebinhi);
                $total_confirmed += intval($prs->total_inspected_bags) + intval($prs->total_inspected_bags_ebinhi);
                $farmer_beneficiaries += intval($prs->total_farmers) + intval($prs->total_farmers_ebinhi);
            }
            
        }

        return array(
            'total_provinces' => number_format(count($total_provinces)),
            'total_municipalities' => number_format($total_municipalities),
            'total_bags' => number_format($total_confirmed + $transferred_bags),
            'total_confirmed' => number_format($total_confirmed),
            'farmer_beneficiaries' => number_format($farmer_beneficiaries)
        );
    } 

    public function load_regional_report_values2(Request $request){
        //check if area has tagged province
        $area = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_station_report')->where('id', $request->area_id)->first();

        if($area->province_name == ''){
            $total_provinces = DB::connection('delivery_inspection_db')->table('tbl_actual_delivery')
                ->where('region', $area->region_name)
                ->groupBy('province')
                ->get();

            $total_municipalities = DB::connection('delivery_inspection_db')->table('tbl_actual_delivery')
                ->where('region', $area->region_name)
                ->groupBy('province', 'municipality')
                ->get();

            $confirmed_deliveries = DB::connection('delivery_inspection_db')->table('tbl_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'batchTicketNumber')
                ->where('region', $area->region_name)
                ->where('is_cancelled', 0)
                ->groupBy('batchTicketNumber')
                ->get();

            $total_bags = 0;
            $total_confirmed = 0;
            foreach($confirmed_deliveries as $row){
                $check_actual_delivery = DB::connection('delivery_inspection_db')->table('tbl_actual_delivery')
                    ->select(DB::raw('SUM(totalBagCount) as total_bags'))
                    ->where('batchTicketNumber', $row->batchTicketNumber)
                    ->first();
    
                if(count($check_actual_delivery) > 0){
                    $total_bags += $check_actual_delivery->total_bags;
                }
    
                $total_confirmed += $row->total_bags; 
            }

            //get total beneficiaries
            $farmer_beneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_reports_mirror.lib_regional_reports')->where('region', $area->region_name)->value('total_farmers');
        
        }else{
            $total_provinces = DB::connection('delivery_inspection_db')->table('tbl_actual_delivery')
                ->where('region', $area->region_name)
                ->where('province', $area->province_name)
                ->groupBy('province')
                ->get();

            $total_municipalities = DB::connection('delivery_inspection_db')->table('tbl_actual_delivery')
                ->where('region', $area->region_name)
                ->where('province', $area->province_name)
                ->groupBy('province', 'municipality')
                ->get();

            $confirmed_deliveries = DB::connection('delivery_inspection_db')->table('tbl_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'batchTicketNumber')
                ->where('region', $area->region_name)
                ->where('province', $area->province_name)
                ->where('is_cancelled', 0)
                ->groupBy('batchTicketNumber')
                ->get();

            $total_bags = 0;
            $total_confirmed = 0;
            foreach($confirmed_deliveries as $row){
                $check_actual_delivery = DB::connection('delivery_inspection_db')->table('tbl_actual_delivery')
                    ->select(DB::raw('SUM(totalBagCount) as total_bags'))
                    ->where('batchTicketNumber', $row->batchTicketNumber)
                    ->first();

                if(count($check_actual_delivery) > 0){
                    $total_bags += $check_actual_delivery->total_bags;
                }

                $total_confirmed += $row->total_bags; 
            }

            //get total beneficiaries
            $farmer_beneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_reports_mirror.lib_provincial_reports')
                ->where('region', $area->region_name)
                ->where('province', $area->province_name)
                ->value('total_farmers');
        }

        return array(
            'total_provinces' => number_format(count($total_provinces)),
            'total_municipalities' => number_format(count($total_municipalities)),
            'total_bags' => number_format($total_bags),
            'total_confirmed' => number_format($total_confirmed),
            'farmer_beneficiaries' => number_format($farmer_beneficiaries)
        );
    }

    public function load_seed_coopList(Request $request){
        $id_str = explode("_", $request->area_id);
        $category = $id_str[0];
        $id = $id_str[1];

        // $area = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')->where('id', $id)->first();
        if($category == "REGION"){
            $cooperatives = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_delivery')
                ->select('tbl_cooperatives.coopName', 'tbl_cooperatives.accreditation_no')
                ->join($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives', function ($table_join) {
                    $table_join->on('tbl_cooperatives.accreditation_no', '=', 'tbl_delivery.coopAccreditation');
                })
                ->where('tbl_delivery.region', $id)
                ->groupBy('tbl_cooperatives.accreditation_no')
                ->get();
        }else{
            $cooperatives = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_delivery')
                ->select('tbl_cooperatives.coopName', 'tbl_cooperatives.accreditation_no')
                ->join($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_cooperatives', function ($table_join) {
                    $table_join->on('tbl_cooperatives.accreditation_no', '=', 'tbl_delivery.coopAccreditation');
                })
                // ->where('rcep_delivery_inspection_mirror.tbl_delivery.region', $area->region)
                ->where('tbl_delivery.province', $id)
                ->groupBy('tbl_cooperatives.accreditation_no')
                ->get();
        }
       
        $coop_list = array();
        $row_count = 1;
        foreach($cooperatives as $row){
            $row_arr = array(
                'coop_name' => $row->coopName,
                'row_count' => $row_count,
                'coop_accreditation' => $row->accreditation_no
            );
            array_push($coop_list, $row_arr);

            $row_count++;
        }

        $coop_list = collect($coop_list);
        return Datatables::of($coop_list)
        ->addColumn('coop_link', function($row){
            return '<a href="#" data-toggle="modal" data-target="#seed_coop_details" class="coop-link" data-accreditation_no="'.$row['coop_accreditation'].'">'.$row['coop_name'].'</a>';
        })
        ->make(true);
    }


    public function load_region_varieties(Request $request){
        $id_str = explode("_", $request->area_id);
        $category = $id_str[0];
        $id = $id_str[1];

        // $area = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')->where('id', $id)->first();
        if($category == "REGION"){
            $varieties = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'seedVariety')
                ->where('region', $id)
                ->groupBy('seedVariety')
                ->get();
        }else{
            $varieties = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'seedVariety')
                // ->where('region', $area->region)
                ->where('province', $id)
                ->groupBy('seedVariety')
                ->get();
        }

        $variety_list = array();
        $row_count = 1;

        foreach($varieties as $row){
            $row_arr = array(
                "seed_variety" => $row->seedVariety,
                "row_count" => $row_count,
                "seed_volume" => number_format($row->total_bags)
            );
            array_push($variety_list, $row_arr);

            $row_count++;
        }

        $variety_list = collect($variety_list);
        return Datatables::of($variety_list)->make(true);
    }


    public function compute_transferred($region, $province){
        $bags = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection_mirror.tbl_actual_delivery')
            ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'batchTicketNumber')
            ->where('region', $region)
            ->where('province', $province)
            ->where('batchTicketNumber', "TRANSFER")
            ->groupBy('batchTicketNumber')
            ->value('total_bags');

        return $bags;
    }

    public function load_region_seeed_chartData(Request $request){
        $id_str = explode("_", $request->area_id);
        $category = $id_str[0];
        $id = $id_str[1];

        // $area = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')->where('id', $id)->first();
        if($category == "REGION"){
            $varieties = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'seedVariety')
                ->where('region', $id)
                ->groupBy('seedVariety')
                ->get();
        }else{
            $varieties = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'seedVariety')
                // ->where('region', $area->region)
                ->where('province', $id)
                ->groupBy('seedVariety')
                ->get();
        }

        $variety_list = array();
        foreach($varieties as $row){
            $row_arr = array(
                "name" => $row->seedVariety,
                "y" => intval($row->total_bags),
                "sliced" => true
            );
            array_push($variety_list, $row_arr);
            //$variety_list .= "{name: '".$row->seedVariety."', y: ".$row->total_bags.", sliced:true},";
        }

        return $variety_list;
    }

    function compute_inspected_station_report($region_name, $province_name){
        $total_inspected = 0;

        $confirmed = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection_mirror.tbl_delivery')
            ->select('batchTicketNumber')
            ->where('region', $region_name)
            ->where('province', $province_name)
            ->where('is_cancelled', 0)
            ->where('region', '!=', '')
            ->groupBy('batchTicketNumber')
            ->get();

        foreach($confirmed as $confirmed_row){
            $actual = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection_mirror.tbl_actual_delivery')
                ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'batchTicketNumber')
                ->where('region', $region_name)
                ->where('province', $province_name)
                ->where('batchTicketNumber', $confirmed_row->batchTicketNumber)
                //->where('batchTicketNumber',"!=","TRANSFER")
                ->groupBy('batchTicketNumber')
                ->value('total_bags');

            $total_inspected += $actual;
        }

        return $total_inspected;
    }
    
    function compute_distributed($region_name, $province_name){
        $distributed = DB::table($GLOBALS['season_prefix'].'rcep_reports_mirror.lib_provincial_reports')
            ->where('region', $region_name)
            ->where('province', $province_name)
            ->value('total_bags');

        return $distributed;
    }

    function compute_farmers($region_name, $province_name){
        $farmers = DB::table($GLOBALS['season_prefix'].'rcep_reports_mirror.lib_provincial_reports')
            ->where('region', $region_name)
            ->where('province', $province_name)
            ->value('total_farmers');

        return $farmers;
    }

    function compute_target($station_id){
        $target = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')
            ->where('station_id', $station_id)
            ->sum('total_value');

        return $target;
    }

    function compute_station_data(){
        DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_station_report_data')->truncate();
        $station_list = DB::table('geotag_db2.tbl_station')->get();

        $station_arr_list = array();
        $station_confirmed_arr = array();
        $station_inspected_arr = array();
        $station_farmers_arr = array();
        $station_transferred_seeds = array();

        foreach($station_list as $row){
            $total_station_confirmed = 0;
            $total_station_inspected = 0;
            $total_station_distributed = 0;
            $total_transffered_bags = 0;

            $area_list = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')->where('station_id', $row->stationId)->groupBy('province')->get();
            foreach($area_list as $area_row){
                $confirmed = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection_mirror.tbl_delivery')
                    ->select(DB::raw('SUM(totalBagCount) as total_bags'), 'seedVariety')
                    ->where('region', $area_row->region)
                    ->where('province', $area_row->province)
                    ->where('is_cancelled', 0)
                    ->where('region', '!=', '')
                    ->first();

                $inspected = $this->compute_inspected_station_report($area_row->region, $area_row->province);
                $distributed = $this->compute_distributed($area_row->region, $area_row->province);
                $transferred = $this->compute_transferred($area_row->region, $area_row->province);

                $total_station_confirmed += $confirmed->total_bags;
                $total_station_inspected += $inspected;
                $total_station_distributed += $distributed;
                $total_transffered_bags += $transferred;
            }

            if($total_station_confirmed > 0){
                $row_arr = array(
                    'station_id' => $row->stationId,
                    'station_name' => $row->stationName == 'Central Experiment Station' ? 'CES' : $row->stationName,
                    'confirmed_bags' => $total_station_confirmed,
                    'inspected_bags' => $total_station_inspected,
                    'transferred_bags' => $total_transffered_bags
                );
                DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_station_report_data')->insert($row_arr);
            }
        }
    }

    // bar graph station dashboard
    function load_station_data(Request $request){
        $station_name_arr = array();
        $confirmed_bags_arr = array();
        $inspected_bags_arr = array();
        $distributed_bags_arr = array();
        $target_arr = array();
        $farmers_arr = array();
        $transfer_arr = array();

        // $station_data = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_station_report_data')->get();
        $station_data = DB::table('geotag_db2.tbl_station')->get();
        foreach($station_data as $row){

            $total_station_distributed = 0;
            $total_station_farmers = 0;
            $total_target = 0;
            $commitment = 0;
            $confirmed = 0;
            $inspected = 0;
            $transferred = 0;

            $total_target = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_allocation')
                ->where('station_name', $row->stationName)
                ->sum('allocation');

            $station_prv = DB::table($GLOBALS['season_prefix'].'sdms_db_dev.lib_station')
                ->select()
                ->where('station', $row->stationName)
                ->get();

            foreach ($station_prv as $key => $sp) {
                
                $processed = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')
                        ->where('province', $sp->province)
                        ->first();

                $commitment += DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitment_province')
                    ->where('province', $sp->province)
                    ->sum('volume');
                
                if(count($processed) > 0){
                    $confirmed += $processed->total_confirmed_bags;
                    $inspected += intval($processed->total_inspected_bags) + intval($processed->total_inspected_bags_ebinhi);
                    $transferred += $processed->total_transferred_bags;
                    $total_station_distributed += intval($processed->total_bags) + intval($processed->total_bags_ebinhi);
                    $total_station_farmers += intval($processed->total_farmers) + intval($processed->total_farmers_ebinhi);
                }
                // $confirmed += DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_delivery')
                //     ->where('province', $sp->province)
                //     ->where('is_cancelled', 0)
                //     ->sum('totalBagCount');

                // $inspected += DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
                //     ->where('province', $sp->province)
                //     ->where('is_transferred', 0)
                //     ->where('isRejected', 0)
                //     ->sum('totalBagCount');
            
                // $transferred += DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
                //     ->where('province', $sp->province)
                //     ->where('is_transferred', 1)
                //     ->sum('totalBagCount');

                // $prv_code = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.lib_prv')
                //     ->where('province', $sp->province)
                //     ->first();

                // if($prv_code != null ){
                //     $prv_db = $GLOBALS['season_prefix']."prv_". $prv_code->prv_code;

                //     $total_station_distributed += DB::table($prv_db. '.released')
                //         // ->groupBy('farmer_id')
                //         ->sum('bags');

                //     $tsf = DB::table($prv_db. '.released')
                //         ->groupBy('farmer_id')
                //         ->get();

                //     $total_station_farmers +=  count($tsf);
                // }
            }
            // $station_area_list = DB::table($GLOBALS['season_prefix'].'rcep_seed_cooperatives.tbl_commitmet_per_province')->where('station_id', $row->stationId)->groupBy('province')->get();

            // foreach($station_area_list as $area_row){
            //     $distributed = $this->compute_distributed($area_row->region, $area_row->province);
            //     $farmers = $this->compute_farmers($area_row->region, $area_row->province);
                
            //     $total_station_distributed += $distributed;
            //     $total_station_farmers += $farmers;
            // }

            // $total_target  += $this->compute_target($row->stationId);

            array_push($station_name_arr, $row->stationName);
            array_push($confirmed_bags_arr, intval($confirmed));
            array_push($inspected_bags_arr, intval($inspected));
            array_push($distributed_bags_arr, $total_station_distributed);
            array_push($farmers_arr, $total_station_farmers);
            array_push($target_arr,intval(( $total_target == null) ? 0 : $total_target));
            array_push($transfer_arr, intval($transferred));
        }

        return array(
            'station_list' => $station_name_arr,
            'confirmed_list' => $confirmed_bags_arr,
            'inspected_list' => $inspected_bags_arr,
            'distributed_list' => $distributed_bags_arr,
            'farmer_list' => $farmers_arr,
            'target_list' => $target_arr,
            'transferred_list' => $transfer_arr
        );
    }

    function load_station_progress(Request $request){
         $province_covered = DB::table($GLOBALS['season_prefix'].'sdms_db_dev.lib_station')->where('stationID', $request->station)->groupBy('province')->get();
        //  $regions_covered = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')->groupBy('province')->get();

         $total_provinces = 0;
         $total_municipalities = 0;
         $total_inspected_bags = 0;
         $total_area = 0;
         $total_beneficiaries = 0;
         $total_transferred_bags = 0;
         $total_distributed = 0;
 
         $target_provinces = 0;
         $target_bags = 0;
 
         $reported_provinces = 0;
         $reported_municipalities = 0;
         $reported_bags = 0;
         $reported_beneficiaries = 0;
 
         foreach($province_covered as $row){
            $prov_data = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')->where('province', $row->province)->groupBy('province')->first();
            if(count($prov_data) > 0){
                $total_area += floatval($prov_data->total_claimed_area) + floatval($prov_data->total_claim_area_ebinhi);
                $total_beneficiaries += intval($prov_data->total_farmers) + intval($prov_data->total_farmers_ebinhi);
                $total_inspected_bags += intval($prov_data->total_inspected_bags) + intval($prov_data->total_inspected_bags_ebinhi);
                $total_transferred_bags += intval($prov_data->total_transferred_bags);
                $total_distributed += intval($prov_data->total_bags) + intval($prov_data->total_bags_ebinhi);
                $total_municipalities += intval($prov_data->total_municipalities);
                $total_provinces++;
            }
            

         }
         $reported_distributed = DB::table($GLOBALS['season_prefix'].'rcep_reports.tbl_excel_reported')->where('station_id', $request->station)->sum('total_distibuted_bags');
        $reported_provinces = count(DB::table($GLOBALS['season_prefix'].'rcep_reports.tbl_excel_reported')->where('station_id', $request->station)->groupBy('province')->get());
          
         $target = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_allocation')->where('station_id', $request->station)->get();
         foreach($target as $t_row){
             $target_bags += $t_row->allocation;
         } 
         $target_provinces += count(DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_allocation')->where('station_id', $request->station)->groupBy('province')->get());
         return array(
             'sms_provinces' => $total_provinces,
             'sms_municipalities' => number_format($total_municipalities),
             'sms_inspected' => number_format($total_inspected_bags),
             'sms_area' => number_format($total_area, "2", ".", ","),
             'sms_beneficiaries' => number_format($total_beneficiaries),
             'sms_transferred' => number_format($total_transferred_bags),
             'sms_distributed' => number_format($total_distributed),
 
             'target_provinces' => $target_provinces,
             'target_bags' => number_format($target_bags),
             
             'reported_provinces' => $reported_provinces,
            'reported_municipalities' => $reported_municipalities,
            // 'reported_bags' => number_format($reported_bags),
            'reported_bags' => 'N/A',
            // 'report_beneficiaries' => number_format($total_report_beneficiaries),
            'report_beneficiaries' => 'N/A',
			'report_transferred' => 'N/A',
			'report_distributed' => number_format($reported_distributed) 
         );
    }

    function load_station_progress_all(Request $request){
        // $regions_covered = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_allocation')->groupBy('region')->get();
        $regions_covered = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')->groupBy('province')->get();

        $total_provinces = 0;
        $total_municipalities = 0;
        $total_inspected_bags = 0;
        $total_area = 0;
        $total_beneficiaries = 0;
        $total_transferred_bags = 0;
        $total_distributed = 0;

        $target_provinces = 0;
        $target_bags = 0;

        $reported_provinces = 0;
        $reported_municipalities = 'N/A';
        $reported_bags = 0;
        $reported_beneficiaries = 0;
        

        foreach($regions_covered as $row){

            //rcep sms data
            // $lib_region_data = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_regional_reports')
            //     ->where('region', $row->region)
            //     ->first();
			// if(count($lib_region_data) > 0){
				//$total_provinces += $lib_region_data->total_provinces;
				//$total_municipalities += $lib_region_data->total_municipalities;

				/*$total_provinces += count(DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
					->where('region',$row->region)
					->where('region', '!=', '')
					->groupBy('province')->get());*/
				//$total_municipalities += count(DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_delivery')->where('region',$row->region)->groupBy('province','municipality')->get());
				
				// $total_beneficiaries += $lib_region_data->total_farmers;
				// $total_area += $lib_region_data->total_actual_area;

                // $processed = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_provincial_reports')
                //         ->where('province', $sp->province)
                //         ->first();
                
               
                    // $total_area += $row->total_claimed_area;
                    // $total_beneficiaries += $row->total_farmers;
                    // $total_inspected_bags += $row->total_inspected_bags;
                    // $total_transferred_bags += $row->total_transferred_bags;
                    // $total_distributed += $row->total_bags;
                    // $total_municipalities += $row->total_municipalities;

                    $total_area += floatval($row->total_claimed_area) + floatval($row->total_claim_area_ebinhi);
                    $total_beneficiaries += intval($row->total_farmers) + intval($row->total_farmers_ebinhi);
                    $total_inspected_bags += intval($row->total_inspected_bags) + intval($row->total_inspected_bags_ebinhi);
                    $total_transferred_bags += intval($row->total_transferred_bags);
                    $total_distributed += intval($row->total_bags) + intval($row->total_bags_ebinhi);
                    $total_municipalities += intval($row->total_municipalities);
                    $total_provinces++;
               

                // $prv_code = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.lib_prv')
                //     ->where('regionName', $row->region)
                //     ->groupBy('province')
                //     ->get();

                // $farmer_beneficiaries = 0;
                // foreach ($prv_code as $key => $value) {
                //     if($prv_code != null ){
                //         $prv_db = $GLOBALS['season_prefix']."prv_". $value->prv_code;
        
                //         $total_area += DB::table($prv_db. '.released')
                //             // ->groupBy('farmer_id')
                //             ->sum('claimed_area');
        
                //         // $total_beneficiaries += DB::table($prv_db. '.released')
                //         //     ->groupBy('farmer_id')
                //         //     ->count();
                //         $tsf = DB::table($prv_db. '.released')
                //             ->groupBy('farmer_id')
                //             ->get();

                //         $total_beneficiaries +=  count($tsf);
                //     }
                // }
				//target data
				

				//reported data
				//$reported_provinces += count(DB::table($GLOBALS['season_prefix'].'rcep_reports.weekly_report_municipal')->where('region', $row->region)->groupBy('province')->get());
				//$reported_municipalities += count(DB::table($GLOBALS['season_prefix'].'rcep_reports.weekly_report_municipal')->where('region', $row->region)->groupBy('municipality')->get());
				//$reported_bags += DB::table($GLOBALS['season_prefix'].'rcep_reports.weekly_report_municipal')->where('region', $row->region)->sum('num_bag_confirmed_inspected');
				
				//get latest date of weekly reports
				// $latest_date = DB::table($GLOBALS['season_prefix'].'rcep_google_sheets.lib_weekly_municipal')->orderBy('date_generated')->first()->date_generated;
				// $reported_provinces += DB::table($GLOBALS['season_prefix'].'rcep_google_sheets.lib_weekly_municipal')->select(DB::raw('COUNT(province) as total_provinces'))
				// 	->where('region', $row->region)->where('total_farmers', '!=', 0)
				// 	->where('date_generated', $latest_date)
				// 	->groupBy('province')
				// 	->value('total_provinces');
				// $reported_municipalities += DB::table($GLOBALS['season_prefix'].'rcep_google_sheets.lib_weekly_municipal')->select(DB::raw('COUNT(municipality) as total_municipalities'))
				// 	->where('region', $row->region)->where('total_farmers', '!=', 0)
				// 	->groupBy('date_generated')
				// 	->value('total_municipalities');
				// $reported_bags += DB::table($GLOBALS['season_prefix'].'rcep_google_sheets.lib_weekly_municipal')->where('region', $row->region)->groupBy('date_generated')->sum('total_bags');
			// }
        }


        // $total_inspected_bags = \DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
        //             ->select(\DB::RAW('SUM(totalBagCount) as total_bag_count'))
        //             // ->where('batchTicketNumber',"!=","TRANSFER")
        //             ->where('is_transferred', "!=", 1)
        //             ->value('total_bag_count');
		
		// $total_transferred_bags = \DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
        //             ->select(\DB::RAW('SUM(totalBagCount) as total_bag_count'))
        //             ->where('is_transferred', 1)
        //             ->value('total_bag_count');
					
		// $total_distributed = DB::table($GLOBALS['season_prefix'].'rcep_reports.lib_national_reports')->value('total_bags');
		$reported_distributed = DB::table($GLOBALS['season_prefix'].'rcep_reports.tbl_excel_reported')->sum('total_distibuted_bags');
        $reported_provinces = count(DB::table($GLOBALS['season_prefix'].'rcep_reports.tbl_excel_reported')->groupBy('province')->get());
		
		// $total_provinces = count(DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
		// 		->where('region', '!=', '')
		// 		->where('province', '!=', '')
		// 		->where('is_transferred', '!=', 1)
		// 		->groupBy('province')->get());
		// $total_municipalities = count(DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_actual_delivery')
		// 	->where('region', '!=', '')
		// 	->where('province', '!=', '')
		// 	->where('municipality', '!=', '')
		// 	->where('is_transferred', '!=', 1)
		// 	->groupBy('province','municipality')->get());
					
		// $total_report_beneficiaries = DB::table($GLOBALS['season_prefix'].'rcep_reports.tbl_excel_reported')->sum('total_farmers_reported');
        //$total_inspected_bags = DB::table($GLOBALS['season_prefix'].'rcep_reports_mirror.lib_station_report_data')->sum('inspected_bags');
        $target = DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_allocation')->get();
        foreach($target as $t_row){
            $target_bags += $t_row->allocation;
        }

        $target_provinces += count(DB::table($GLOBALS['season_prefix'].'rcep_delivery_inspection.tbl_allocation')->groupBy('province')->get());
        return array(
            'sms_provinces' => count($regions_covered),
            'sms_municipalities' => number_format($total_municipalities),
            'sms_inspected' => number_format($total_inspected_bags),
            'sms_area' => number_format($total_area, "2", ".", ","),
            'sms_beneficiaries' => number_format($total_beneficiaries),
			'sms_transferred' => number_format($total_transferred_bags),
			'sms_distributed' => number_format($total_distributed),

            'target_provinces' => $target_provinces,
            'target_bags' => number_format($target_bags),
            
            'reported_provinces' => $reported_provinces,
            'reported_municipalities' => $reported_municipalities,
            // 'reported_bags' => number_format($reported_bags),
            'reported_bags' => 'N/A',
            // 'report_beneficiaries' => number_format($total_report_beneficiaries),
            'report_beneficiaries' => 'N/A',
			'report_transferred' => 'N/A',
			'report_distributed' => number_format($reported_distributed) 
        );
    }

}
