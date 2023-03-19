<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\sap_t_sttp;
use App\Models\sap_t_bpm;
use App\Models\t_inbound;
use App\Models\t_outbound;
use App\Models\t_stock;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Storage;
use File;

class DashboardController extends Controller
{
    public function countInventory(Request $request){
            
        // $inbound = t_inbound::select([DB::RAW("'Inbound' as `type`"),DB::RAW("count(*) as `count`")]);
        // $outbound = t_outbound::select([DB::RAW("'Outbound' as `type`"),DB::RAW("count(*) as `count`")]);

        if($request['query'] == "This Week"){
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item  WHERE  i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_cost >= t.qty_gr_105 ;', [Carbon::today()->subWeek()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_cost >= t.requirement_qty  ;', [Carbon::today()->subWeek()]) ;           

            // $inbound = t_inbound::select([DB::RAW("'Inbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>', Carbon::now()->subWeek());
            // $outbound = t_outbound::select([DB::RAW("'Outbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>',Carbon::now()->subWeek());

        }else if($request['query'] == "This Month"){
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item  WHERE  i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_cost >= t.qty_gr_105 ;', [Carbon::today()->subMonth()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_cost >= t.requirement_qty  ;', [Carbon::today()->subMonth()]) ;            

            // $inbound = t_inbound::select([DB::RAW("'Inbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>', Carbon::now()->subMonth());
            // $outbound = t_outbound::select([DB::RAW("'Outbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>',Carbon::now()->subMonth());

        }else if($request['query'] == "This Year"){     

            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item  WHERE  i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_cost >= t.qty_gr_105 ;', [Carbon::today()->subYear()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_cost >= t.requirement_qty  ;', [Carbon::today()->subYear()]) ;            

            // $inbound = t_inbound::select([DB::RAW("'Inbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>', Carbon::now()->subYear());
            // $outbound = t_outbound::select([DB::RAW("'Outbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>',Carbon::now()->subYear());

        }else if($request['query'] == "Today"){
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item  WHERE  i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_cost >= t.qty_gr_105 ;', [Carbon::today()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_cost >= t.requirement_qty  ;', [Carbon::today()]) ;            

            // $inbound = t_inbound::select([DB::RAW("'Inbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>=', Carbon::today());
            // $outbound = t_outbound::select([DB::RAW("'Outbound' as `type`"),DB::RAW("count(*) as `count`")])->whereDate('posting_date', '>=',Carbon::today());

        }  else{
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item GROUP BY t.sttp_id, t.line_item HAVING total_cost >= t.qty_gr_105 ;') ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item GROUP BY t.bpm_id, t.item HAVING total_cost >= t.requirement_qty  ;') ;            
        }  
        
        
        // $data = $inbound->union($outbound)->get();                
        // return $data;
        
        return [
            ['type'=>'Inbound','count' =>count($line_i)],
            ['type'=>'Outbound','count' =>count($line_o)]
        ];
        
    }

    public function transaksiBelum(Request $request){
        $bpms = sap_t_bpm::select(['doc_number','doc_date','status','pembuat','fiscal_year',DB::RAW("'BPM' as `type`")],'created_at','updated_at')->where('status','UNPROCESSED')->withCount('details as count_item');
        $sttp = sap_t_sttp::select(['doc_number','doc_date','status','pembuat','fiscal_year',DB::RAW("'STTP' as `type`")],'created_at','updated_at')->where('status','UNPROCESSED')->withCount('details as count_item');


        if($request['query'] == "Today"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date',Carbon::today());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date',Carbon::today());
        }else if($request['query'] == "This Week"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date', '>', Carbon::today()->subWeek());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date', '>', Carbon::today()->subWeek());
        }
        else if($request['query'] == "This Month"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date', '>', Carbon::today()->subMonth());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date', '>', Carbon::today()->subMonth());
        }
        else if($request['query'] == "This Year"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date', '>', Carbon::today()->subYear());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date', '>', Carbon::today()->subYear());
        }
        $data = $sttp->union($bpms)->orderBy('doc_date','asc')->limit(15)->get();                   
        return $data;        
    }

    public function materialList(){        
        $data = DB::select(DB::raw("SELECT m1.*, sap_m_materials.material_desc as 'material_codes', sap_m_materials.specification, sap_m_uoms.uom_code,sap_m_uoms.uom_name  FROM t_stocks AS m1 JOIN (SELECT material_code, MIN(gr_date) AS gr_date FROM t_stocks GROUP BY material_code ) AS m2 ON 
        m1.material_code = m2.material_code AND m1.gr_date = m2.gr_date 
        JOIN sap_m_materials ON sap_m_materials.material_code = m1.material_code         
        JOIN sap_m_uoms ON sap_m_materials.uom_id = sap_m_uoms.id         
        ORDER BY m2.material_code ASC;"));        
        return $data;
    }

    public function transaksiHari(Request $request){
        $bpms = sap_t_bpm::select(['doc_number','doc_date','status','pembuat','fiscal_year',DB::RAW("'BPM' as `type`"),'created_at','updated_at'])->withCount('details as count_item');
        $sttp = sap_t_sttp::select(['doc_number','doc_date','status','pembuat','fiscal_year',DB::RAW("'STTP' as `type`"),'created_at','updated_at'])->withCount('details as count_item');
        if($request['query'] == "Today"){
            $bpms = $bpms->where('status','PROCESSED')->whereDate('updated_at',Carbon::today());
            $sttp = $sttp->where('status','PROCESSED')->whereDate('updated_at',Carbon::today());
        }else if($request['query'] == "This Week"){
            $bpms = $bpms->where('status','PROCESSED')->whereDate('created_at', '>', Carbon::now()->subWeek());
            $sttp = $sttp->where('status','PROCESSED')->whereDate('created_at', '>', Carbon::now()->subWeek());
        }
        else if($request['query'] == "This Month"){
            $bpms = $bpms->where('status','PROCESSED')->whereDate('created_at', '>', Carbon::now()->subMonth());
            $sttp = $sttp->where('status','PROCESSED')->whereDate('created_at', '>', Carbon::now()->subMonth());
        }
        else if($request['query'] == "This Year"){
            $bpms = $bpms->where('status','PROCESSED')->whereDate('created_at', '>', Carbon::now()->subYear());
            $sttp = $sttp->where('status','PROCESSED')->whereDate('created_at', '>', Carbon::now()->subYear());
        }
        
        $data = $sttp->union($bpms)->orderBy('updated_at','DESC')->limit(15)->get();                            
        return $data;
    }
    public function scanDokumen(Request $request){                
        try {
            if($request->has('query')){
                $params = explode('/',$request['query']);  
                if(count($params) != 3){
                    return response()->json([
                        'status' => 'failed',
                        'message'=> 'Paramater missmatch in url',
                    ],422);
                }  
                $data;        
                if(strtoupper($params[0]) == "STTP"){
                    $data = sap_t_sttp::with('details')->select(['*',DB::RAW("'STTP' as `type`")])->withCount('details as count_item')->where('doc_number',$params[1])->where('fiscal_year',$params[2])->first();                                       
                    $transaction = t_inbound::where('sttp_id',$data->id)->get();                                     ;
                    $count = 0;
                    $countStats = 0;                                     
                    if($data){
                        foreach ($data->details as  $d) {
                            $count = 0;
                            foreach ($transaction as  $i) {
                                $d->line_item == $i->line_item ? $count+= $i->qty_in:'';
                            }
                            if($count >= $d->qty_gr_105 && $d->qty_gr_105 != 0 ){                
                                $d->status = 3;
                                $d->qty_inbound = $count;
                            }else if($count == 0){
                                $d->status = 1;
                                $d->qty_inbound = $count;
                            }else{
                                $d->status = 2;
                                $d->qty_inbound = $count;
                            }
                            $d->status == 3 ? $countStats++: '';
                        }
                        if($countStats >= count($data->details)){
                            $data->finish = true;                           
                        }else{
                            $data->finish = false;                            
                        }
                        return response()->json([
                            'status' => 'success',
                            'data'=> $data,
                        ],);
                    }
                    else{
                        return response()->json([
                            'status' => 'failed',
                            'message'=> 'No data found',
                        ],404);
                    }    
                }else if(strtoupper($params[0]) == "BPM"){     
                    
                    $data = sap_t_bpm::leftJoin('sap_m_storage_locations','sap_m_storage_locations.storage_location_code','=','sap_t_bpms.storage_location_code')->with(["details" => function($q){
                        $q->join('sap_m_materials','sap_m_materials.material_code','=','sap_t_bpm_dtls.material_code')->select(['sap_t_bpm_dtls.*','sap_m_materials.material_desc']);
                    }])->select(['sap_t_bpms.*',DB::RAW('sap_m_storage_locations.storage_location_name as destination'),DB::RAW("'BPM' as `type`")])->withCount('details as count_item')
                    ->where('doc_number',$params[1])->where('fiscal_year',$params[2])->first();
                    
                    $transaction = t_outbound::where('bpm_id',$data->id)->get();
                    $count = 0;
                    $countStats = 0;
                    if($data){
                        foreach ($data->details as  $d) {
                            $count = 0;                
                            foreach ($transaction as  $i) {
                                $d->item == $i->line_item ? $count+= $i->qty_out:'';
                            }
                            if($count >= $d->requirement_qty && $d->requirement_qty != 0){                
                                $d->status = 3;
                                $d->qty_outbound = $count;                    
                            }else if($count == 0){
                                $d->status = 1;
                                $d->qty_outbound = $count;
                            }else{
                                $d->status = 2;
                                $d->qty_outbound = $count;
                            }                  
                            $d->status == 3 ? $countStats++: '';                                    
                        }
                        if($countStats >= count($data->details)){
                            $data->finish = true;                           
                        }else{
                            $data->finish = false;                            
                        }
                        return response()->json([
                            'status' => 'success',
                            'data'=> $data,
                        ],);
                    }                                        
                } else{
                    return response()->json([
                        'status' => 'failed',
                        'message'=> 'No data found',
                    ],404);
                }                           
                
            }else{
                return response()->json([
                        'status' => 'failed',
                        'message'=> 'No paramater in url',
                    ],422);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'failed',
                'message'=> $th->getMessage(),
            ],500);
        }
                           
        
    }

    public function notificationList(){        
        // $data = DB::table('select * from user_notifikasi as u JOIN notifikasi as n on u.notifikasi_id = n.id')->where('u.user_id' auth('sanctum')->user()->id)->paginate(15);
        $data = DB::table('user_notifikasi')->select('*')->join('notifikasi', 'user_notifikasi.notifikasi_id', '=', 'notifikasi.id')
        ->where('user_notifikasi.user_id',auth('sanctum')->user()->id)->paginate(15);
        
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ],200);
    }


    public function transactionProcess(Request $request){
        
        TInboundController::sttpTransaksi($request);
    }

    public function myTransaction (Request $request){
        $bpms = sap_t_bpm::select(['sap_t_bpms.doc_number','sap_t_bpms.doc_date','sap_t_bpms.status','sap_t_bpms.pembuat','sap_t_bpms.fiscal_year',DB::RAW("'BPM' as `type`"),'sap_t_bpms.created_at','sap_t_bpms.updated_at',])->withCount('details as count_item')
        ->join('t_outbounds','sap_t_bpms.id','=','t_outbounds.bpm_id');
        $sttp = sap_t_sttp::select(['sap_t_sttps.doc_number','sap_t_sttps.doc_date','sap_t_sttps.status','sap_t_sttps.pembuat','sap_t_sttps.fiscal_year',DB::RAW("'STTP' as `type`"),'sap_t_sttps.created_at','sap_t_sttps.updated_at'])->withCount('details as count_item')
        ->join('t_inbounds','sap_t_sttps.id','=','t_inbounds.sttp_id');
      
        $bpms = $bpms->where('status','ON PROCESS')->where('t_outbounds.user_id',auth('sanctum')->user()->id);
        $sttp = $sttp->where('status','ON PROCESS')->where('t_inbounds.user_id',auth('sanctum')->user()->id);


        if($request['query'] == "Today"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date',Carbon::today());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date',Carbon::today());
        }else if($request['query'] == "This Week"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date', '>', Carbon::today()->subWeek());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date', '>', Carbon::today()->subWeek());
        }
        else if($request['query'] == "This Month"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date', '>', Carbon::today()->subMonth());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date', '>', Carbon::today()->subMonth());
        }
        else if($request['query'] == "This Year"){
            $bpms = $bpms->whereDate('sap_t_bpms.doc_date', '>', Carbon::today()->subYear());
            $sttp = $sttp->whereDate('sap_t_sttps.doc_date', '>', Carbon::today()->subYear());
        }

        $data = $sttp->union($bpms)->orderBy('updated_at','ASC')->groupBy('doc_date','fiscal_year')->limit(15)->get();                            
        return $data;
    }

    public function myPerformance(Request $request){
       
        $date = '';                                                  
        $labor_s = DB::table('t_inbounds')->leftJoin('sap_t_sttp_dtls', function($join)
        {
            $join->on('t_inbounds.sttp_id', '=', 'sap_t_sttp_dtls.sttp_id');
            $join->on('t_inbounds.line_item','=','sap_t_sttp_dtls.line_item');         
        })->groupBy('t_inbounds.sttp_id','t_inbounds.line_item')
        ->havingRaw('SUM(t_inbounds.qty_in) >= qty_gr_105')
        ->where('t_inbounds.user_id','=',auth('sanctum')->user()->id)        
        ->select('qty_gr_105 as qty',DB::RAW("SUM(TIME_TO_SEC(t_inbounds.posting_date) - TIME_TO_SEC(sap_t_sttp_dtls.started_at)) as sum_date"));
        
        

        $labor_b =  DB::table('t_outbounds')->leftJoin('sap_t_bpm_dtls', function($join)
        {
            $join->on('t_outbounds.bpm_id', '=', 'sap_t_bpm_dtls.bpm_id');
            $join->on('t_outbounds.line_item','=','sap_t_bpm_dtls.item');         
        })
        ->groupBy('t_outbounds.bpm_id','t_outbounds.line_item')
        ->havingRaw('SUM(t_outbounds.qty_out) >= requirement_qty')
        ->where('t_outbounds.user_id','=',auth('sanctum')->user()->id)
        ->select('requirement_qty as qty',DB::RAW("SUM(TIME_TO_SEC(t_outbounds.posting_date) - TIME_TO_SEC(sap_t_bpm_dtls.started_at)) as sum_date"));        
        if($request['query'] == "Today"){
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND user_id = ? AND line_item = t.line_item) total_fare,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item  WHERE  i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_fare IS NOT NULL and total_cost >= t.qty_gr_105 ;', [auth('sanctum')->user()->id,Carbon::today()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND user_id = ? AND line_item = t.item) total_fare,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_fare IS NOT NULL and total_cost >= t.requirement_qty  ;', [auth('sanctum')->user()->id,Carbon::today()]) ;
            
            $labor_s = $labor_s->whereDate('t_inbounds.posting_date','>=',Carbon::today());
            $labor_b = $labor_b->whereDate('t_outbounds.posting_date','>=',Carbon::today());
        }else if($request['query'] == "This Week"){
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item AND user_id = ?) total_fare,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_fare IS NOT NULL and total_cost >= t.qty_gr_105 ;', [auth('sanctum')->user()->id,Carbon::today()->subWeek()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item AND user_id = ?) total_fare,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item  WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_fare IS NOT NULL and total_cost >= t.requirement_qty  ;', [auth('sanctum')->user()->id,Carbon::today()->subWeek()]) ;

            $labor_s = $labor_s->whereDate('t_inbounds.posting_date','>=',Carbon::today()->subWeek());
            $labor_b = $labor_b->whereDate('t_outbounds.posting_date','>=',Carbon::today()->subWeek());
        }
        else if($request['query'] == "This Month"){
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item AND user_id = ?) total_fare,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item WHERE i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_fare IS NOT NULL and total_cost >= t.qty_gr_105 ;', [auth('sanctum')->user()->id,Carbon::today()->subMonth()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item AND user_id = ?) total_fare,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_fare IS NOT NULL and total_cost >= t.requirement_qty  ;', [auth('sanctum')->user()->id,Carbon::today()->subMonth()]) ;

            $labor_s = $labor_s->whereDate('t_inbounds.posting_date','>=',Carbon::today()->subMonth());
            $labor_b = $labor_b->whereDate('t_outbounds.posting_date','>=',Carbon::today()->subMonth());
        }
        else if($request['query'] == "This Year"){           
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item AND user_id = ?) total_fare,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item WHERE i.posting_date >= ?  GROUP BY t.sttp_id, t.line_item HAVING total_fare IS NOT NULL and total_cost >= t.qty_gr_105 ;', [auth('sanctum')->user()->id,Carbon::today()->subYear()]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item AND user_id = ?) total_fare,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item WHERE i.posting_date >= ?  GROUP BY t.bpm_id, t.item HAVING total_fare IS NOT NULL and total_cost >= t.requirement_qty  ;', [auth('sanctum')->user()->id,Carbon::today()->subYear()]) ;

            $labor_s = $labor_s->whereDate('t_inbounds.posting_date','>=',Carbon::today()->subYear());
            $labor_b = $labor_b->whereDate('t_outbounds.posting_date','>=',Carbon::today()->subYear());
        }else {
            $line_i = DB::select('SELECT t.*,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item  AND user_id = ?) total_fare,(SELECT SUM(qty_in) FROM t_inbounds WHERE sttp_id = t.sttp_id AND line_item = t.line_item) total_cost FROM sap_t_sttp_dtls t join t_inbounds i on t.sttp_id = i.sttp_id and t.line_item = i.line_item GROUP BY t.sttp_id, t.line_item HAVING total_fare IS NOT NULL and total_cost >= t.qty_gr_105;', [auth('sanctum')->user()->id]) ;
            $line_o = DB::select('SELECT t.*,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id  AND line_item = t.item AND user_id = ?) total_fare,(SELECT SUM(qty_out) FROM t_outbounds WHERE bpm_id = t.bpm_id AND line_item = t.item) total_cost FROM sap_t_bpm_dtls t join t_outbounds i on t.bpm_id = i.bpm_id and t.item = i.line_item GROUP BY t.bpm_id, t.item HAVING total_fare IS NOT NULL and total_cost >= t.requirement_qty;', [auth('sanctum')->user()->id]) ;            
        }

        

        $data_sum =  $labor_b->union($labor_s);  
        $seconds = $data_sum->sum('sum_date');
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60); 
        $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs); 
           
        return ['labor_hours' => $timeFormat ,
        'count_item' => count($line_i)  + count($line_o)];
    }

    public function home(Request $request){

        try {
            $header = $this->countInventory($request);
            $transaction = $this->transaksiBelum($request);
            $transactionToday = $this->myTransaction($request);
            $performance = $this->myPerformance($request);           
            return response()->json([
                'status' => 'success',
                'data' => [
                    'header' => $header,
                    'transactionNot' => $transaction, 
                    'transactionToday'=> $transactionToday,
                    'performance'=> $performance ],                    
            ],200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed','message'=> $e->getMessage()],500);
        }        
       
    }

    public function listMyTransaction(Request $request){
        $bpms = sap_t_bpm::select(['sap_t_bpms.doc_number','sap_t_bpms.doc_date','sap_t_bpms.status','sap_t_bpms.pembuat','sap_t_bpms.fiscal_year','sap_t_bpms.enter_date',DB::RAW("'BPM' as `type`"),'sap_t_bpms.created_at','sap_t_bpms.updated_at',])->withCount('details as count_item')
        ->join('t_outbounds','sap_t_bpms.id','=','t_outbounds.bpm_id');
        $sttp = sap_t_sttp::select(['sap_t_sttps.doc_number','sap_t_sttps.doc_date','sap_t_sttps.status','sap_t_sttps.pembuat','sap_t_sttps.fiscal_year','sap_t_sttps.enter_date',DB::RAW("'STTP' as `type`"),'sap_t_sttps.created_at','sap_t_sttps.updated_at'])->withCount('details as count_item')
        ->join('t_inbounds','sap_t_sttps.id','=','t_inbounds.sttp_id');
                                  
        if($request->has('query')){
            $sttp = $sttp->where('doc_number','LIKE','%'.$request->get('query').'%');                                                                                                                            
            $bpms = $bpms->where('doc_number','LIKE','%'.$request->get('query').'%');                                                                                                                            
        }

        if($request->has('status')){
            $sttp = $sttp->where('status','LIKE','%'.$request->get('query').'%');                                                                                                                            
            $bpms = $bpms->where('status','LIKE','%'.$request->get('query').'%');                                                                                                                            
        }

        $bpms = $bpms->where('t_outbounds.user_id',auth('sanctum')->user()->id)->where('status','!=','UNPROCESSED');
        $sttp = $sttp->where('t_inbounds.user_id',auth('sanctum')->user()->id)->where('status','!=','UNPROCESSED');   

        $bpms= $bpms->groupBy('sap_t_bpms.id');
        $sttp= $sttp->groupBy('sap_t_sttps.id');
        $union = $sttp->unionAll($bpms);
        return response()->json(['data'=>$union->orderBy('enter_date','DESC')->paginate(15),'status'=>'success'],200);

    }
}
