<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sap_m_materials;
use DB;
use Cache;
class MaterialController extends Controller
{
    public function index(Request $request){
        $materials = sap_m_materials::leftJoin('t_stocks', function($join)
        {            
            $join->on('t_stocks.material_code', '=', 'sap_m_materials.material_code');
        })->join('sap_m_uoms','sap_m_uoms.id','=','sap_m_materials.uom_id')
        ->select(['sap_m_materials.material_code','sap_m_materials.material_desc','sap_m_uoms.uom_code',
        DB::RAW("COALESCE(t_stocks.special_stock_number,'-') as special_stock_number"),DB::RAW("COALESCE(SUM(t_stocks.qty),0) as qty_stock"),]);
        

        if($request->has('query')){
            $materials = $materials->where('sap_m_materials.material_code','LIKE','%'.$request->get('query').'%')
            ->orWhere('sap_m_materials.material_desc','LIKE','%'.$request->get('query').'%')
            ->orWhere('special_stock_number','LIKE','%'.$request->get('query').'%');
        }
        $materials = $materials->groupBy('t_stocks.special_stock_number','sap_m_materials.material_code')->orderBy('qty_stock','desc')->paginate(15);

        // $result = Cache::remember('materials_'.$request->input('page',1), 120, function () use ($materials) {
        //     return $materials;
        // });

        return response()->json(
            ['status'=>'success',
            'data'=>$materials
        ],200);
    }

    public function detailMaterial(Request $request){

        try {
            if($request->has('material_code') && $request->has('wbs_element')){
                $materials = sap_m_materials::where('sap_m_materials.material_code',$request->material_code)
                ->leftJoin('sap_m_uoms','sap_m_uoms.id','=','sap_m_materials.uom_id')                
                ->leftJoin('t_stocks', function($join) use($request)
                {
                    $join->on('t_stocks.material_code', '=', 'sap_m_materials.material_code')
                    ->where('t_stocks.special_stock_number', '=', $request->wbs_element);
                })
                ->selectRaw("sap_m_materials.*,sap_m_uoms.uom_code,coalesce(SUM(t_stocks.qty),'-') as qty_stock");
                return response()->json(['status'=>'success','data'=> $materials->get()]);
    
            }else{
                return response()->json(['status'=>'failed','message'=>'Paramater Missmatch'],422);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
        
        
    }

    public function storageMaterial(Request $request){

        try {
            if($request->has('material_code') && $request->has('wbs_element')){
                $materials = sap_m_materials::where('sap_m_materials.material_code',$request->material_code)
                ->leftJoin('sap_m_uoms','sap_m_uoms.id','=','sap_m_materials.uom_id')
                ->leftJoin('t_stocks','t_stocks.material_code', '=', 'sap_m_materials.material_code')
                ->leftJoin('sap_m_storage_bins','sap_m_storage_bins.storage_bin_code', '=', 't_stocks.bin_code')
                ->leftJoin('sap_m_plants','sap_m_plants.plant_code', '=', 't_stocks.plant_code')
                ->leftJoin('sap_m_storage_types','sap_m_storage_types.storage_type_code', '=', 't_stocks.storage_type_code')
                ->leftJoin('sap_m_storage_locations','sap_m_storage_locations.storage_location_code', '=', 't_stocks.storloc_code')
                ->where('t_stocks.special_stock_number',$request->wbs_element)->groupBy('t_stocks.bin_code')
                ->selectRaw('sap_m_materials.*,sap_m_uoms.uom_code,sap_m_plants.plant_name,sap_m_storage_types.storage_type_name,sap_m_storage_locations.storage_location_name,sap_m_storage_bins.storage_bin_name,SUM(t_stocks.qty) as qty_stock');
                return response()->json(['status'=>'success','data'=> $materials->paginate(5)]);
    
            }else{
                return response()->json(['status'=>'failed','message'=>'Paramater Missmatch'],422);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
                
    }

    public function historyMaterial(Request $request){
        try {
            if($request->has('material_code') && $request->has('wbs_element')){
               $inbound = DB::table('t_inbounds')
               ->leftJoin('sap_t_sttp_dtls', function($join)
                {            
                    $join->on('sap_t_sttp_dtls.sttp_id', '=', 't_inbounds.sttp_id');
                    $join->on('sap_t_sttp_dtls.line_item', '=', 't_inbounds.line_item');
                    $join->on('sap_t_sttp_dtls.material_code', '=', 't_inbounds.material_code');
                })
                ->leftJoin('sap_t_sttps','sap_t_sttps.id', '=', 't_inbounds.sttp_id')
                ->leftJoin('sap_m_storage_bins','sap_m_storage_bins.storage_bin_code', '=', 't_inbounds.bin_code')
                ->leftJoin('sap_m_plants','sap_m_plants.plant_code', '=', 'sap_m_storage_bins.plant_code')
                ->leftJoin('sap_m_storage_types','sap_m_storage_types.storage_type_code', '=', 'sap_m_storage_bins.storage_type_code')
                ->leftJoin('sap_m_storage_locations','sap_m_storage_locations.storage_location_code', '=', 'sap_m_storage_bins.storage_loc_code')
                ->where([['t_inbounds.material_code',$request->material_code],['t_inbounds.wbs_code',$request->wbs_element]])
                ->selectRaw("sap_t_sttps.doc_number,sap_t_sttps.enter_date,t_inbounds.qty_in as qty,sap_t_sttp_dtls.uom as uom,sap_m_plants.plant_name,sap_m_storage_types.storage_type_name,sap_m_storage_locations.storage_location_name,sap_m_storage_bins.storage_bin_code,'INBOUNDS' as type ");
                

                $outbound = DB::table('t_outbounds')
               ->leftJoin('sap_t_bpm_dtls', function($join)
                {            
                    $join->on('sap_t_bpm_dtls.bpm_id', '=', 't_outbounds.bpm_id');
                    $join->on('sap_t_bpm_dtls.item', '=', 't_outbounds.line_item');
                    $join->on('sap_t_bpm_dtls.material_code', '=', 't_outbounds.material_code');
                })
                ->leftJoin('sap_t_bpms','sap_t_bpms.id', '=', 't_outbounds.bpm_id')
                ->leftJoin('sap_m_storage_bins','sap_m_storage_bins.storage_bin_code', '=', 't_outbounds.bin_code')
                ->leftJoin('sap_m_plants','sap_m_plants.plant_code', '=', 'sap_m_storage_bins.plant_code')
                ->leftJoin('sap_m_storage_types','sap_m_storage_types.storage_type_code', '=', 'sap_m_storage_bins.storage_type_code')
                ->leftJoin('sap_m_storage_locations','sap_m_storage_locations.storage_location_code', '=', 'sap_m_storage_bins.storage_loc_code')
                ->where([['t_outbounds.material_code',$request->material_code],['t_outbounds.wbs_code',$request->wbs_element]])
                ->selectRaw("sap_t_bpms.doc_number,sap_t_bpms.enter_date,t_outbounds.qty_out as qty,sap_t_bpm_dtls.uom_code as uom,sap_m_plants.plant_name,sap_m_storage_types.storage_type_name,sap_m_storage_locations.storage_location_name,sap_m_storage_bins.storage_bin_code,'OUTBOUNDS' as type ");
                
            return response()->json(['status'=>'success','data'=> $inbound->unionAll($outbound)->orderBy('enter_date','desc')->paginate(5)]);
    
    
            }else{
                return response()->json(['status'=>'failed','message'=>'Paramater Missmatch'],422);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>'failed','message'=>$e->getMessage()]);
        }
    }


}
