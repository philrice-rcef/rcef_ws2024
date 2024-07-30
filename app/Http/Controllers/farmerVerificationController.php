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
        $totalForValidation = 0;
        $totalValidated = 0;
        $totalPending = 0;
        foreach($getPrvs as $prv)
        {
            $code = str_replace('prv_','',$prv->TABLE_NAME);
            // $countMerged = count(DB::table('mongodb_data.prv_'.$code.'_merge')
            // ->get());
            // $totalValidated = $totalValidated + $countMerged;
            
            $checkTbl = DB::table('mongodb_data.prv_'.$code.'_ai')
            ->where('status','FOR VERIFICATION')
            ->first();
            if($checkTbl)
            {
                array_push($prvCodes,$code);
            }
            else
            {
                continue;
            }
        }

        foreach($prvCodes as $prov)
        {
            // $countForVerify = count(DB::table('mongodb_data.prv_'.$prov.'_ai')
            // ->where('status','FOR VERIFICATION')
            // ->get());
            // $totalForValidation = $totalForValidation + $countForVerify;
            
            // $countPending = count(DB::table('mongodb_data.prv_'.$prov.'_ai')
            // ->where('status','NOT LIKE','FOR VERIFICATION')
            // ->where('status','NOT LIKE','MERGED')
            // ->get());
            // $totalPending = $totalPending + $countPending;
        }

        // dd($totalForValidation, $totalValidated);

        $provinces = DB::table('ws2024_rcep_delivery_inspection.lib_prv')
        ->select('regionName','province')
        ->whereIn('prv_code',$prvCodes)
        ->groupBy('province')
        ->orderBy('region_sort')
        ->get();


        $totalForValidation = number_format($totalForValidation);
        $totalValidated = number_format($totalValidated);
        $totalPending = number_format($totalPending);

        return view("farmerVerification.index",compact('provinces','totalForValidation','totalValidated','totalPending'));
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
        $returnArray = [];
        $totalForValidation = 0;
        $totalValidated = 0;
        $totalPending = 0;

        $code = substr(str_replace('-','',$request->mun),0,4);
        // dd($code);

        $countMerged = count(DB::table('mongodb_data.prv_'.$code.'_merge')
        ->where('home_geocode','LIKE',$request->mun.'%')
        ->get());
        $totalValidated = $totalValidated + $countMerged;

        $countForVerify = count(DB::table('mongodb_data.prv_'.$code.'_ai')
        ->where('status','FOR VERIFICATION')
        ->where('home_geocode','LIKE',$request->mun.'%')
        ->get());
        $totalForValidation = $totalForValidation + $countForVerify;
        
        $countPending = count(DB::table('mongodb_data.prv_'.$code.'_ai')
        ->where('status','NOT LIKE','FOR VERIFICATION')
        ->where('status','NOT LIKE','MERGED')
        ->where('home_geocode','LIKE',$request->mun.'%')
        ->get());
        $totalPending = $totalPending + $countPending;

        $getCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
        ->where('status','FOR VERIFICATION')
        ->where('home_geocode','LIKE',$request->mun.'%')
        ->where('cluster_id',1834) //for testing purposes -  Pangasinan - Mangatarem
        ->first();
        // dd($getCluster,$request->all());

        if(!$getCluster)
        {
            return ('No data.');
        }

        $getClusterProfile = DB::table('mongodb_data.prv_'.$code.'_ai')
        ->where('status','FOR VERIFICATION')
        ->where('cluster_id',$getCluster->cluster_id)
        ->get();

        $totalForValidation = number_format($totalForValidation);
        $totalValidated = number_format($totalValidated);
        $totalPending = number_format($totalPending);
        

        array_push($returnArray,$getClusterProfile);
        array_push($returnArray,$totalForValidation);
        array_push($returnArray,$totalValidated);
        array_push($returnArray,$totalPending);

        // dd($returnArray);
        return $returnArray;
    }

    public function getSuggestions(Request $request)
    {
        // dd($request->all());
        $code = substr(str_replace('-','',$request->mun),0,4);
        $getSuggestedProfile = DB::table('mongodb_data.prv_'.$code.'_ai')
        ->where('status','MERGED')
        ->where('cluster_id',$request->cluster)
        ->get();

        if(!$getSuggestedProfile)
        {
            $updateNoSuggested = DB::table('mongodb_data.prv_'.$code.'_ai')
            ->where('status','FOR VERIFICATION')
            ->where('cluster_id',$request->cluster)
            ->update([
                "status" => "FOR APPROVAL"
            ]);
            return "No suggested data.";
        }
        else
        {
            return $getSuggestedProfile;
        }
        
    }

    public function updateProfiles(Request $request)
    {
        // dd($request->all());
        $code = substr(str_replace('-','',$request->mun),0,4);
        $getSub = [];
        $getNew = [];

        if($request->profileCount == 1)
        {
            $profileId = $request->tempProfile;
            $selectedId = $request->main_profile;

            if($profileId == $selectedId)
            {
                $getMaxNewCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->max('new_cluster_id');

                if(!$getMaxNewCluster)
                {
                    $getMaxCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
                    ->max('cluster_id');
                    $newCluster = $getMaxCluster + 1;
                }
                else
                {
                    $newCluster = $getMaxNewCluster + 1;
                }
                $updateProfile = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->where('id',$profileId)
                ->update([
                    "new_cluster_id" => $newCluster,
                    "status" => "FOR APPROVAL"
                ]);
            }
            else
            {
                $getMaxNewCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->max('new_cluster_id');

                if(!$getMaxNewCluster)
                {
                    $getMaxCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
                    ->max('cluster_id');
                    $newCluster = $getMaxCluster + 1;
                }
                else
                {
                    $newCluster = $getMaxNewCluster + 1;
                }
                $updateProfile = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->where('id',$profileId)
                ->update([
                    "profile_link_id" => $selectedId,
                    "status" => "FOR APPROVAL"
                ]);
            }
        }
        else
        {
            $getMain = DB::table('mongodb_data.prv_'.$code.'_ai')
            ->where('id',$request->main_profile)
            ->update([
                "main_profile" => 1,
                "status" => "FOR APPROVAL"
            ]);

            if($request->sub_profiles)
            {
                $getSub = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->whereIn('id',$request->sub_profiles)
                ->update([
                    "profile_link_id" => $request->main_profile,
                    "status" => "FOR APPROVAL"
                ]);
            }
            if($request->new_profiles)
            {
                
                $getMaxNewCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->max('new_cluster_id');

                if(!$getMaxNewCluster)
                {
                    $getMaxCluster = DB::table('mongodb_data.prv_'.$code.'_ai')
                    ->max('cluster_id');
                    $newCluster = $getMaxCluster + 1;
                }
                else
                {
                    $newCluster = $getMaxNewCluster + 1;
                }

                $newProfiles = $request->new_profiles;
                $getNew = DB::table('mongodb_data.prv_'.$code.'_ai')
                ->whereIn('id',$request->new_profiles)
                ->update([
                    "new_cluster_id" => $newCluster
                ]);

            }
        }
        return 1;
    }

}
