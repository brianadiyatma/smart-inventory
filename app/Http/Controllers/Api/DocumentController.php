<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\sap_t_sttp;
use App\Models\sap_t_bpm;
class DocumentController extends Controller
{
    public function index(Request $request)
    {
        
        $bpms = sap_t_bpm::select(['doc_number','doc_date','status','pembuat','enter_date','fiscal_year','created_at',DB::RAW("'BPM' as `type`")])->withCount('details as count_item');
        $sttp = sap_t_sttp::select(['doc_number','doc_date','status','pembuat','enter_date','fiscal_year','created_at',DB::RAW("'STTP' as `type`")])->withCount('details as count_item');        
        $data = $sttp->unionAll($bpms);
        $union =DB::table(DB::raw("({$data->toSql()} ORDER BY status DESC,enter_date ASC) as b"))       
        ->selectRaw("b.*");        

        if($request->has('status')){
            if($request->status != ''){
                $params = explode(',',$request->status);
                if(count($params)>0 && !empty($params[0])){
                    $union = $union->whereIn('status',$params);     
                }  
                           
            }
        }        

        if($request->has('type')){
            if($request->type != '' ){
                $params = explode(',',$request->type);
                if(count($params)>0  && !empty($params[0])){
                    $union = $union->whereIn('b.type',$params);     
                }                               
            }            
        }
        
        if($request->has('query') && strlen($request['query']) != 0){           
            $union = $union->where('b.doc_number','LIKE','%'.$request->get('query').'%');                                                                                                                            
        }
        return response()->json([
            'status' => 'success',
            'data' => $union->paginate(15),
        ],200);
        
    }
}
