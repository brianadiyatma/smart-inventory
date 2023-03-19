<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_stock;
use App\Models\sap_m_plant;
use App\Models\sap_m_storage_bin;
use App\Models\sap_m_storage_type;
use App\Models\sap_m_storage_locations;
use Yajra\DataTables\DataTables;

class layoutpenyimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('layoutpenyimpanan',[
            'data' => t_stock::where('plant_code',$id)->get(),
            'title' => "Layout and Storage"
        ]);
    }

    public function pivot()
    {
        return view('pivot',[
            'data'          => sap_m_storage_bin::all(),
            'data_plant'    => sap_m_plant::all(),
            'data_location' => sap_m_storage_locations::all(),
            'data_type'     => sap_m_storage_type::all(),
            'title' => "Bin Management"
        ]);
    }

    public function getBin(Request $request)
    {
        if ($request->ajax()) {
            $data = sap_m_storage_bin::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<button class="qrcode btn btn-outline-secondary" data-qr="{{ $item->plant_code }}/{{ $item->storage_loc_code }}/{{ $item->storage_type_code }}/{{ $item->storage_bin_code }}" data-toggle="modal" data-target="#modal-default">Generate QR</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    // "'.$row->plant_code.$row->storage_loc_code.$row->storage_type_code.$row->storage_bin_code.'"

    public function addpivot(request $request)    
    {
        $request->validate([
            'bin'=>'required|max:255',
            'plant'=>'required|exists:sap_m_plants,plant_code',
            'loc'=>'required|exists:sap_m_storage_locations,storage_location_code',
            'type'=>'required|exists:sap_m_storage_types,storage_type_code'
        ]);
        
        $pivot = sap_m_storage_bin::updateOrCreate(
            [
                'storage_bin_code'      =>  request('bin'),
                'storage_type_code'     =>  request('type'),
                'storage_loc_code'      =>  request('loc'),
                'plant_code'            =>  request('plant')
            ],
            [
                'storage_bin_name'      =>  request('bin'),
                'storage_bin_code'      =>  request('bin'),
                'storage_type_code'     =>  request('type'),
                'storage_loc_code'      =>  request('loc'),
                'plant_code'            =>  request('plant')
            ]
        );

        return redirect('/pivot')->with("status", "Data berhasil diinput");
    }

    public function plant()
    {
        return view('plant', [
            'data' => sap_m_plant::all(),
            'title' => 'Plant'
        ]);        
    }

    public function storloc()
    {
        return view('storloc', [
            'storloc' => sap_m_storage_locations::all(),
            'title' => 'Storage Location'
        ]);        
    }

    public function type()
    {
        return view('stortype', [
            'stortype' => sap_m_storage_type::all(),
            'title' => 'Storage Type'
        ]);        
    }
}
