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
    public function unlinkExcelExport(){

        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $files = ["ms_2024-03-01_2024-05-22.xlsx","ms_2024-03-01_2024-05-26.xlsx","ms_2024-03-01_2024-05-31.xlsx"];
        foreach($files as $file)
        {
            $filePath = $documentRoot . '/rcef_ws2024/public/reports/excel_export/'.$file;
            
            if (file_exists($filePath)) {
                unlink($filePath);
            } else {
                echo "File does not exist.";
            }
        }
    }
    

    public function testAPI(Request $request){

        $farmers = [];

        $fullName = '';
        $rsbsa_control_no = '';
        $sex = '';
        $birthdate = '';
        $location = 'CABUGAO, ILOCOS SUR, ILOCOS';
        $season = 'WS2021';
        $kpKits = 0;
        $calendars = 1;
        $testimonials = 1;
        $services = 0;
        $apps = 0;
        $yunpalayun = 1;
        $encodedBy = 'dp.grospe';
        $time_stamp = 0;
       
    
        foreach($farmers as $farmer)
        {   
            $randomNumber = rand(1, 59);
            $date = Carbon::now();
            $time_stamp = $date->format('D M d Y H:i:s');
            $time_stamp = $date->addSeconds($randomNumber)->format('D M d Y H:i:s');
            // dd($time_stamp);
            $time_stamp .= ' GMT+0800 (Philippine Standard Time)';
            $ws2024 = DB::table('ws2024_prv_0129.farmer_information_final')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
            // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first();
            ->where('rsbsa_control_no','LIKE',$farmer)->first();
            if(!$ws2024)
            {
                $ds2024 = DB::table('ds2024_prv_0129.farmer_information_final')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first();
                ->where('rsbsa_control_no','LIKE',$farmer)->first();
                if(!$ds2024)
                {
                    $ws2023 = DB::table('ws2023_prv_0129.farmer_information_final')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                    // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first();
                    ->where('rsbsa_control_no','LIKE',$farmer)->first();
                    if(!$ws2023)
                    {
                        $ds2023 = DB::table('ds2023_prv_0129.farmer_information_final')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                        // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first();
                        ->where('rsbsa_control_no','LIKE',$farmer)->first();
                        if(!$ds2023)
                        {
                            $ws2022 = DB::connection('ws2022')->table('prv_0129.farmer_profile')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                            // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first();
                            ->where('rsbsa_control_no','LIKE',$farmer)->first();
                            if(!$ws2022)
                            {
                                $ds2022 = DB::connection('ds2022')->table('prv_0129.farmer_profile')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                                // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first(); 
                                ->where('rsbsa_control_no','LIKE',$farmer)->first();
                                if(!$ds2022)
                                {
                                    $ws2021 = DB::connection('ws2021')->table('prv_0129.farmer_profile')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                                    // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first();
                                    ->where('rsbsa_control_no','LIKE',$farmer)->first();
                                    if(!$ws2021)  
                                    {
                                        $ds2021 = DB::connection('ds2021')->table('prv_0129.farmer_profile')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                                        // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first(); 
                                        ->where('rsbsa_control_no','LIKE',$farmer)->first();
                                        if(!$ds2021)
                                        {
                                            $ws2020 = DB::connection('ws2020')->table('prv_0129.farmer_profile')->select('lastName','firstName','midName','extName','rsbsa_control_no','sex','birthdate')
                                            // ->where(DB::raw("CONCAT(lastName, ', ', firstName, ' ', midName, ' ', extName)"), 'LIKE', '%' . $farmer . '%')->first(); 
                                            ->where('rsbsa_control_no','LIKE',$farmer)->first();
                                            if(!$ws2020){
                                                $fullName = '';
                                                $rsbsa_control_no = '';
                                                $sex = '';
                                                $birthdate = '';
                                            }else
                                            {
                                                $fullName = $ws2020->lastName.', '.$ws2020->firstName.' '.$ws2020->midName.' '.$ws2020->extName;
                                                $rsbsa_control_no = $ws2020->rsbsa_control_no;
                                                $sex = $ws2020->sex;
                                                $birthdate = $ws2020->birthdate;
                                            }
                                        }else
                                        {
                                            $fullName = $ds2021->lastName.', '.$ds2021->firstName.' '.$ds2021->midName.' '.$ds2021->extName;
                                            $rsbsa_control_no = $ds2021->rsbsa_control_no;
                                            $sex = $ds2021->sex;
                                            $birthdate = $ds2021->birthdate;
                                        }
                                        
                                    }else
                                    {
                                        $fullName = $ws2021->lastName.', '.$ws2021->firstName.' '.$ws2021->midName.' '.$ws2021->extName;
                                        $rsbsa_control_no = $ws2021->rsbsa_control_no;
                                        $sex = $ws2021->sex;
                                        $birthdate = $ws2021->birthdate;
                                    }
                                    
                                }else
                                {
                                    $fullName = $ds2022->lastName.', '.$ds2022->firstName.' '.$ds2022->midName.' '.$ds2022->extName;
                                    $rsbsa_control_no = $ds2022->rsbsa_control_no;
                                    $sex = $ds2022->sex;
                                    $birthdate = $ds2022->birthdate;
                                }
                                
                            }else
                            {
                                $fullName = $ws2022->lastName.', '.$ws2022->firstName.' '.$ws2022->midName.' '.$ws2022->extName;
                                $rsbsa_control_no = $ws2022->rsbsa_control_no;
                                $sex = $ws2022->sex;
                                $birthdate = $ws2022->birthdate;
                            }
                            
                        }else
                        {
                            $fullName = $ds2023->lastName.', '.$ds2023->firstName.' '.$ds2023->midName.' '.$ds2023->extName;
                            $rsbsa_control_no = $ds2023->rsbsa_control_no;
                            $sex = $ds2023->sex;
                            $birthdate = $ds2023->birthdate;
                        }
                        
                    }else
                    {
                        $fullName = $ws2023->lastName.', '.$ws2023->firstName.' '.$ws2023->midName.' '.$ws2023->extName;
                        $rsbsa_control_no = $ws2023->rsbsa_control_no;
                        $sex = $ws2023->sex;
                        $birthdate = $ws2023->birthdate;
                    }
                    
                }else
                {
                    $fullName = $ds2024->lastName.', '.$ds2024->firstName.' '.$ds2024->midName.' '.$ds2024->extName;
                    $rsbsa_control_no = $ds2024->rsbsa_control_no;
                    $sex = $ds2024->sex;
                    $birthdate = $ds2024->birthdate;
                }
                
            }
            else
            {
                $fullName = $ws2024->lastName.', '.$ws2024->firstName.' '.$ws2024->midName.' '.$ws2024->extName;
                $rsbsa_control_no = $ws2024->rsbsa_control_no;
                $sex = $ws2024->sex;
                $birthdate = $ws2024->birthdate;
            }

            if($fullName == '' || $rsbsa_control_no == "" || !$fullName || !$rsbsa_control_no)
            {
                continue;
            }
            else
            {
                DB::table('kp_distribution.kp_distribution_app')
                ->insert([
                    "fullName" => $fullName,
                    "rsbsa_control_no" => $rsbsa_control_no,
                    "sex" => $sex,
                    "birthdate" => $birthdate,
                    "location" => $location,
                    "season" => $season,
                    "kpKits" => $kpKits,
                    "calendars" => $calendars,
                    "testimonials" => $testimonials,
                    "services" => $services,
                    "apps" => $apps,
                    "yunpalayun" => $yunpalayun,
                    "encodedBy" => $encodedBy,
                    "time_stamp" => $time_stamp
                ]);
            }
        }
        return('Done');
    
    }
    
    public function seedAnalysisAPI(Request $request){
        $season = 'ds2024';
        $season2 = 'ws2024';
        $season3 = 'ws2023';
        // $season3 = 'ds2023'; //previous
        // $season = 'ws2023'; //current
        // $season2 = 'ds2024'; //next

        $getDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_delivery')
        ->select( 'coopAccreditation','batchTicketNumber','seedVariety','province')
        ->where('isBuffer', 0) //new and inventory
        // ->where('isBuffer', 1) //buffer
        ->groupBy('coopAccreditation', 'province', 'batchTicketNumber', 'seedVariety')
        // ->limit(10)
        ->get();

        $getBuffer = DB::table($season3.'_rcep_delivery_inspection.tbl_delivery as a')
        ->select('b.coopName','a.coopAccreditation','a.province','a.seedVariety', DB::raw("SUM(totalBagCount) as total_bags"))
        ->leftJoin($season.'_rcep_seed_cooperatives.tbl_cooperatives as b', 'a.coopAccreditation','=','b.accreditation_no')
        ->where('a.isBuffer', 1) 
        ->groupBy('a.coopAccreditation', 'a.province', 'a.seedVariety')
        ->get();
        // dd($getBuffer);

        // $getDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_delivery as a')
        // ->select( 'a.coopAccreditation','a.batchTicketNumber','b.seedVariety','b.province', DB::raw("SUM(b.totalBagCount) as total_bags"))
        // ->leftJoin($season.'_rcep_delivery_inspection.tbl_actual_delivery as b','a.batchTicketNumber','=','b.batchTicketNumber')
        // ->where('a.isBuffer', 0) //new and inventory
        // // ->where('isBuffer', 1) //buffer
        // ->groupBy('a.coopAccreditation', 'a.province', 'a.batchTicketNumber', 'a.seedVariety')
        // ->limit(10)
        // ->get();

        // dd($getDelivery);

        $finalNew = [];
        $finalInventory = [];
        $temp = [];
        // dd($getDelivery[0]);
        // $inventorySeeds = [];

        foreach($getDelivery as $delivery)
        {
            $getCoopName = DB::table($season.'_rcep_seed_cooperatives.tbl_cooperatives')
            ->select('coopName', 'accreditation_no')
            ->where('accreditation_no','LIKE',$delivery->coopAccreditation)
            ->first();
            
            $coop = $getCoopName->coopName;

            $getActualDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_actual_delivery')
            ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
            ->where('batchTicketNumber', 'LIKE',$delivery->batchTicketNumber)
            ->where('province', 'LIKE',$delivery->province)
            ->where('seedVariety', 'LIKE',$delivery->seedVariety)
            ->groupBy('province','seedVariety')
            ->get();
            if($getActualDelivery)
            {
                // dd($getActualDelivery);
                foreach($getActualDelivery as $actual)
                {
                    array_push($finalNew,(
                        [
                            "coopName" => $coop,
                            "coopAccreditation" => $delivery->coopAccreditation,
                            "province" => $actual->province,
                            "seedVariety" => $actual->seedVariety,
                            "total_bags" => $actual->total_bags,
                            // "type" => 'New'
                        ]
                        ));
                }
            }

            // dd($finalNew);

            $batchVar = $delivery->batchTicketNumber;
            $batchVar2 = $delivery->batchTicketNumber;

            $getCoopAccred = DB::table($season.'_rcep_delivery_inspection.tbl_delivery')
                ->select('coopAccreditation')
                ->where('batchTicketNumber',$batchVar)
                ->first();

                // dd($getCoopAccred);
            do{
                $getCStoCS = DB::table($season.'_rcep_delivery_inspection.tbl_actual_delivery')
                ->select('batchTicketNumber','province','seedVariety','remarks',DB::raw('SUM(totalBagCount) as total_bags'))
                ->where('remarks', 'LIKE','%'.$batchVar.'%')
                ->groupBy('batchTicketNumber','province','seedVariety')
                ->get();
                if($getCStoCS){
                    // dd($getCStoCS);
                    foreach($getCStoCS as $CStoCS){

                        array_push($finalNew,(
                            [
                                "coopName" => $coop,
                                "coopAccreditation" => $delivery->coopAccreditation,
                                "province" => $CStoCS->province,
                                "seedVariety" => $CStoCS->seedVariety,
                                "total_bags" => $CStoCS->total_bags,
                                // "type" => 'CS to CS'
                            ]
                            ));
                            $batchVar = $CStoCS->batchTicketNumber;
                    }
                }

            
            }while($getCStoCS);


            do{
                $getCStoNS = DB::table($season2.'_rcep_delivery_inspection.tbl_actual_delivery')
                ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
                ->where('remarks', 'LIKE','%'.$batchVar2.'%')
                ->groupBy('batchTicketNumber','province','seedVariety')
                ->get();
                if($getCStoNS){
                    // dd($getCStoCS);
                    foreach($getCStoNS as $CStoNS){
                        array_push($finalInventory,(
                            [
                                "coopName" => $coop,
                                "coopAccreditation" => $delivery->coopAccreditation,
                                "province" => $CStoNS->province,
                                "seedVariety" => $CStoNS->seedVariety,
                                "total_bags" => $CStoNS->total_bags,
                                // "type" => 'CS to CS'
                            ]
                            ));
                            $batchVar2 = $CStoNS->batchTicketNumber;
                    }
                }
                
            }while($getCStoNS);
        }

            $finalNewArray = [];
            foreach ($finalNew as $new) {
                $key = $new['coopAccreditation'] . '_' . $new['province'] . '_' . $new['seedVariety'];
                if (!isset($finalNewArray[$key])) {
                    $finalNewArray[$key] = [
                        'coopName' => $new['coopName'],
                        'coopAccreditation' => $new['coopAccreditation'],
                        'province' => $new['province'],
                        'seedVariety' => $new['seedVariety'],
                        'total_bags' => (int)$new['total_bags'] 
                    ];
                } else {
                    
                    $finalNewArray[$key]['total_bags'] += (int)$new['total_bags'];
                }
            }

            $finalNewArray = array_values($finalNewArray);

            $finalInventoryArray = [];
            foreach ($finalInventory as $inventory) {
                $key = $inventory['coopAccreditation'] . '_' . $inventory['province'] . '_' . $inventory['seedVariety'];
                if (!isset($finalInventoryArray[$key])) {
                    $finalInventoryArray[$key] = [
                        'coopName' => $inventory['coopName'],
                        'coopAccreditation' => $inventory['coopAccreditation'],
                        'province' => $inventory['province'],
                        'seedVariety' => $inventory['seedVariety'],
                        'total_bags' => (int)$inventory['total_bags'] 
                    ];
                } else {
                    
                    $finalInventoryArray[$key]['total_bags'] += (int)$inventory['total_bags'];
                }
            }

            $finalInventoryArray = array_values($finalInventoryArray);

        // dd($finalNewArray);
        $finalNew = collect($finalNewArray);
        $finalInventory = collect($finalInventoryArray);
        $finalBuffer = collect($getBuffer);

        $excel_data = json_decode(json_encode($finalNew), true);
        $excel_data2 = json_decode(json_encode($finalInventory), true);
        $excel_data3 = json_decode(json_encode($finalBuffer), true);
        // dd($excel_data);
        $filename = 'Local Seeds Analysis '.$season;
        return Excel::create($filename, function($excel) use ($excel_data,$excel_data2,$excel_data3) {
            $excel->sheet("New Seeds", function($sheet) use ($excel_data) {
                $sheet->fromArray($excel_data);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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

            $excel->sheet("Inventory Seeds", function($sheet) use ($excel_data2) {
                $sheet->fromArray($excel_data2);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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

            $excel->sheet("Buffer Seeds", function($sheet) use ($excel_data3) {
                $sheet->fromArray($excel_data3);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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

    public function seedAnalysisAPI_old_seasons(Request $request){
        // $season = 'ds2024';
        // $season2 = 'ws2024';
        // $season3 = 'ws2023';
        $season3 = 'ds2020'; //previous
        $season = 'ws2020'; //current
        $season2 = 'ds2021'; //next

        $getDelivery = DB::connection($season)->table('rcep_delivery_inspection.tbl_delivery')
        ->select( 'coopAccreditation','batchTicketNumber','seedVariety','province')
        ->where('dropOffPoint', 'NOT LIKE', '%buffer%') //new and inventory
        // ->where('isBuffer', 1) //buffer
        ->groupBy('coopAccreditation', 'province', 'batchTicketNumber', 'seedVariety')
        // ->limit(10)
        ->get();

        // dd($getDelivery);
        // $getBuffer = DB::table($season3.'_rcep_delivery_inspection.tbl_delivery as a')
        // $getBuffer = DB::connection($season3)->table('rcep_delivery_inspection.tbl_delivery as a')
        // ->select('b.coopName','a.coopAccreditation','a.province','a.seedVariety', DB::raw("SUM(totalBagCount) as total_bags"))
        // ->leftJoin('rcep_seed_cooperatives.tbl_cooperatives as b', 'a.coopAccreditation','=','b.accreditation_no')
        // ->where('a.dropOffPoint', 'LIKE', '%buffer%') 
        // ->groupBy('a.coopAccreditation', 'a.province', 'a.seedVariety')
        // ->get();
        // dd($getBuffer);

        // $getDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_delivery as a')
        // ->select( 'a.coopAccreditation','a.batchTicketNumber','b.seedVariety','b.province', DB::raw("SUM(b.totalBagCount) as total_bags"))
        // ->leftJoin($season.'_rcep_delivery_inspection.tbl_actual_delivery as b','a.batchTicketNumber','=','b.batchTicketNumber')
        // ->where('a.isBuffer', 0) //new and inventory
        // // ->where('isBuffer', 1) //buffer
        // ->groupBy('a.coopAccreditation', 'a.province', 'a.batchTicketNumber', 'a.seedVariety')
        // ->limit(10)
        // ->get();

        // dd($getDelivery);

        $finalNew = [];
        $finalInventory = [];
        $temp = [];
        // dd($getDelivery[0]);
        // $inventorySeeds = [];

        foreach($getDelivery as $delivery)
        {
            // dd($delivery);
            $getCoopName = DB::connection($season)->table('rcep_seed_cooperatives.tbl_cooperatives')
            ->select('coopName', 'accreditation_no')
            ->where('accreditation_no','LIKE',$delivery->coopAccreditation)
            ->first();
            
            if($getCoopName)
            {
                $coop = $getCoopName->coopName;
            }
            else{
                $coop = '';
            }

            $getActualDelivery = DB::connection($season)->table('rcep_delivery_inspection.tbl_actual_delivery')
            ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
            ->where('batchTicketNumber', 'LIKE',$delivery->batchTicketNumber)
            ->where('province', 'LIKE',$delivery->province)
            ->where('seedVariety', 'LIKE',$delivery->seedVariety)
            ->groupBy('province','seedVariety')
            ->get();

            // dd($getActualDelivery);
            if($getActualDelivery)
            {
                // dd($getActualDelivery);
                foreach($getActualDelivery as $actual)
                {
                    array_push($finalNew,(
                        [
                            "coopName" => $coop,
                            "coopAccreditation" => $delivery->coopAccreditation,
                            "province" => $actual->province,
                            "seedVariety" => $actual->seedVariety,
                            "total_bags" => $actual->total_bags,
                            // "type" => 'New'
                        ]
                        ));
                }
            }

            // dd($finalNew);

            $batchVar = $delivery->batchTicketNumber;
            $batchVar2 = $delivery->batchTicketNumber;

            $getCoopAccred = DB::connection($season)->table('rcep_delivery_inspection.tbl_delivery')
                ->select('coopAccreditation')
                ->where('batchTicketNumber',$batchVar)
                ->first();

                // dd($getCoopAccred);
            do{
                $getCStoCS = DB::connection($season)->table('rcep_delivery_inspection.tbl_actual_delivery')
                ->select('batchTicketNumber','province','seedVariety','remarks',DB::raw('SUM(totalBagCount) as total_bags'))
                ->where('remarks', 'LIKE','%'.$batchVar.'%')
                ->groupBy('batchTicketNumber','province','seedVariety')
                ->get();
                if($getCStoCS){
                    // dd($getCStoCS);
                    foreach($getCStoCS as $CStoCS){

                        array_push($finalNew,(
                            [
                                "coopName" => $coop,
                                "coopAccreditation" => $delivery->coopAccreditation,
                                "province" => $CStoCS->province,
                                "seedVariety" => $CStoCS->seedVariety,
                                "total_bags" => $CStoCS->total_bags,
                                // "type" => 'CS to CS'
                            ]
                            ));
                            $batchVar = $CStoCS->batchTicketNumber;
                    }
                }

            
            }while($getCStoCS);


            do{
                $getCStoNS = DB::connection($season2)->table('rcep_delivery_inspection.tbl_actual_delivery')
                // $getCStoNS = DB::table($season2.'_rcep_delivery_inspection.tbl_actual_delivery')
                ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
                ->where('remarks', 'LIKE','%'.$batchVar2.'%')
                ->groupBy('batchTicketNumber','province','seedVariety')
                ->get();
                if($getCStoNS){
                    // dd($getCStoCS);
                    foreach($getCStoNS as $CStoNS){
                        array_push($finalInventory,(
                            [
                                "coopName" => $coop,
                                "coopAccreditation" => $delivery->coopAccreditation,
                                "province" => $CStoNS->province,
                                "seedVariety" => $CStoNS->seedVariety,
                                "total_bags" => $CStoNS->total_bags,
                                // "type" => 'CS to CS'
                            ]
                            ));
                            $batchVar2 = $CStoNS->batchTicketNumber;
                    }
                }
                
            }while($getCStoNS);
        }

            $finalNewArray = [];
            foreach ($finalNew as $new) {
                $key = $new['coopAccreditation'] . '_' . $new['province'] . '_' . $new['seedVariety'];
                if (!isset($finalNewArray[$key])) {
                    $finalNewArray[$key] = [
                        'coopName' => $new['coopName'],
                        'coopAccreditation' => $new['coopAccreditation'],
                        'province' => $new['province'],
                        'seedVariety' => $new['seedVariety'],
                        'total_bags' => (int)$new['total_bags'] 
                    ];
                } else {
                    
                    $finalNewArray[$key]['total_bags'] += (int)$new['total_bags'];
                }
            }

            $finalNewArray = array_values($finalNewArray);

            $finalInventoryArray = [];
            foreach ($finalInventory as $inventory) {
                $key = $inventory['coopAccreditation'] . '_' . $inventory['province'] . '_' . $inventory['seedVariety'];
                if (!isset($finalInventoryArray[$key])) {
                    $finalInventoryArray[$key] = [
                        'coopName' => $inventory['coopName'],
                        'coopAccreditation' => $inventory['coopAccreditation'],
                        'province' => $inventory['province'],
                        'seedVariety' => $inventory['seedVariety'],
                        'total_bags' => (int)$inventory['total_bags'] 
                    ];
                } else {
                    
                    $finalInventoryArray[$key]['total_bags'] += (int)$inventory['total_bags'];
                }
            }

            $finalInventoryArray = array_values($finalInventoryArray);

        // dd($finalNewArray);
        $finalNew = collect($finalNewArray);
        $finalInventory = collect($finalInventoryArray);
        // $finalBuffer = collect($getBuffer);

        $excel_data = json_decode(json_encode($finalNew), true);
        $excel_data2 = json_decode(json_encode($finalInventory), true);
        // $excel_data3 = json_decode(json_encode($finalBuffer), true);
        // dd($excel_data);
        $filename = 'Local Seeds Analysis '.$season;
        return Excel::create($filename, function($excel) use ($excel_data,$excel_data2) {
        // return Excel::create($filename, function($excel) use ($excel_data,$excel_data2,$excel_data3) {
            $excel->sheet("New Seeds", function($sheet) use ($excel_data) {
                $sheet->fromArray($excel_data);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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

            $excel->sheet("Inventory Seeds", function($sheet) use ($excel_data2) {
                $sheet->fromArray($excel_data2);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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

            // $excel->sheet("Buffer Seeds", function($sheet) use ($excel_data3) {
            //     $sheet->fromArray($excel_data3);
            //     $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
            //     $border_style = array(
            //         'borders' => array(
            //             'allborders' => array(
            //                 'style' => \PHPExcel_Style_Border::BORDER_THIN,
            //                 'color' => array('argb' => '000000'),
            //             ),
            //         ),
            //     );
            //     $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($border_style);
            // });
        })->setActiveSheetIndex(0)->download('xlsx');
    }

    public function seedAnalysisAPI2(Request $request){
        $season = 'ds2024';
        $season2 = 'ws2024';
        $getDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_delivery')
        ->select( 'coopAccreditation','batchTicketNumber','seedVariety','province')
        ->where('isBuffer', 0) //new and inventory
        // ->where('isBuffer', 1) //buffer
        ->groupBy('coopAccreditation', 'province', 'batchTicketNumber', 'seedVariety')
        ->get();

        $finalNew = [];
        $finalInventory = [];
        $temp = [];
        // dd($getDelivery[0]);
        // $inventorySeeds = [];

        foreach($getDelivery as $delivery)
        {
            $coop = $delivery->coopAccreditation;
            $prv = $delivery->province;
            $variety = $delivery->seedVariety;
            
            $getActualDelivery = DB::table($season.'_rcep_delivery_inspection.tbl_actual_delivery')
            ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
            ->where('batchTicketNumber', 'LIKE',$delivery->batchTicketNumber)
            // ->where('province', 'LIKE',$delivery->province)
            // ->where('seedVariety', 'LIKE',$delivery->seedVariety)
            ->groupBy('province','seedVariety')
            ->get();
            
            // dd($getActualDelivery);
            if(!$getActualDelivery)
            {
                // dd($delivery);
                // continue;
            }else{
                foreach($getActualDelivery as $actual){
                    array_push($temp,$actual);
                    $coop = $delivery->coopAccreditation;
                    $prv = $actual->province;
                    $variety = $actual->seedVariety;
                
                    if(isset($newSeeds[$coop][$prv][$variety]['N']))
                    {
                        $newSeeds[$coop][$prv][$variety]["N"] += $actual->total_bags;
                    }
                    else
                    {
                        $newSeeds[$coop][$prv][$variety]['N'] = $actual->total_bags;
                    }
                }
            }
            
            $batchVar = $delivery->batchTicketNumber;
            $batchVar2 = $delivery->batchTicketNumber;

            $getCoopAccred = DB::table($season.'_rcep_delivery_inspection.tbl_delivery')
                ->select('coopAccreditation')
                ->where('batchTicketNumber',$batchVar)
                ->first();
            do{
                $getCStoCS = DB::table($season.'_rcep_delivery_inspection.tbl_actual_delivery')
                ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
                ->where('remarks', 'LIKE','%'.$batchVar.'%')
                ->groupBy('batchTicketNumber','province','seedVariety')
                ->get();

                
                
                foreach($getCStoCS as $CStoCS){
                    $coop = $getCoopAccred->coopAccreditation;
                    $prv = $CStoCS->province;
                    $variety = $CStoCS->seedVariety;
                    if(isset($newSeeds[$coop][$prv][$variety]['N']))
                    {
                        $newSeeds[$coop][$prv][$variety]["N"] += $CStoCS->total_bags;
                    }
                    else
                    {
                        $newSeeds[$coop][$prv][$variety]['N'] = $CStoCS->total_bags;
                    }
                    $batchVar = $CStoCS->batchTicketNumber;
                }
            
            }while($getCStoCS);

            do{
                $getCStoNS = DB::table($season2.'_rcep_delivery_inspection.tbl_actual_delivery')
                ->select('batchTicketNumber','province','seedVariety',DB::raw('SUM(totalBagCount) as total_bags'))
                ->where('remarks', 'LIKE','%'.$batchVar.'%')
                ->groupBy('batchTicketNumber','province','seedVariety')
                ->get();
                foreach($getCStoNS as $CStoNS){
                    $coop = $delivery->coopAccreditation;
                    $prv = $CStoNS->province;
                    $variety = $CStoNS->seedVariety;
                    if(isset($inventorySeeds[$coop][$prv][$variety]['I']))
                    {
                        $inventorySeeds[$coop][$prv][$variety]["I"] += $CStoNS->total_bags;
                    }
                    else
                    {
                        $inventorySeeds[$coop][$prv][$variety]['I'] = $CStoNS->total_bags;
                    }
                    $batchVar = $CStoNS->batchTicketNumber;
                }
                
            }while($getCStoNS);
        }
        
        $coops1 = array_keys($newSeeds);
        foreach($coops1 as $coop1)
        {
            $cop1 = $coop1;
            $prv1 = key($newSeeds[$coop1]);
            $vars1 = array_keys($newSeeds[$coop1][$prv1]);
            foreach($vars1 as $v1){
                $typ1 = key($newSeeds[$coop1][$prv1][$v1]);
                $bag1 = $newSeeds[$coop1][$prv1][$v1][$typ1];

                array_push($finalNew, array(
                    "Coop Accreditation" => $cop1,
                    "Province" => $prv1,
                    "Seed Variety" => $v1,
                    "Type" => $typ1,
                    "Total Bags" => (int)$bag1,
                ));
            }
        }

        $coops = array_keys($inventorySeeds);
        foreach($coops as $coop)
        {
            $cop = $coop;
            $prv = key($inventorySeeds[$coop]);
            // dd(array_keys($inventorySeeds[$coop][$prv]));
            $vars = array_keys($inventorySeeds[$coop][$prv]);
            foreach($vars as $v){
                $typ = key($inventorySeeds[$coop][$prv][$v]);
                $bag = $inventorySeeds[$coop][$prv][$v][$typ];

                array_push($finalInventory, array(
                    "Coop Accreditation" => $cop,
                    "Province" => $prv,
                    "Seed Variety" => $v,
                    "Type" => $typ,
                    "Total Bags" => (int)$bag,
                ));
            }
        }
        // dd($finalInventory);

        
        $finalNew = collect($finalNew);
        $finalInventory = collect($finalInventory);

        $excel_data = json_decode(json_encode($finalNew), true);
        $excel_data2 = json_decode(json_encode($finalInventory), true);
        // dd($excel_data);
        $filename = 'Local Seeds Analysis';
        return Excel::create($filename, function($excel) use ($excel_data,$excel_data2) {
            $excel->sheet("New Seeds", function($sheet) use ($excel_data) {
                $sheet->fromArray($excel_data);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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

            $excel->sheet("Inventory Seeds", function($sheet) use ($excel_data2) {
                $sheet->fromArray($excel_data2);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00B53F');
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
