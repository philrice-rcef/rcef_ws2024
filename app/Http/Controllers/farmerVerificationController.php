<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use Auth;
class farmerVerificationController extends Controller
{
    public function index(){
        $getPrvs = DB::table('information_schema.TABLES')
        ->select('TABLE_NAME')
        ->where('TABLE_SCHEMA','LIKE','mongodb_data%')
        ->where('TABLE_NAME','LIKE','prv_%')
        ->where('TABLE_NAME','NOT LIKE','%ai')
        ->where('TABLE_NAME','NOT LIKE','%merge')
        ->where('TABLE_ROWS','>',0)
        ->get();

        $prvCodes = [];
        foreach($getPrvs as $prv)
        {
            $code = str_replace('prv_','',$prv->TABLE_NAME);
            array_push($prvCodes,$code);
        }

        // $forValidation = DB::select(DB::raw("SELECT SUM(total) as total FROM (SELECT COUNT(*) as total FROM mongodb_data.prv_0128_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0129_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0133_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0155_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0215_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0231_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0250_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0257_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0308_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0314_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0349_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0354_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0369_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0371_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0377_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0410_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0421_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0434_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0456_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0458_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0505_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0516_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0517_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0520_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0541_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0562_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0604_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0606_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0619_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0630_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0645_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0679_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0712_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0722_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0746_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0761_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0826_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0837_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0848_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0860_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0864_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0878_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0972_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0973_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_0983_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1013_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1018_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1035_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1042_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1043_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1123_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1124_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1125_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1182_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1186_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1247_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1263_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1265_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1280_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1401_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1411_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1427_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1432_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1444_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1481_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1536_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1538_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1547_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1602_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1603_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1667_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1668_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1685_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1740_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1751_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1752_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1753_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL UNION ALL
        // SELECT COUNT(*) as total FROM mongodb_data.prv_1759_ai WHERE _stake LIKE 'PROC' AND ffrs_id IS NULL AND merged_id IS NULL) as myTable"));

        // $totalForValidation = number_format($forValidation[0]->total);
        $totalForValidation = number_format(0);

        $provinces = DB::table('ws2024_rcep_delivery_inspection.lib_prv')
        ->select('regionName','province')
        ->whereIn('prv_code',$prvCodes)
        ->groupBy('province')
        ->orderBy('region_sort')
        ->get();

    
        return view("farmerVerification.index",compact('provinces','totalForValidation'));
    }

    public function getMuni(Request $request)
    {
        $getMuni = DB::table('ws2024_rcep_delivery_inspection.lib_prv')
        ->select('municipality','prv',DB::raw("CONCAT(regCode,'-',provCode,'-',munCode) as geocode"))
        ->where('province',$request->prov)
        ->groupBy('municipality')
        ->get();

        return json_encode($getMuni);
    }

    public function getProfiles(Request $request)
    {
        $code = substr(str_replace('-','',$request->mun),0,4);
        $getClusterProfile = DB::table('mongodb_data.prv_'.$code.'_ai')
        ->limit(3)
        ->get();

        // dd($getClusterProfile);
        
        return $getClusterProfile;
    }

}
