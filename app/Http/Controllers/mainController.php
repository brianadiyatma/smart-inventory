<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\sap_m_wbs;
use App\Models\sap_m_uoms;
use App\Models\User;
use App\Models\user_notifikasi;
use App\Models\t_inbound;
use App\Models\t_outbound;
use App\Models\t_stock;
use App\Models\sap_t_sttp;
use App\Models\sap_t_bpm;
use App\Models\sap_m_plant;
use App\Models\m_division;
use App\Models\m_position;
use App\Models\sap_m_storage_locations;
use App\Models\sap_m_storage_bin;
use App\Models\sap_m_materials;
use App\Models\sap_m_storage_type;
use App\Models\m_storage_level;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use File;
use DB;

class mainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function forgot()
    {
        return view('auth.passwords.reset');
    }

    public function index(Request $request)
    {

        //=======================================================================================
        //tanggal awal
        $tanggal_awal = date('Y-m-01');
        //2022-01-10
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();

        $sttpdayundone = array();
        $sttpdayonproses = array();
        $sttpdaydone = array();

        $bpmdayundone = array();
        $bpmdayonproses = array();
        $bpmdaydone = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total  = sap_t_sttp::where('doc_date', 'LIKE' , '%'.$tanggal_awal.'%')->where('status','UNPROCESSED')->count('id');
            $total1 = sap_t_sttp::where('doc_date', 'LIKE', '%'.$tanggal_awal.'%')->where('status','ON PROCESS')->count('id');
            $total2 = sap_t_sttp::where('doc_date', 'LIKE', '%'.$tanggal_awal.'%')->where('status','PROCESSED')->count('id');

            $sttpdayundone[] += $total;
            $sttpdayonproses[] += $total1;
            $sttpdaydone[] += $total2;

            $total3  = sap_t_bpm::where('doc_date', 'LIKE' , '%'.$tanggal_awal.'%')->where('status','UNPROCESSED')->count('id');
            $total4 = sap_t_bpm::where('doc_date', 'LIKE', '%'.$tanggal_awal.'%')->where('status','ON PROCESS')->count('id');
            $total5 = sap_t_bpm::where('doc_date', 'LIKE', '%'.$tanggal_awal.'%')->where('status','PROCESSED')->count('id');

            $bpmdayundone[] += $total3;
            $bpmdayonproses[] += $total4;
            $bpmdaydone[] += $total5;


            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        //=======================================================================================
        //=======================================================================================

        //bulan awal
        $bulan_awal = date('Y-01');
        // dd($bulan_awal);
        //2022-10-17
        $bulan_akhir = date('Y-12');

        $data_bulan = array();

        $sttpmonthundone = array();
        $sttpmonthonproses = array();
        $sttpmonthdone = array();

        $bpmmonthundone = array();
        $bpmmonthonproses = array();
        $bpmmonthdone = array();

        while (strtotime($bulan_awal) <= strtotime($bulan_akhir)) {
            $data_bulan[] = (int) substr($bulan_awal, 5, 2);

            $a1  = sap_t_sttp::where('doc_date', 'LIKE' , '%'.$bulan_awal.'%')->where('status','UNPROCESSED')->count('id');
            $b1 = sap_t_sttp::where('doc_date', 'LIKE', '%'.$bulan_awal.'%')->where('status','ON PROCESS')->count('id');
            $c1 = sap_t_sttp::where('doc_date', 'LIKE', '%'.$bulan_awal.'%')->where('status','PROCESSED')->count('id');
            
            $sttpmonthundone[] += $a1;
            $sttpmonthonproses[] += $b1;
            $sttpmonthdone[] += $c1;

            $aa1  = sap_t_bpm::where('doc_date', 'LIKE' , '%'.$bulan_awal.'%')->where('status','UNPROCESSED')->count('id');
            $bb1 = sap_t_bpm::where('doc_date', 'LIKE', '%'.$bulan_awal.'%')->where('status','ON PROCESS')->count('id');
            $cc1 = sap_t_bpm::where('doc_date', 'LIKE', '%'.$bulan_awal.'%')->where('status','PROCESSED')->count('id');
            
            $bpmmonthundone[] += $aa1;
            $bpmmonthonproses[] += $bb1;
            $bpmmonthdone[] += $cc1;

            $bulan_awal = date('Y-m', strtotime("+1 month", strtotime($bulan_awal)));
        }

        $bulan_awal = date('Y-01');

        //=======================================================================================
        //=======================================================================================

        //tahun awal
        $tahun_awal = date('Y-m-d', strtotime("-5 years"));
        // dd($tahun_awal);
        //2022-10-17
        $tahun_akhir = date('Y-m-d');

        $data_tahun = array();

        $sttpyearundone = array();
        $sttpyearonproses = array();
        $sttpyeardone = array();

        $bpmyearundone = array();
        $bpmyearonproses = array();
        $bpmyeardone = array();

        while (strtotime($tahun_awal) <= strtotime($tahun_akhir)) {
            $data_tahun[] = (int) substr($tahun_awal, 0, 4);
            $slicingdatetahun = (int) substr($tahun_awal, 0, 4);
            // dd((int) substr($tahun_awal, 0, 4));

            $a  = sap_t_sttp::where('doc_date', 'LIKE' , '%'.$slicingdatetahun.'%')->where('status','UNPROCESSED')->count('id');
            $b = sap_t_sttp::where('doc_date', 'LIKE', '%'.$slicingdatetahun.'%')->where('status','ON PROCESS')->count('id');
            $c = sap_t_sttp::where('doc_date', 'LIKE', '%'.$slicingdatetahun.'%')->where('status','PROCESSED')->count('id');
            
            $sttpyearundone[] += $a;
            $sttpyearonproses[] += $b;
            $sttpyeardone[] += $c;

            $aa  = sap_t_bpm::where('doc_date', 'LIKE' , '%'.$slicingdatetahun.'%')->where('status','UNPROCESSED')->count('id');
            $bb = sap_t_bpm::where('doc_date', 'LIKE', '%'.$slicingdatetahun.'%')->where('status','ON PROCESS')->count('id');
            $cc = sap_t_bpm::where('doc_date', 'LIKE', '%'.$slicingdatetahun.'%')->where('status','PROCESSED')->count('id');
            
            $bpmyearundone[] += $aa;
            $bpmyearonproses[] += $bb;
            $bpmyeardone[] += $cc;


            $tahun_awal = date('Y-m-d', strtotime("+1 year", strtotime($tahun_awal)));
        }

        $tahun_awal = date('Y-m-d', strtotime("-5 years"));

        $sttpcountundone    = sap_t_sttp::where('status','UNPROCESSED')->count('id');
        $sttpcountonproses  = sap_t_sttp::where('status','ON PROCESS')->count('id');
        $sttpcountdone      = sap_t_sttp::where('status','PROCESSED')->count('id');

        $bpmcountundone    = sap_t_bpm::where('status','UNPROCESSED')->count('id');
        $bpmcountonproses  = sap_t_bpm::where('status','ON PROCESS')->count('id');
        $bpmcountdone      = sap_t_bpm::where('status','PROCESSED')->count('id');

        $current_date_day   = date('Y-m-d');
        $current_date_month = date('Y-m');
        $current_date_year  = date('Y');

        $userperformanceday = t_inbound::join('sap_t_sttps','sttp_id','=','sap_t_sttps.id')
                                    ->join('users','user_id','=','users.id')
                                    ->select(
                                        'nip',
                                        'enter_date',
                                        'posting_date',
                                        DB::RAW("AVG(TIME_TO_SEC(posting_date) - TIME_TO_SEC(enter_date)) as Labor")
                                    )
                                    ->where('posting_date','LIKE','%'.$current_date_day.'%')
                                    ->GroupBy('user_id')
                                    ->get();

        $userperformancemonth = t_inbound::join('sap_t_sttps','sttp_id','=','sap_t_sttps.id')
                                    ->join('users','user_id','=','users.id')
                                    ->select(
                                        'nip',
                                        'enter_date',
                                        'posting_date',
                                        DB::RAW("AVG(TIME_TO_SEC(posting_date) - TIME_TO_SEC(enter_date)) as Labor")
                                    )
                                    ->where('posting_date','LIKE','%'.$current_date_month.'%')
                                    ->GroupBy('user_id')
                                    ->get();

        $userperformanceyear = t_inbound::join('sap_t_sttps','sttp_id','=','sap_t_sttps.id')
                                    ->join('users','user_id','=','users.id')
                                    ->select(
                                        'nip',
                                        'enter_date',
                                        'posting_date',
                                        DB::RAW("AVG(TIME_TO_SEC(posting_date) - TIME_TO_SEC(enter_date)) as Labor")
                                    )
                                    ->where('posting_date','LIKE','%'.$current_date_year.'%')
                                    ->GroupBy('user_id')
                                    ->get();

        // echo $userperformance;

        return view('index', [
            'sttpcountundone'   => $sttpcountundone,
            'sttpcountonproses' => $sttpcountonproses,
            'sttpcountdone'     => $sttpcountdone,

            'bpmcountundone'   => $bpmcountundone,
            'bpmcountonproses' => $bpmcountonproses,
            'bpmcountdone'     => $bpmcountdone,

            'userperformanceday'    => $userperformanceday,
            'userperformancemonth'  => $userperformancemonth,
            'userperformanceyear'   => $userperformanceyear,

            'data_tanggal'      => $data_tanggal,
            'data_bulan'        => $data_bulan,
            'data_tahun'        => $data_tahun,

            'sttpdayundone'     => $sttpdayundone,
            'sttpdayonproses'   => $sttpdayonproses,
            'sttpdaydone'       => $sttpdaydone,
            'bpmdayundone'      => $bpmdayundone,
            'bpmdayonproses'    => $bpmdayonproses,
            'bpmdaydone'        => $bpmdaydone,

            'sttpmonthundone'     => $sttpmonthundone,
            'sttpmonthonproses'   => $sttpmonthonproses,
            'sttpmonthdone'       => $sttpmonthdone,
            'bpmmonthundone'      => $bpmmonthundone,
            'bpmmonthonproses'    => $bpmmonthonproses,
            'bpmmonthdone'        => $bpmmonthdone,

            'sttpyearundone'     => $sttpyearundone,
            'sttpyearonproses'   => $sttpyearonproses,
            'sttpyeardone'       => $sttpyeardone,
            'bpmyearundone'      => $bpmyearundone,
            'bpmyearonproses'    => $bpmyearonproses,
            'bpmyeardone'        => $bpmyeardone,

            'title' => "Dashboard"
        ]);
    }

    public function qr(request $request)
    {
        $qr = $request->qr;
        $dir = Storage::disk('local');

        $png = QrCode::size('200')->generate($qr);

        return $png.'<br>'.$qr;
    }

    public function test()
    {
        $data = sap_m_materials::all();
 
        return DataTables::of($data)->make(true);
    }

    public function fetchData(Request $request){
        $data = sap_m_materials::select('sap_m_materials.*');
        $output = array();
        if($request->has('draw')){        
            $draw = $request['draw'];
            $output['draw'] = $draw;
        }

        if($request->has('length')){        
            $length = $request['length'];
            $output['length'] = $length;
        }

        if($request->has('start')){        
            $start = $request['start'];
            $output['start'] = $start;
        }

        if($request->has('search')){        
            $search = $request['search']['value'];
        }

        $total = count(sap_m_materials::all());

        $output['recordsTotal'] = $output['recordsFiltered'] = $total;


        $output['data'] = array();

        if($search !=''){
            $data = $data->where('material_code','like','%'.$search.'%');
            $jumlah = $data->get();
            $output['recordsTotal'] = $output['recordsFiltered'] = count($jumlah);
        }

        $data = $data->offset($start)->limit($length)->get();

        foreach ($data as $key => $value) {
            $output['data'][] = $value;
        }

        return json_encode($output);
    }

}
