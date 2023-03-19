<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_inbound;
use App\Models\t_outbound;
use App\Models\sap_t_sttp;
use App\Models\sap_t_sttp_dtl;
use App\Models\sap_t_bpm;
use App\Models\sap_t_bpm_dtl;
use App\Models\t_stock;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\sap_m_storage_bin;
use App\Models\sap_m_storage_type;
use App\Models\sap_m_storage_locations;
use App\Http\Controllers\Api\NotifikasiController;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TransactionController extends Controller
{
    public function infoDetailInbound(Request $request){        
        $detail = sap_t_sttp_dtl::select(['sap_t_sttp_dtls.*','sap_m_materials.specification'])->with('sttp')->join('sap_m_materials','sap_t_sttp_dtls.material_code','=','sap_m_materials.material_code')->find($request->id);
        if(is_null($detail)){
            return response()->json([
                'status' => 'failed',
                'data' => $detail,
            ],500);
        }
        isset($detail->started_at) ? true : $detail->started_at = now();
        $detail->update();
        $inbound = t_inbound::where([['sttp_id',$detail->sttp_id],['material_code',$detail->material_code],['wbs_code',$detail->wbs_code]])->sum('qty_in');
        $detail['qty_in'] = $inbound;        
        $detail->qty_gr_105-$inbound <= 0 ? $detail['qty_left'] = 0 : $detail['qty_left'] = $detail->qty_gr_105-$inbound;
        return response()->json([
            'status' => 'success',
            'data' => $detail,
        ]);
    }

    public function infoDetailOutbound(Request $request){    
        $detail = sap_t_bpm_dtl::with(['bpm','wbs.project'])
        ->join('sap_m_materials','sap_t_bpm_dtls.material_code','=','sap_m_materials.material_code')
        ->select(['sap_t_bpm_dtls.*','sap_m_materials.specification','sap_m_materials.material_desc'])->find($request->id);
        if(is_null($detail)){
            return response()->json([
                'status' => 'failed',
                'message' => 'Data outbound not found',  
            ],500);
        }
        isset($detail->started_at) ? '' : $detail->started_at = now();
        $detail->update();
        $outbound = t_outbound::where([['bpm_id',$detail->bpm_id],['material_code',$detail->material_code],['wbs_code',$detail->wbs_code]])->sum('qty_out');
        $detail['qty_out'] = $outbound;     
        if(isset($detail->requirement_qty) && strlen($detail->requirement_qty) != 0){
            $detail->requirement_qty-$outbound <= 0 ? $detail['qty_left'] = 0 : $detail['qty_left'] = $detail->requirement_qty-$outbound;
        }        
        
                   
        $bin = sap_m_storage_bin::join('t_stocks','sap_m_storage_bins.storage_bin_code','=','t_stocks.bin_code')
        ->join('sap_m_plants','sap_m_plants.plant_code','=','sap_m_storage_bins.plant_code')
        ->join('sap_m_storage_types','sap_m_storage_types.storage_type_code','=','sap_m_storage_bins.storage_type_code')
        ->join('sap_m_storage_locations','sap_m_storage_locations.id','=','sap_m_storage_bins.storage_loc_code')
        ->select(['sap_m_storage_bins.*','t_stocks.qty','sap_m_plants.plant_name','sap_m_storage_types.storage_type_name','sap_m_storage_locations.storage_location_name'])
        ->where([            
            ['t_stocks.material_code',isset($detail->material_code) ?$detail->material_code: NULL],
            ['t_stocks.special_stock_number',isset($detail->wbs_code) ?$detail->wbs_code: NULL],
        ])->get();
        $bin->makeHidden(['created_at','updated_at','deleted_at']);
        return response()->json([
            'status' => 'success',
            'data' => ['detail' => $detail,'bin'=>$bin],
        ]); 
    }

    public function locationRequest(Request $request){
        $location = sap_m_storage_locations::all();

        return response()->json([
            'status' =>'success',
            'data'=>$location
        ]);
    }

    public function locationTypeRequest(Request $request){
        $type = sap_m_storage_bin::select(['sap_m_storage_bins.*','sap_m_storage_types.storage_type_name'])->join('sap_m_storage_types','sap_m_storage_bins.storage_type_code','=','sap_m_storage_types.storage_type_code');

        if($request->has('location_id')){
            $type = $type->where('storage_loc_code',$request->location_id);
            return response()->json([
                'status' =>'success',
                'data'=>$type->groupBy(['sap_m_storage_bins.storage_loc_code','sap_m_storage_types.storage_type_code','sap_m_storage_types.storage_type_name'])->get()
            ]);
        }else{
            return response()->json([
                'status' =>'failed',
                'message'=> 'Data unprocessedas'
            ],422);
        }
    }

    public function locationTypeBinRequest(Request $request){
        $bin = sap_m_storage_bin::with('type');
       
        if($request->has('location_id') && $request->has('type_id') ){
            $bin = sap_m_storage_bin::where('storage_loc_code',$request->location_id);
            $bin = $bin->where('storage_type_code',$request->type_id);
            return response()->json([
                'status' =>'success',
                'data'=>$bin->get()
            ]);
        }else if($request->has('query')){
            $params = explode('/',$request->query);
            $bin = sap_m_storage_bin::where([
                ['plant_code',$request->$params[0]],
                ['storage_loc_code',$request->$params[1]],
                ['storage_type_code',$request->$params[2]],
                ['storage_bin_code',$request->$params[3]],
            ]);            
            return response()->json([
                'status' =>'success',
                'data'=>$bin->get()
            ]);
        }else{
            return response()->json([
                'status' =>'failed',
                'message'=>'Data unprocessed'
            ],422);

        }           
       
    }
    

    public function binRequest(Request $request){
        
        $storage_level = sap_m_storage_bin::with(['plant','type','loc']);
        if($request->has('id')){
            $storage_level = $storage_level->where('storage_location_id',$request->id);
        }
        return response()->json([
            'status' =>'success',
            'data'=>$storage_level->get()
        ]);
    }

    public function requestPostInbound(Request $request)
    {        
        $sttp_dtl = sap_t_sttp_dtl::with(['sttp','sttp.proyek'])->find($request->id);                                                        
        $inbound = t_inbound::where([['sttp_id',$sttp_dtl->sttp_id],['material_code',$request->material_code],['line_item',$request->line_item]])->sum('qty_in');
        if(is_numeric($request->bin_code)){
            $bin = sap_m_storage_bin::with(['plant','type','loc'])->find($request->bin_code);    
        }else{
            
            $params = explode('/',$request->bin_code);
            if(count($params) == 4){
                $bin = sap_m_storage_bin::with(['plant','type','loc'])->where('storage_bin_code',$params[3])->first();    
                
            }else{
                return response()->json(['status'=>'failed','message'=>'Unprocessed Data'],422);
            }
            
        }
        if(is_null($bin)){
            return response()->json(['status'=>'failed','message'=>'Bin Not Found'],404);    
        }
        $qty = $sttp_dtl->qty_gr_105 - $inbound;     
        if($request->has('foto')){  
            $request->validate([
                'id' => 'required|exists:sap_t_sttp_dtls,id',            
                'material_code' => 'required|exists:sap_m_materials,material_code',            
                'bin_code' => 'exists:sap_m_storage_bins,id',            
                'qty_in' => "required|min:1|max:$qty",
                'foto' => 'mimes:jpeg,bmp,png,gif,jpg,svg|max:20000'
            ]);
        }else{
            $request->validate([
                'id' => 'required|exists:sap_t_sttp_dtls,id',            
                'material_code' => 'required|exists:sap_m_materials,material_code',            
                'bin_code' => 'exists:sap_m_storage_bins,id',            
                'qty_in' => "required|min:1|max:$qty",                
            ]);
        }                            
        DB::beginTransaction();        
         try {                                           
                if($request->has('foto')){     
                    $filename = uniqid().$request->file('foto')->getClientOriginalName();
                    $file = $request->file('foto');
                    $directory = $sttp_dtl->sttp->fiscal_year.'/'.$sttp_dtl->sttp->doc_number;
                    $path = Storage::disk('inbound')->putFileAs($directory,$file,$filename);        
                   $inbound = t_inbound::create([           
                    'sttp_id' => $sttp_dtl->sttp_id,
                    'line_item' => $sttp_dtl->line_item,
                    'material_code' => $sttp_dtl->material_code,
                    'plant_code' => $bin->plant->plant_code,
                    'storloc_code' => $bin->loc->storage_location_code,
                    'bin_code' => $bin->storage_bin_code,
                    'wbs_code' => isset($sttp_dtl->wbs_code) ? $sttp_dtl->wbs_code: NULL,
                    'qty_in' => $request->qty_in,
                    'posting_date' => now(),
                    'user_id' => auth('sanctum')->user()->id,
                    'photo_url'=> $directory.'/'.$filename
                ]);                                
                }
                else{
                    $inbound = t_inbound::create([           
                        'sttp_id' => $sttp_dtl->sttp_id,
                        'line_item' => $sttp_dtl->line_item,
                        'material_code' => $sttp_dtl->material_code,
                        'plant_code' => $bin->plant->plant_code,
                        'storloc_code' => $bin->loc->storage_location_code,
                        'bin_code' => $bin->storage_bin_code,
                        'wbs_code' => isset($sttp_dtl->wbs_code) ? $sttp_dtl->wbs_code: NULL,
                        'qty_in' => $request->qty_in,
                        'posting_date' => now(),
                        'user_id' => auth('sanctum')->user()->id,
                        
                    ]); 
                }                              
                $sttp_dtl->qty_warehouse = empty($sttp_dtl->qty_warehouse) ? $request->qty_in: $sttp_dtl->qty_warehouse+$request->qty_in;
                
                
                $stock = t_stock::where([
                    ['material_code' , $sttp_dtl->material_code], 
                    ['special_stock_number' , $sttp_dtl->wbs_code], 
                    ['plant_code' , $bin->plant->plant_code],
                    ['storloc_code' , $bin->loc->storage_location_code],
                    ['storage_type_code' , $bin->type->storage_type_code],
                    ['bin_code' , $bin->storage_bin_code]])
                ->first();
                if(is_null($stock)) {
                    $stock = new t_stock([
                        'material_code' => $sttp_dtl->material_code,
                        'plant_code' => $bin->plant->plant_code,
                        'storloc_code' =>$bin->loc->storage_location_code,                    
                        'storage_type_code' => $bin->type->storage_type_code,  
                        'bin_code' => $bin->storage_bin_code,                  
                        'special_stock' => isset($sttp_dtl->wbs_code) ? 'x' : NULL,
                        'special_stock_number' => isset($sttp_dtl->wbs_code) ? $sttp_dtl->wbs_code  : NULL,                   
                        'qty' =>  $request->qty_in,
                        'gr_date' => now(),          
                    ]);
                    $stock->save();
                } else {
                    $stock->plant_code =  $bin->plant->plant_code;
                    $stock->storloc_code = $bin->loc->storage_location_code;                    
                    $stock->storage_type_code = $bin->type->storage_type_code;  
                    $stock->bin_code = $bin->storage_bin_code;                  
                    $stock->special_stock = isset($sttp_dtl->wbs_code) ? 'x' : NULL;
                    $stock->special_stock_number = isset($sttp_dtl->wbs_code) ? $sttp_dtl->wbs_code  : NULL;                      
                    $stock->qty = $stock->qty + $request->qty_in;
                    $stock->gr_date = now();     
                    $stock->update();
                }

                $sttp = sap_t_sttp::find($sttp_dtl->sttp_id);
                if($sttp->status == 'UNPROCESSED'){
                    $sttp->status = 'ON PROCESS';
                    $sttp->started_at = now();
                    $sttp->update();
                }                              
                DB::commit();
                return response()->json([
                'status' => 'success',
                'message' => 'Inbound created successfully',
                ]);               
           
          
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ],500);
         }   
    }

    public function sttpDone(Request $request){
        try {
            $sttp = sap_t_sttp::findOrFail($request->id);
            
            $api_url = env('SAP_API_URL','google.com').'/sttp/transfer-posting/'.$sttp->doc_number.'/'.$sttp->fiscal_year;
        
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);

            $response = $client->get($api_url,[]);
            $status = $response->getBody()->getContents();
            $json_response = json_decode($status);

            if($json_response->status_code == 200){
                $sttp->status = 'PROCESSED';
                $sttp->finished_at = now();
                $sttp->update();

                $notifikasi = Notifikasi::create([
                    'title' => 'STTP Document Finished',
                    'body'  => 'Hello, STTP is finished with document number :'.$sttp->doc_number
                ]);     

                $notifikasi->user()->attach(User::all()->pluck('id'),['status'=> 'unread','created_at'=>now(),'updated_at'=>now()]);
            }

                $request['title'] = $notifikasi->title;
                $request['body'] = $notifikasi->body;                               

                $notif = (new NotifikasiController)->notification($request); 

            return response()->json([
                'status' => 'success',
                'message' => 'STTP Sudah Selesai',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ],500);
        }     
    }

    public function requestPostOutbound(Request $request)
    {        
        $bpm_dtl = sap_t_bpm_dtl::with(['bpm'])->find($request->id);                         
        $outbound = t_outbound::where([['bpm_id',$bpm_dtl->bpm_id],['material_code',$bpm_dtl->material_code],['line_item',$bpm_dtl->item]])->sum('qty_out');        
        $qty = $bpm_dtl->requirement_qty - $outbound;
        if($request->has('foto')){
            $request->validate([
                'id' => 'required|exists:sap_t_bpm_dtls,id',            
                'material_code' => 'required|exists:sap_m_materials,material_code',            
                'bin_code' => 'required|exists:sap_m_storage_bins,id',            
                'qty_out' => "required|min:1|max:$qty",
                'foto' => 'mimes:jpeg,bmp,png,gif,svg|max:20000'
            ]);
        }else{
            $request->validate([
                'id' => 'required|exists:sap_t_bpm_dtls,id',            
                'material_code' => 'required|exists:sap_m_materials,material_code',            
                'bin_code' => 'required|exists:sap_m_storage_bins,id',            
                'qty_out' => "required|min:1|max:$qty",                
            ]);
        }
                 
        $bin = sap_m_storage_bin::with(['plant','type','loc'])->find($request->bin_code);                
        DB::beginTransaction();
         try {                                                        
                $stock = t_stock::where([
                    ['material_code' , $bpm_dtl->material_code], 
                    ['plant_code' , $bin->plant->plant_code],
                    ['storloc_code' , $bin->loc->storage_location_code],
                    ['storage_type_code' , $bin->type->storage_type_code],
                    ['bin_code' , $bin->storage_bin_code],
                    ['special_stock_number' ,$bpm_dtl->wbs_code],])
                ->first();                
                if(is_null($stock)) {                     
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Storage empty !',
                    ],404);                  
                } else {       
                    if($request->hasFile('foto')){
                        $filename = uniqid().$request->file('foto')->getClientOriginalName();
                        $file = $request->file('foto');
                        $directory = $bpm_dtl->bpm->fiscal_year.'/'.$bpm_dtl->bpm->doc_number;
                        $path = Storage::disk('outbound')->putFileAs($directory,$file,$filename);                 
                        $outbound = t_outbound::create([           
                            'bpm_id' => $bpm_dtl->bpm_id,
                            'line_item' => $bpm_dtl->item,
                            'material_code' => $bpm_dtl->material_code,
                            'plant_code' => isset($bpm_dtl->plant_code) ? $bpm_dtl->plant_code : NULL,
                            'storloc_code' => isset($bpm_dtl->bpm->storage_location_code) ? $bpm_dtl->bpm->storage_location_code : ( isset($bpm_dtl->storage_location_code) ? $bpm_dtl->storage_location_code : NULL),                                        
                            'bin_code' => $bin->storage_bin_code,     
                            'wbs_code' => isset($bpm_dtl->wbs_code) ? $bpm_dtl->wbs_code : NULL,
                            'qty_out' => $request->qty_out,
                            'posting_date' => now(),
                            'user_id' => auth('sanctum')->user()->id,
                            'photo_url'=> $directory.'/'.$filename
                        ]);
                    }else{
                        $outbound = t_outbound::create([           
                            'bpm_id' => $bpm_dtl->bpm_id,
                            'line_item' => $bpm_dtl->item,
                            'material_code' => $bpm_dtl->material_code,
                            'plant_code' => isset($bpm_dtl->plant_code) ? $bpm_dtl->plant_code : NULL,
                            'storloc_code' =>isset($bpm_dtl->bpm->storage_location_code) ? $bpm_dtl->bpm->storage_location_code : ( isset($bpm_dtl->storage_location_code) ? $bpm_dtl->storage_location_code : NULL),                                        
                            'bin_code' => $bin->storage_bin_code,     
                            'wbs_code' => isset($bpm_dtl->wbs_code) ? $bpm_dtl->wbs_code : NULL,
                            'qty_out' => $request->qty_out,
                            'posting_date' => now(),
                            'user_id' => auth('sanctum')->user()->id,
                        ]);
                    }                          
                    $stock->qty = $stock->qty - $request->qty_out;
                    $stock->gr_date = now();   
                    $stock->qty == 0 ? $stock->update() : $stock->update(); 
                    
                    
                }

                
               
                

                $notif = (new NotifikasiController)->notification($request); 
                $bpm = sap_t_bpm::find($bpm_dtl->bpm_id);
                if($bpm->status == 'UNPROCESSED'){
                    $bpm->status = 'ON PROCESS';
                    $bpm->started_at = now();
                    $bpm->update();
                }      
                DB::commit();
                return response()->json([
                'status' => 'success',
                'message' => 'Outbound created successfully',                
                ]);               
           
          
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ],500);
         }       
    }

    public function bpmDone(Request $request){
        try {
            $bpm = sap_t_bpm::with('details')->findOrFail($request->id);
           
            $reserv = $bpm->details->first()->reservation_number;
            $storeloc = $bpm->storage_location_code;

            $api_url = env('SAP_API_URL','google.com').'/bpm/transfer-posting-bpm/'.$reserv.'/'.$storeloc;
            
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);

            $response = $client->get($api_url,[]);
            $status = $response->getBody()->getContents();
            $json_response = json_decode($status);

            if($json_response->status_code == 200){
                $bpm->status = 'PROCESSED';
                $bpm->finished_at = now();
                $bpm->update();
                $notifikasi = Notifikasi::create([
                    'title' => 'BPM Document Finished',
                    'body'  => 'Hello, BPM is finished with document number :'.$bpm->doc_number
                ]);                             
                $notifikasi->user()->attach(User::all()->pluck('id'),['status'=> 'unread','created_at'=>now(),'updated_at'=>now()]);
            }                                  
           
                $request['title'] = $notifikasi->title;
                $request['body'] = $notifikasi->body;                               

                $notif = (new NotifikasiController)->notification($request); 
                
            return response()->json([
                'status' => 'success',
                'message' => 'BPM Sudah Selesai',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ],500);
        }     
    }


    public function bpmDestination(Request $request){
        $request->validate([
            'id' => 'required|exists:sap_t_bpms,id',            
            'destination' => 'required|exists:sap_m_storage_locations,storage_location_code',                       
        ]);
        $bpm = sap_t_bpm::find($request->id)->update(['storage_location_code'=>$request->destination]);
        $bpm_dtl = sap_t_bpm_dtl::where('bpm_id',$request->id)->update(['storage_location_code'=>$request->destination]);
        $outbound = t_outbound::where('bpm_id',$request->id)->update(['storloc_code'=>$request->destination]);

        return response()->json(['status'=>'success','message'=>'Set Destination Success']);
    }


    public function makeDoc(){

    }
}
