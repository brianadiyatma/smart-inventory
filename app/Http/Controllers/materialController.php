<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sap_m_plant;
use App\Models\sap_m_storage_bin;
use App\Models\sap_m_storage_type;
use App\Models\sap_m_storage_locations;
use App\Models\sap_m_materials;
use App\Models\sap_m_material_groups;
use App\Models\t_inbound;
use App\Models\t_outbound;
use App\Models\t_movement;
use App\Models\sap_m_material_type;
use App\Models\t_stock;
use File;
use DB;
// use Yajra\DataTables\DataTables;
use DataTables;

class materialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $aa = t_stock::join('sap_m_plants','plant_code','=','sap_m_plants.plant_code')->get();
        $a = t_stock::all();
        // $data = DataTables::of($a)->addIndexColumn()->toJson();

        return view('materialstock',[
            'title' => "Material Stock",
            'data' => t_stock::all()
        ]);
    }

    public function getFileTransaction($namafile)
    {
        $path  = storage_path('app/inbound/'.$namafile);
        $path1  = storage_path('app/outbound/'.$namafile);
        $path2  = public_path('corrupt.png');


        if (file_exists($path)) {
        $type  = File::mimeType($path);
        $file = File::get($path);
        return 'data:image/'.$type.';base64,'.base64_encode($file).'';
        }
        
        elseif(file_exists($path1)) {
        $type1  = File::mimeType($path1);
        $file1 = File::get($path1);
        return 'data:image/'.$type1.';base64,'.base64_encode($file1).'';
        }

        else{
        $type2  = File::mimeType($path2);
        $file2 = File::get($path2);
        return 'data:image/'.$type2.';base64,'.base64_encode($file2).'';
        }
    }

    public function detail($id)
    {
        $matcod = t_stock::where('id',$id)->first();
        $bpms = t_outbound::join('sap_t_bpms','bpm_id','=','sap_t_bpms.id')->select([DB::RAW('qty_out as qty') ,'doc_number','posting_date','photo_url' ,DB::RAW("'Outbound' as `type`")])->where('material_code',$matcod->material_code);
        $sttp = t_inbound::join('sap_t_sttps','sttp_id','=','sap_t_sttps.id')->select([DB::RAW('qty_in as qty'),'doc_number','posting_date','photo_url',DB::RAW("'Inbound' as `type`")])->where('material_code',$matcod->material_code);
        
        $unitrans = $bpms
                ->union($sttp)
                ->orderBy('posting_date','DESC')
                ->get();
                // echo $unitrans;
        foreach ($unitrans as $pict) {
            
        if ($pict->photo_url == NULL) {
            $pict->foto = '';
        }
        else{
            $pict->foto = $this->getFileTransaction($pict->photo_url);
        }
        }



        return view('material_dtl',[
            'title' => "Detail Material",
            'data' => t_stock::where('id',$id)->get(),
            'dtltbl' => $unitrans,
            'id' => $id
        ]);
    }

    public function preview(request $request)
    {
        $data = $request->foto;
        return view('transationimage',[
            'image' => $data
        ]);
    }

    public function material()
    {
        $data = DB::table('sap_m_materials')->paginate(10);
        $title = "Material";
        return view('material', compact('data','title'));
    }

    function fetch_data(Request $request)
    {
         if($request->ajax())
         {
          $data = sap_m_materials::query();
          return Datatables::of('sap_m_materials')->make();
         }
        return view('material_data');
    }

    public function group()
    {
        return view('materialgroup',[
            'title' => "Material Group",
            'data' => sap_m_material_groups::all()
        ]);
    }

    public function type()
    {
        return view('materialtype',[
            'title' => "Material Type",
            'data' => sap_m_material_type::all()
        ]);
    }

    public function move()
    {
        return view('materialmove',[
            'title' => "Move Material",
            'data' => t_stock::all()
        ]);
    }

    public function moved($id)
    {
        $data = t_stock::where('id',$id)->get();
        
        return view('materialmoved',[
            'title' => "Move Material",
            'data' => $data,
            'material_code' => $data->first()->material_code,
            'bin_code' => $data->first()->bin_code,
            'data_plant'    => sap_m_plant::all(),
            'data_bin'    => sap_m_storage_bin::all(),
            'data_location' => sap_m_storage_locations::all(),
            'data_type'     => sap_m_storage_type::all(),
            'movement' => t_movement::where('material_code',$data->first()->material_code)->get(),
        ]);
    }

    public function movedprocess(request $request)
    {
        $stock = t_stock::where('id',$request->id)->get();
        $stockqty = $stock->first()->qty;
        // echo $stockqtyupdated;
        $request->validate([
            'qty'=>"required|lte:$stockqty",
        ]);

        $move = t_movement::create([
            'movement_number'       => '1',
            'material_code'         => $stock->first()->material_code,
            'plant_code'            => $stock->first()->plant_code,
            'storloc_code'          => $stock->first()->storloc_code,
            'special_stock'         => $stock->first()->special_stock,
            'special_stock_number'  => $stock->first()->special_stock_number,
            'qty'                   => request('qty'),
            'bin_origin_code'       => $stock->first()->bin_code,
            'bin_destination_code'  => request('bin'),
        ]);
        
        $stockupdate = t_stock::find($request->id);
        $stockupdate->qty = $stock->first()->qty - request('qty');
        $stockupdate->save();

        $stockqtyupdated = t_stock::where([
            ['material_code',$stock->first()->material_code],
            ['bin_code',$request->bin],
            ['special_stock_number',$stock->first()->special_stock_number]
        ])->get();
        
        if($stockqtyupdated == '[]'){
            $create = t_stock::create([
                'material_code'         => $stock->first()->material_code,
                'plant_code'            => $stock->first()->plant_code,
                'storloc_code'          => $stock->first()->storloc_code,
                'bin_code'              => request('bin'),
                'storage_type_code'     => $stock->first()->storage_type_code,
                'special_stock'         => $stock->first()->special_stock,
                'special_stock_number'  => $stock->first()->special_stock_number,
                'gr_date'               => $stock->first()->gr_date,
                'qty'                   => request('qty'),
            ]);
        }
        else{
            $stockupdate = t_stock::find($stockqtyupdated->first()->id);
            $stockupdate->qty = $stockqtyupdated->first()->qty + request('qty');
            $stockupdate->save();
        }


        return back();
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
