<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sap_t_sttp;
use App\Models\sap_t_sttp_dtl;
use App\Models\sap_t_bpm;
use App\Models\sap_t_bpm_dtl;
use App\Models\sap_t_gi;
use App\Models\sap_t_gi_dtl;

class transaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("transaksi",[
            'sttp' => sap_t_sttp::withCount('details')->orderBy('doc_date','DESC')->get(),
            'bpm'  => sap_t_bpm::withCount('details')->orderBy('doc_date','DESC')->get(),
            'gi'   => sap_t_gi_dtl::join('sap_t_gis','gi_id','=','sap_t_gis.id')->orderBy('doc_date','DESC')->get(),
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
        return view("sttpdetail",[
            'sttp' => sap_t_sttp_dtl::where('sttp_id',$id)->get(),
            'id' => $id,
            'title' => "Transaction Detail STTP"
        ]);   
    }
    public function bpmdetail($id)
    {
        return view("bpmdetail",[
            'bpm'  => sap_t_bpm_dtl::where('bpm_id',$id)->get(),
            'id' => $id,
            'title' => "Transaction Detail BPM"
        ]);
    }
    public function gidetail($id)
    {
        return view("gidetail",[
            'gi'   => sap_t_gi_dtl::where('id',$id)->get(),
            'id' => $id,
            'title' => "Transaction Detail BPRM"
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
