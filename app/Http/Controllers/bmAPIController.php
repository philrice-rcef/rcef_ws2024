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
    public function countFarmers(Request $request){
        $getSeeds =  DB::table('ds2024_seed_seed.seed_characteristics_structured')
        ->get();

        foreach($getSeeds as $seed)
        {
            if($seed->maturity > 125)
            {
                DB::table('ds2024_seed_seed.seed_characteristics_structured')
                ->where('id',$seed->id)
                ->update([
                    'category' => 'Late'
                ]);
            }
            else if ($seed->maturity < 126 && $seed->maturity > 115)
            {
                DB::table('ds2024_seed_seed.seed_characteristics_structured')
                ->where('id',$seed->id)
                ->update([
                    'category' => 'Medium'
                ]);
            }
            else if ($seed->maturity < 115 && $seed->maturity > 100)
            {
                DB::table('ds2024_seed_seed.seed_characteristics_structured')
                ->where('id',$seed->id)
                ->update([
                    'category' => 'Early'
                ]);
            }
            else if ($seed->maturity < 101)
            {
                DB::table('ds2024_seed_seed.seed_characteristics_structured')
                ->where('id',$seed->id)
                ->update([
                    'category' => 'Very Early'
                ]);
            }
        }
        return ("Done");

        // $countRainfed = 0;
        // $countIrrigated = 0;
        // $countNone = 0;
        // $areaRainfed = 0;
        // $areaIrrigated = 0;
        // $areaNone = 0;

        // $prvs = ['0129','0133','0155','0215','0231','0250','0257','0308','0314','0349','0354','0369','0371','0377','0410','0421','0434','0456','0458','0505','0516','0517','0520','0541','0562','0604','0606','0619','0630','0645','0679','0712','0722','0746','0761','0826','0837','0848','0860','0864','0878','0972','0973','0983','1013','1018','1035','1042','1043','1123','1124','1125','1182','1186','1247','1263','1265','1280','1401','1411','1427','1432','1444','1481','1536','1538','1602','1603','1667','1668','1685','1740','1751','1752','1753','1759'];
        // foreach ($prvs as $prov){
            
        //     $getReleasedData = DB::table('ds2024_prv_'.$prov.'.new_released')
        //     ->where('category','INBRED')
        //     ->get();
    
        //     foreach($getReleasedData as $row)
        //     {
        //         $reg = substr($row->prv_dropoff_id,0,2);
        //         $prv = substr($row->prv_dropoff_id,2,2);
        //         $mun = substr($row->prv_dropoff_id,4,2);
        //         $claiming_prv = $reg.'-'.$prv.'-'.$mun;
    
        //         $getFFRSdata = DB::table('ffrs_june.prv_'.$prov)
        //         ->where('rsbsa_control_no',$row->content_rsbsa)
        //         ->where('claiming_prv',$claiming_prv)
        //         ->first();
                
        //         if($getFFRSdata){
        //             if($getFFRSdata->farm_type == 'Irrigated')
        //             {
        //                 $countRainfed++;
        //                 $areaRainfed += $row->claimed_area;
        //             }
        //             else if($getFFRSdata->farm_type == 'Rainfed Upland'||$getFFRSdata->farm_type == 'Rainfed Lowland')
        //             {
        //                 $countIrrigated++;
        //                 $areaIrrigated+= $row->claimed_area;
        //             }
        //             else
        //             {
        //                 $countNone++;
        //                 $areaNone+= $row->claimed_area;
        //             }
        //         }
    
        //     }
        // }
        // dd('countRainfed', $countRainfed,
        // 'countIrrigated', $countIrrigated,
        // 'countNone', $countNone,
        // 'areaRainfed', $areaRainfed,
        // 'areaIrrigated', $areaIrrigated,
        // 'areaNone', $areaNone);

        //DO NOT DELETE THIS
        // $test = 0.0052;
        // $testRound = number_format($test, 2);
        // dd($testRound);

        // $getSample = DB::table('ds2024_epaalalay.ds2024_0128')
        // ->first();

        // $getMonth = substr($getSample->sowing_date,0,2);
        // $getWeek = substr($getSample->sowing_date,3,2);
        // $currentDate = Carbon::now();

        // if($getWeek == '01')
        // {
        //     $week = '01';
        // }
        // else if($getWeek == '02')
        // {
        //     $week = '08';
        // }
        // else if($getWeek == '03')
        // {
        //     $week = '15';
        // }
        // else
        // {
        //     $week = '22';
        // }

        // $month = Carbon::create()->month($getMonth)->format('F');

        // $startDate = $month.' '.$week;
        // $date = Carbon::parse($startDate);
        // dd($date);

        // if ($date->lt($currentDate)) {
        //     $date->addYear();
        // }

        // $inputNumber = -30;

        // if ($inputNumber > 0) {
        //     $date->addDays($inputNumber); 
        // } elseif ($inputNumber < 0) {
        //     $date->subDays(abs($inputNumber));
        // }
  
        // $formattedDate = $date->format('Y-m-d');

        // $url = 'https://isd.philrice.gov.ph/ptc_v2/api/_api/send_message';
        //     $data = [
        //         'token' => 'cb74aa5ba38deaa9a2211f5d1394a9a7',
        //         'mobile' => '09912041666',
        //         'message' => "e-Paalala test message."
        //     ];
            
            
        //     $ch = curl_init($url);
    
    
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
        //     $response = curl_exec($ch);
            
        //     if ($response === false) {
        //         echo 'cURL error: ' . curl_error($ch);
        //     }
            
        //     curl_close($ch);


        // dd($formattedDate);
        
        
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
