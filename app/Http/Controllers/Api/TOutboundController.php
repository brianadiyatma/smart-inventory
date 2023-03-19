<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_stock;
use App\Models\t_outbound;
use App\Models\sap_t_bpm;
use App\Models\sap_t_bpm_dtl;
use App\Models\notifikasi;
use App\Http\Controllers\Api\NotifikasiController;
use DB;

class TOutboundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bpm_id' => 'required|exists:sap_t_bpms,id',
            'line_item' => 'required',
            'material_code' => 'required|exists:sap_m_materials,id',
            'plant_code' => 'required|exists:sap_m_plants,id',
            'storloc_code' => 'required|exists:sap_m_storage_locations,id',
            'bin_code' => 'required|exists:sap_m_storage_bins,id',
            'wbs_code' => 'required|exists:sap_m_wbs,id',
            'qty_out' => 'required',
        ]);
        DB::beginTransaction();
         try {
                $outbound = t_outbound::create([           
                    'bpm_id' => $request->bpm_id,
                    'line_item' => $request->line_item,
                    'material_code' => $request->material_code,
                    'plant_code' => $request->plant_code,
                    'storloc_code' => $request->storloc_code,
                    'bin_code' => $request->bin_code,
                    'wbs_code' => $request->wbs_code,
                    'qty_out' => $request->qty_out,
                    'posting_date' => now(),
                    'user_id' => auth('sanctum')->user()->id,
                ]);
                $stock = t_stock::where([
                    ['material_code' , $request->material_code], 
                    ['plant_code' , $request->plant_code],
                    ['storloc_code' , $request->storloc_code],
                    ['storage_type_code' , $request->storage_type_code],
                    ['bin_code' , $request->bin_code]])
                ->first();
                if(is_null($stock)) { 
                    return response()->json([
                        'status' => 'failed',
                        'message' => $e->getMessage(),
                    ],500);                  
                } else {                             
                    $stock->qty = $stock->qty - $request->qty_out;
                    $stock->gr_date = now();     
                    $stock->update();
                }
                $notifikasi = Notifikasi::create([
                    'title' => 'Transaksi Outbound Baru',
                    'body'  => 'Halo ada barang masuk baru nih dengan nomor BPM '.$outbound->bpm->doc_number
                ]);     
                $request['title'] = $notifikasi->title;
                $request['body'] = $notifikasi->body;
                $bpm = sap_t_bpm::with('details')->find($request->bpm_id);
                $outbound = t_outbound::where('bpm_id',$request->bpm_id)->get();
            
                $count = 0;
                $countStats = 0;
                foreach ($bpm->details as  $d) {                
                    foreach ($outbound as  $i) {
                        $d->material_code == $i->material_code ? $count+= $i->qty_out:'';
                    }
                    if($count == $d->qty_po){                
                        $d->status = 'Selesai';
                        $d->qty_outbound = $count;                    
                    }else if($count == 0){
                        $d->status ='Belum Proses';
                        $d->qty_outbound = $count;
                    }else{
                        $d->status ='Dalam Proses';
                        $d->qty_outbound = $count;
                    }                                    
                    $d->status == 'Selesai' ? $countStats++: '';
                }
                if($countStats == count($bpm->details)){
                    $bpm->status = 'Selesai';
                    $bpm->update();
                }else{
                    $bpm->status = 'Dalam proses';
                    $bpm->update();
                }

                DB::commit();

                $notif = (new NotifikasiController)->notification($request);  

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function bpm(){
        $bpm = sap_t_bpm::paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $bpm,
        ]); 
    }

    public function bpmDetail($id){
        $bpm = sap_t_bpm::with('details')->find($id);
        $outbound = t_outbound::where('bpm_id',$id)->get();
        if(is_null($bpm)){
            return response()->json([
                'status' => 'failed',
                'data' => null,
            ],500);
        }

        foreach ($bpm->details as  $d) {
            $count = 0;
            foreach ($outbound as  $i) {
                $d->material_code == $i->material_code ? $count+= $i->order_qty:'';
            }
            if($count == $d->order_qty){                
                $d->status = 'Selesai';
                $d->qty_outbound = $count;
            }else if($count == 0){
                $d->status ='Belum Proses';
                $d->qty_outbound = $count;
            }else{
                $d->status ='Dalam Proses';
                $d->qty_outbound = $count;
            }
            
        }
        return response()->json([
            'status' => 'success',
            'data' => $bpm,
        ]); 
    }

    public function bpmTransaksi(Request $request){            
        $detail = sap_t_bpm_dtl::where([['bpm_id',$request->id],['material_code',$request->code],['wbs_code',$request->wbs]])->first();
        if(is_null($detail)){
            return response()->json([
                'status' => 'failed',
                'message' => 'Data outbound not found',  
            ],500);
        }
        $outbound = t_outbound::where([['bpm_id',$request->id],['material_code',$request->code],['wbs_code',$request->code]])->sum('qty_out');
        $detail['qty_out'] = $outbound;
        // $detail['qty_left'] = $detail->order_qty-$outbound;
        $detail->order_qty-$outbound <= 0 ? $detail['qty_left'] = 0 : $detail['qty_left'] = $detail->order_qty-$outbound;
                   
        return response()->json([
            'status' => 'success',
            'data' => $detail,
        ]); 
    }
    
    public function bpmSelesai($id){
        try {
            $bpm = sap_t_bpm::findOrFail($id);
            $bpm->status = 'Selesai';
            $bpm->update();
            return response()->json([
                'status' => 'success',
                'message' => 'BPM Sudah Selesai',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
        
    }
}
