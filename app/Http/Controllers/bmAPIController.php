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
use Illuminate\Support\Str;

class bmAPIController extends Controller
{
    public function seedAnalysisAPI(Request $request){
        $season = 'ds2024';
        $getDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_delivery')
        ->select( 'coopAccreditation', 'batchTicketNumber', 'seedTag', 'seedVariety', DB::raw('SUM(totalBagCount) as bags'), 'province', 'municipality', 'prv_dropoff_id', 'dropOffPoint')
        ->groupBy('coopAccreditation', 'province', 'batchTicketNumber', 'seedVariety')
        ->get();

        $result = [];
        // dd($getDelivery);
        $totalBagsNew = [];
        foreach($getDelivery as $delivery)
        {
            $coop = $delivery->coopAccreditation;
            $prv = $delivery->province;
            $variety = $delivery->seedVariety;
            $type = 'N';
            $totalBags[$coop][$prv][$variety][$type] = 0;

            $getActualDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_actual_delivery')
            ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
            ->where('batchTicketNumber', 'LIKE',$delivery->batchTicketNumber)
            ->where('province', 'LIKE',$delivery->province)
            ->where('seedVariety', 'LIKE',$delivery->seedVariety)
            // ->where('seedTag', 'LIKE',$delivery->seedTag)
            ->groupBy('batchTicketNumber','province','seedVariety')
            ->where('isBuffer', 0)
            ->first();

            $totalBags[$coop][$prv][$variety][$type] += $getActualDelivery->total_bags;
        }
        dd($totalBags);
    }
    
    public function codes(){
        
        
        
        $getExtPrvs = DB::connection('ws2021')->table('information_schema.tables')
        ->select('TABLE_NAME','TABLE_SCHEMA')
        ->where('TABLE_NAME', 'LIKE', 'prv_%')
        ->where('TABLE_ROWS', '>', 0)
        ->where('TABLE_SCHEMA', 'LIKE','rcep_extension_db')
        ->get();
    
        // $getReleasedPrvs = DB::connection('ws2021')->table('information_schema.tables')
        // ->select('TABLE_NAME','TABLE_SCHEMA')
        // ->where('TABLE_NAME', 'LIKE', 'released')
        // ->where('TABLE_ROWS', '>', 0)
        // ->where('TABLE_SCHEMA', 'LIKE','prv_%')
        // ->get();
    
        // dd($getExtPrvs,$getReleasedPrvs);
    
        $allKpData = array();
    
        foreach($getExtPrvs as $prv)
        {
            $extDB = $prv->TABLE_SCHEMA.'.'.$prv->TABLE_NAME;
            $releasedDB = $prv->TABLE_NAME.'.released';
            // dd($extDB,$releasedDB);
            
            $getKPdata = DB::connection('ws2021')->table($extDB)
            ->select('province','municipality',DB::raw('COUNT(DISTINCT(rsbsa_control_no)) as totalFarmersWithKp'),DB::raw('SUM(kp1) as kp1'),DB::raw('SUM(kp2) as kp2'),DB::raw('SUM(kp3) as kp3'),DB::raw('SUM(calendar) as calendar'),DB::raw('SUM(ksl) as ksl'))
            ->groupBy('province')
            ->groupBy('municipality')
            ->get();
    
            foreach($getKPdata as $row)
            {
                $totalFarmers = DB::connection('ws2021')->table($releasedDB)
                ->select(DB::raw('COUNT(DISTINCT(rsbsa_control_no)) as count'))
                ->where('province','LIKE',$row->province)
                ->where('municipality','LIKE',$row->municipality)
                ->first();
    
                array_push($allKpData,array(
                    "province" => $row->province,
                    "municipality" => $row->municipality,
                    "totalFarmers" => $totalFarmers->count,
                    "totalFarmersWithKp" => $row->totalFarmersWithKp,
                    "kp1" => $row->kp1,
                    "kp2" => $row->kp2,
                    "kp3" => $row->kp3,
                    "calendar" => $row->calendar,
                    "ksl" => $row->ksl,
                ));
            }
            // dd($allKpData);
        }
        // dd($allKpData);
    
        $excel_data = json_decode(json_encode($allKpData), true);
        $filename = 'KP Distribution - ws2021';
        return Excel::create($filename, function($excel) use ($excel_data) {
            $excel->sheet("Farmer Information", function($sheet) use ($excel_data) {
                $sheet->fromArray($excel_data);
                $sheet->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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
        
        $apiUrl = 'http://192.168.10.54:3000/api/distribution/2023_ws/INBRED/0645/06-45/sPTfiZrgzCo3R*rWjpZnHw=';

        $getAPIdataURL = 'http://192.168.10.54:3000/api/distribution/2023_ws/INBRED/0645/06-45/sPTfiZrgzCo3R*rWjpZnHw=';

        $apiResponse = file_get_contents($getAPIdataURL);
        
        $response = json_decode($apiResponse);
        
        dd($response[0]);




        try{
            $curl = curl_init();
    
            // Set cURL options
            curl_setopt_array($curl, array(
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false, // Avoid SSL certificate verification (not recommended in production)
            ));
    
            // Execute cURL request and get the response
            $response = curl_exec($curl);
    
            // Check for errors
            if ($response === false) {
                $error = curl_error($curl);
                curl_close($curl);
                return response()->json(['error' => $error], 500);
            }
    
            // Close cURL session
            curl_close($curl);
    
            // Process the response data (if needed)
            $responseData = json_decode($response, true);
    
        }
        catch(\Exception $e){
            throw($e);
        }
        
        return $responseData;
        
        

        // SELECT TABLE_SCHEMA FROM `TABLES` WHERE TABLE_SCHEMA LIKE 'ds2024_prv%' AND length(TABLE_SCHEMA)=15 AND TABLE_ROWS > 0 AND TABLE_NAME LIKE 'new_released' GROUP BY TABLE_SCHEMA;

        $getTables = DB::connection('ds2021')->table('information_schema.TABLES')
        ->select('TABLE_SCHEMA','TABLE_NAME','TABLE_ROWS')
        ->where('TABLE_SCHEMA', 'LIKE', 'rcep_extension_db')
        ->where('TABLE_ROWS','>',0)
        ->where('TABLE_NAME', 'LIKE', 'prv_%')
        ->get();

        dd($getTables);

        $getData = DB::connection('ds2021')->table('rcep_extension_db.prv_0250')
        ->get();
        
        dd($getData);
    }
}
