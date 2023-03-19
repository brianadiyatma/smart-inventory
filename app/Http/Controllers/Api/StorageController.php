<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sap_m_storage_bin;
use DB;
use Cache;
use Log;

class StorageController extends Controller
{
    public function locationMenu(Request $request){       
        $storage = sap_m_storage_bin::leftJoin('t_stocks','sap_m_storage_bins.storage_bin_code','=','t_stocks.bin_code')
        ->leftJoin('sap_m_materials','sap_m_materials.material_code','=','t_stocks.material_code')
        ->leftJoin('sap_m_storage_locations','sap_m_storage_locations.storage_location_code','=','sap_m_storage_bins.storage_loc_code')
        ->leftJoin('sap_m_storage_types','sap_m_storage_types.storage_type_code','=','sap_m_storage_bins.storage_type_code')
        ->select(['sap_m_storage_bins.*','sap_m_storage_locations.storage_location_name','sap_m_storage_types.storage_type_name',
        DB::RAW('count( DISTINCT `t_stocks`.special_stock_number) as total_project'),
        DB::RAW('count( DISTINCT `t_stocks`.material_code) as total_material'),
        DB::RAW('count( DISTINCT `sap_m_materials`.material_type_id) as total_material_type'),
        DB::RAW('(SELECT SUM(`t_stocks`.qty) FROM `t_stocks` WHERE `t_stocks`.bin_code = `sap_m_storage_bins`.storage_bin_code
        AND `t_stocks`.special_stock_number IS NOT NULL) as total_material_project'),
        // DB::RAW('(SELECT SUM(`t_stocks`.qty) FROM `t_stocks` WHERE `t_stocks`.bin_code = `sap_m_storage_bins`.storage_bin_code
        // ) as total_material'),
    ]);
        if($request->has('query')){
            $storage = $storage->where('sap_m_storage_bins.storage_bin_code', 'LIKE', '%'.$request['query'].'%');
        }
        // Log::info("Location paramater:".$request['query']);    
        $storage = $storage->orderBy('t_stocks.qty','desc')
        ->groupBy('sap_m_storage_bins.storage_bin_code')->paginate(15);

        // $result = Cache::remember('storage_'.$request->input('page',1), 120, function () use ($storage) {
        //     return $storage;
        // });
        return response()->json([
            'status'=>'success',
            'data'=> $storage
        ]);
    }
    
    public function locationDetails(Request $request){
        $storage = sap_m_storage_bin::leftJoin('t_stocks','sap_m_storage_bins.storage_bin_code','=','t_stocks.bin_code')
        ->leftJoin('sap_m_materials','sap_m_materials.material_code','=','t_stocks.material_code')
        ->leftJoin('sap_m_storage_locations','sap_m_storage_locations.storage_location_code','=','sap_m_storage_bins.storage_loc_code')
        ->leftJoin('sap_m_storage_types','sap_m_storage_types.storage_type_code','=','sap_m_storage_bins.storage_type_code')
        ->select(['sap_m_storage_bins.*','sap_m_storage_locations.storage_location_name','sap_m_storage_types.storage_type_name',      
        ])->where('sap_m_storage_bins.id',$request->id)->first();
    }
}
