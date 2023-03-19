<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_inbound;
use App\Models\sap_t_sttp;
use App\Models\sap_t_sttp_dtl;
use App\Models\sap_m_storage_bin;
use App\Models\t_stock;
use App\Models\notifikasi;
use App\Http\Controllers\Api\NotifikasiController;
use DB;

class TInboundController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        // $inbound = t_inbound::latest()->paginate(5);
        // $inbound = t_inbound::select('*',DB::raw('"data" as Data') )->get();
        // $sttp = DB::table('sap_t_sttps')->select('doc_number','doc_date','status',DB::raw('"STTP" as dokumen'));
        // $bpm = DB::table('sap_t_bpms')->select('doc_number','doc_date','status',DB::raw('"STTP" as dokumen'))->union($sttp)->get();
        $inbound = t_inbound::all();
        return response()->json([
            'status' => 'success',
            'data' => $inbound,
        ]);
    }

    public function store(Request $request)
    {
        // $sttp_dtl = sap_t_sttp_dtl::with(['sttp','sttp.proyek'])->find($request->id);        
        $sttp_dtl = DB::table('sap_t_sttp_dtls')
        ->join('sap_t_sttps', 'sap_t_sttps.id', '=', 'sap_t_sttp_dtls.sttp_id')
        ->join('sap_m_projects', 'sap_t_sttps.project_code', '=', 'sap_m_projects.project_code')
        ->where('sap_t_sttp_dtls.id', '=', $request->id)
        ->first();      
        // $inbound = t_inbound::where([['sttp_id',$sttp_dtl->sttp_id],['material_code',$request->material_code]])->latest()->first();
        $inbound = DB::table('t_inbounds')->where([['sttp_id',$sttp_dtl->sttp_id],['material_code',$request->material_code]])->latest()->first();
        if(is_null($inbound)){
            $line_item = '0001';
        }else{
            $line_item = ++$inbound->line_item  ;
            $line_item = str_pad($line_item,4,"0",STR_PAD_LEFT);
        }         
        // $bin = sap_m_storage_bin::with(['plant','type','loc'])->find($request->bin_code);

        $bin = DB::table('sap_m_storage_bins')->select('*')
        ->join('sap_m_plants', 'sap_m_plants.plant_code', '=', 'sap_m_storage_bins.plant_id')
        ->join('sap_m_storage_types', 'sap_m_storage_types.storage_type_code', '=', 'sap_m_storage_bins.storage_type_id')
        ->join('sap_m_storage_locations', 'sap_m_storage_locations.id', '=', 'sap_m_storage_bins.storage_location_id')
        ->where('sap_m_storage_bins.id', '=', $request->bin_code)->first();        

        $request->validate([
            'id' => 'required|exists:sap_t_sttp_dtls,id',            
            'material_code' => 'required|exists:sap_m_materials,material_code',           
            'bin_code' => 'required|exists:sap_m_storage_bins,id',            
            'qty_in' => 'required',
        ]);
        
         try {
            DB::beginTransaction();
                $inbound = t_inbound::create([           
                    'sttp_id' => $sttp_dtl->sttp_id,
                    'line_item' => $line_item,
                    'material_code' => $request->material_code,
                    'plant_code' => $bin->plant_code,
                    'storloc_code' => $bin->storage_location_code,
                    'bin_code' => $bin->storage_bin_code,
                    'wbs_code' => $sttp_dtl->wbs_code,
                    'qty_in' => $request->qty_in,
                    'posting_date' => now(),
                    'user_id' => auth('sanctum')->user()->id,
                ]);    
                // $sttp_dtl->line_item = $line_item;                
                // $sttp_dtl->qty_warehouse = empty($sttp_dtl->qty_warehouse) ? $request->qty_in: $sttp_dtl->qty_warehouse+$request->qty_in;
                // $sttp_dtl->update();
                
                $stock = t_stock::where([
                    ['material_code' , $request->material_code], 
                    ['plant_code' , $bin->plant_code],
                    ['storloc_code' , $bin->storage_location_code],
                    ['storage_type_code' , $bin->storage_type_code],
                    ['bin_code' , $bin->storage_bin_code]])
                ->first();
                if(is_null($stock)) {
                    $stock = new t_stock([
                        'material_code' => $request->material_code,
                        'plant_code' => $bin->plant_code,
                        'storloc_code' =>$bin->storage_location_code,                    
                        'storage_type_code' => $bin->storage_type_code,  
                        'bin_code' => $bin->storage_bin_code,                  
                        'special_stock' => $sttp_dtl->wbs_code,
                        'special_stock_number' => $sttp_dtl->project_code,                   
                        'qty' =>  $request->qty_in,
                        'gr_date' => now(),          
                    ]);
                    $stock->save();
                } else {
                    $stock->plant_code =  $bin->plant_code;
                    $stock->storloc_code = $bin->storage_location_code;                    
                    $stock->storage_type_code = $bin->storage_type_code;  
                    $stock->bin_code = $bin->storage_bin_code;                  
                    $stock->special_stock = $sttp_dtl->wbs_code;
                    $stock->special_stock_number = $sttp_dtl->project_code;                   
                    $stock->qty = $stock->qty + $request->qty_in;
                    $stock->gr_date = now();     
                    $stock->update();
                }

                $notifikasi = Notifikasi::create([
                    'title' => 'Transaksi Inbound Baru',
                    'body'  => 'Halo ada barang masuk baru nih dengan nomor STTP '.$inbound->sttp->doc_number
                ]);     
                $request['title'] = $notifikasi->title;
                $request['body'] = $notifikasi->body;
               
                DB::commit();

                $notif = (new NotifikasiController)->notification($request); 

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

    public function show($id)
    {
        $inbound = t_inbound::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $inbound,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sttp_id' => 'required|exists:sap_t_sttps,id',
            'line_item' => 'required',
            'material_code' => 'required|exists:sap_m_materials,id',
            'plant_code' => 'required|exists:sap_m_plants,id',
            'storloc_code' => 'required|exists:sap_m_storage_locations,id',
            'bin_code' => 'required|exists:sap_m_storage_bins,id',
            'wbs_code' => 'required|exists:sap_m_wbs,id',
            'qty_in' => 'required',
        ]);

        $inbound = t_inbound::find($id);
        $inbound->sttp_id = $request->sttp_id;
        $inbound->line_item = $request->line_item;
        $inbound->material_code = $request->material_code;
        $inbound->plant_code = $request->plant_code;
        $inbound->storloc_code = $request->storloc_code;
        $inbound->bin_code = $request->bin_code;
        $inbound->wbs_code = $request->wbs_code;
        $inbound->qty_in = $request->qty_in;
        $inbound->posting_date = now();
        $inbound->user_id = auth('sanctum')->user()->id;
        $inbound->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Inbound updated successfully',
            'data' => $inbound,
        ]);
    }

    public function destroy($id)
    {

        try {
            $inbound = t_inbound::findOrFail($id);
            $inbound->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Inbound deleted successfully',
                'data' => $inbound,
            ]);
        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'failed',
                'message' => 'Data Inbound not found',             
            ],500);
        }
      
    }

    public function sttp(){
        $sttp = sap_t_sttp::paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $sttp,
        ]); 
    }

    public function sttpDetail($id){
        $sttp = sap_t_sttp::with('details')->findOrFail($id);
        $inbound = t_inbound::where('sttp_id',$id)->get();
        if(is_null($sttp)){
            return response()->json([
                'status' => 'failed',
                'data' => null,
            ],500);
        }

        foreach ($sttp->details as  $d) {
            $count = 0;
            foreach ($inbound as  $i) {
                $d->material_code == $i->material_code ? $count+= $i->qty_in:'';
            }
            if($count == $d->qty_po){                
                $d->status = 'Selesai';
                $d->qty_inbound = $count;
            }else if($count == 0){
                $d->status ='Belum Proses';
                $d->qty_inbound = $count;
            }else{
                $d->status ='Dalam Proses';
                $d->qty_inbound = $count;
            }
            
        }
        return response()->json([
            'status' => 'success',
            'data' => $sttp,
        ]); 
    }

    public function sttpTransaksi(Request $request){
        // $sttp = sap_t_sttp::where('id',$id)->with([
        // 'details'=> function($query) use ($id,$wbs,$code) {
        //     $query->where([                 
        //         ['material_code' , $code],
        //         // ['wbs_code' , $wbs],
        //     ]);
        // },
        // 'inbounds'=> function($query) use ($id,$wbs,$code) {
        //     $query->where([                 
        //         ['material_code' , $code],
        //         // ['wbs_code' , $wbs],
        //     ])->groupBy(['material_code','sttp_id']);
        // }])->get();        
        $detail = sap_t_sttp_dtl::where([['sttp_id',$request->id],['material_code',$request->code],['wbs_code',$request->wbs]])->first();
        if(is_null($detail)){
            return response()->json([
                'status' => 'failed',
                'data' => $detail,
            ],500);
        }
        $inbound = t_inbound::where([['sttp_id',$request->id],['material_code',$request->code],['wbs_code',$request->code]])->sum('qty_in');
        $detail['qty_in'] = $inbound;
        // $detail['qty_left'] = $detail->qty_po-$inbound;
        $detail->qty_po-$inbound < 0 ? $detail['qty_left'] = 0 : $detail['qty_left'] = $detail->qty_po-$inbound;
                   
        return response()->json([
            'status' => 'success',
            'data' => $detail,
        ]); 
    }
    
    public function sttpSelesai($id){
        try {
            $sttp = sap_t_sttp::findOrFail($id);
            $sttp->status = 'Selesai';
            $sttp->update();
            return response()->json([
                'status' => 'success',
                'message' => 'STTP Sudah Selesai',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
        
        
        
    }
}
