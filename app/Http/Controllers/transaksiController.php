<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sap_t_sttp;
use App\Models\sap_t_sttp_dtl;
use App\Models\sap_t_bpm;
use App\Models\sap_t_bpm_dtl;
use App\Models\sap_t_gi;
use App\Models\sap_t_gi_dtl;
use App\Models\sap_m_materials;
use App\Models\sap_m_project;
use App\Models\sap_m_wbs;
use App\Models\sap_m_uoms;
use Faker\Generator;
use Carbon\Carbon;
use Auth;

class transaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("transaksi", [
            'sttp' => sap_t_sttp::withCount('details')->orderBy('doc_date', 'DESC')->get(),
            'bpm'  => sap_t_bpm::withCount('details')->orderBy('doc_date', 'DESC')->get(),
            'gi'   => sap_t_gi_dtl::join('sap_t_gis', 'gi_id', '=', 'sap_t_gis.id')->orderBy('doc_date', 'DESC')->get(),
            'title' => "Transaction"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sttpdetail($id)
    {
        return view("sttpdetail", [
            'sttp' => sap_t_sttp_dtl::where('sttp_id', $id)->get(),
            'id' => $id,
            'title' => "Transaction Detail STTP"
        ]);
    }
    public function bpmdetail($id)
    {
        return view("bpmdetail", [
            'bpm'  => sap_t_bpm_dtl::where('bpm_id', $id)->get(),
            'id' => $id,
            'title' => "Transaction Detail BPM"
        ]);
    }
    public function gidetail($id)
    {
        return view("gidetail", [
            'gi'   => sap_t_gi_dtl::where('id', $id)->get(),
            'id' => $id,
            'title' => "Transaction Detail BPRM"
        ]);
    }

    public function newtransaksi()
    {
        return view("newtrans", [
            'title' => "New Transaction",
            'data_material' => sap_m_materials::all(),
            'data_project' => sap_m_project::all(),
            'data_wbs' => sap_m_wbs::all(),
            'data_UOM' => sap_m_uoms::all(),

        ]);
    }

    public function newtransaksiprocess() {
        $request = request();
        
        $sttp = new sap_t_sttp;
        $sttp->pembuat = Auth::user()->name;
        //generate random number but not in database
        $sttp->doc_number = "STTP-".rand(100000, 999999);
        $sttp->doc_date = Carbon::now();
        $sttp->po_number = "PO-".rand(100000, 999999);
        $sttp->project_code = $request->project;
        $sttp->status = "UNPROCESSED";
        $sttp->fiscal_year = Carbon::now()->format('Y');
        $sttp->enter_date = Carbon::now();
        // $sttp->started_at = Carbon::now();
        $sttp->save();
        

        foreach($request->items as $item) {
            $sttp_dtl = new sap_t_sttp_dtl;
            $sttp_dtl->sttp_id = $sttp->id;
            $sttp_dtl->wbs_code = $item['wbs_code'];
            $sttp_dtl->material_code = $item['material_code'];
            $sttp_dtl->material_desc = \App\Models\sap_m_materials::where('material_code', $item['material_code'])->first()->material_desc;
            $sttp_dtl->line_item = "Line-".rand(100000, 999999);
            $sttp_dtl->uom = $item['uom'];
            $sttp_dtl->qty_po = $item['qtypo'];
            $sttp_dtl->qty_gr_105 = $item['qtylppb'];
            $sttp_dtl->qty_ncr = $item['qtyncr'];
            $sttp_dtl -> qty_warehouse = 0;
            $sttp_dtl->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $request->items
        ]);
    }

    public function createSTTP()
    {
        return view("newsttp", [
            'title' => "New STTP"
        ]);
    }

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
        //
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
}
