<?php

namespace App\Http\Controllers;

use App\Models\m_position;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\t_stock;
use App\Models\sap_t_sttp_dtl;
use App\Models\sap_t_sttp;
use App\Models\sap_t_bpm_dtl;
use App\Models\sap_t_bpm;
use App\Models\t_inbound;
use App\Models\t_outbound;
use App\Models\sap_t_gi_dtl;
use App\Models\sap_m_storage_bin;
use App\Models\sap_m_storage_locations;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use PDF;

class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bpms = sap_t_bpm::select(['doc_number', 'doc_date', 'status', 'pembuat', DB::RAW("'BPM' as `type`")]);
        $sttp = sap_t_sttp::select(['doc_number', 'doc_date', 'status', 'pembuat', DB::RAW("'STTP' as `type`")]);
        $unitrans = $bpms->union($sttp)->inRandomOrder()->limit(3)->get();

        $inbon  = t_inbound::join('sap_t_sttps', 'sttp_id', '=', 'sap_t_sttps.id')->select(['material_code', 'posting_date', 'pembuat', DB::RAW("'STTP' as `type`")]);
        $outbon = t_outbound::join('sap_t_bpms', 'bpm_id', '=', 'sap_t_bpms.id')->select(['material_code', 'posting_date', 'pembuat', DB::RAW("'BPM' as `type`")]);
        $uniinout = $inbon->union($outbon)->limit(3)->get();

        return view('report', [
            'title' => "Report",
            'stock' => t_stock::all(),
            'sttp' => sap_t_sttp_dtl::all(),
            'bpm' => sap_t_bpm_dtl::all(),
            'gi' => sap_t_gi_dtl::all(),
            'transaction' => $unitrans,
            'inout' => $uniinout
        ]);
    }

    public function report1()
    {
        $sttp = sap_t_sttp_dtl::join('sap_t_sttps', 'sttp_id', '=', 'sap_t_sttps.id')
            ->select([
                'doc_number',
                'doc_date',
                'pembuat',
                'status',
                'fiscal_year',
                'sap_t_sttps.started_at',
                'sap_t_sttps.finished_at',
                DB::RAW('line_item as line'),
                'wbs_code',
                'uom',
                DB::RAW('qty_po as qty'),
                DB::RAW('po_number as number'),
                'material_code', DB::RAW("'STTP' as `type`")
            ]);

        $bpm  = sap_t_bpm_dtl::join('sap_t_bpms', 'bpm_id', '=', 'sap_t_bpms.id')
            ->select([
                'doc_number',
                'doc_date',
                'pembuat',
                'status',
                'fiscal_year',
                'sap_t_bpms.started_at',
                'sap_t_bpms.finished_at',
                DB::RAW('item as line'),
                'wbs_code',
                'uom_code',
                DB::RAW('requirement_qty as qty'),
                DB::RAW('reservation_number as number'),
                'material_code',
                DB::RAW("'BPM' as `type`")
            ]);

        $union = $bpm->unionAll($sttp)->orderBy('doc_date', 'DESC')->get();
        // echo $union;
        return view('report1', [
            'title' => "Report STTP & BPM",
            'data' => $union
        ]);
    }

    public function report2()
    {
        $sttp = t_inbound::join('sap_t_sttps', 'sttp_id', '=', 'sap_t_sttps.id')
            ->join('users', 'user_id', '=', 'users.id')
            ->select([
                'doc_number',
                'doc_date',
                'pembuat',
                'status',
                'line_item',
                'wbs_code',
                'fiscal_year',
                'material_code',
                't_inbounds.plant_code',
                'storloc_code',
                'bin_code',
                'name',
                'sap_t_sttps.started_at',
                'sap_t_sttps.finished_at',
                DB::RAW('qty_in as qty'),
                DB::RAW("'Inbound' as `type`")
            ]);
        $bpms = t_outbound::join('sap_t_bpms', 'bpm_id', '=', 'sap_t_bpms.id')
            ->join('users', 'user_id', '=', 'users.id')
            ->select([
                'doc_number',
                'doc_date',
                'pembuat',
                'status',
                'line_item',
                'wbs_code',
                'fiscal_year',
                'material_code',
                't_outbounds.plant_code',
                'storloc_code',
                'bin_code',
                'name',
                'sap_t_bpms.started_at',
                'sap_t_bpms.finished_at',
                DB::RAW('qty_out as qty'),
                DB::RAW("'Outbound' as `type`")
            ]);

        $unitrans = $bpms->unionAll($sttp)->orderBy('doc_date', 'DESC')->get();
        // dd($unitrans);

        return view('report2', [
            'title' => "Report Inbound & Outbound",
            'data' => $unitrans
        ]);
    }

    public function generate()
    {
        $user = User::get();


        return view('generate', [
            'title' => "Report",
            'data' => $user
        ]);
    }

    public function generateReport(request $request)
    {
        $tanggal_input  = $request->date;
        $tanggal_input1 = $request->date1;
        $header_date    = strtoupper(date("F Y", strtotime($tanggal_input)));
        $header_date1   = strtoupper(date("F Y", strtotime($tanggal_input1)));
        $tanggal_awal   = date("d-m-Y", strtotime($request->date));
        $tanggal_awal1  = date("Y-m-d", strtotime($tanggal_input));
        $tanggal_akhir  = date("d-m-Y", strtotime($request->date1));
        $tanggal_akhir1 = date("Y-m-d", strtotime($tanggal_input1));
        $tanggal =  $tanggal_awal . ' - ' . $tanggal_akhir;
        // echo $tanggal;
        $pemeriksa = User::where('id', $request->pemeriksa)->first();
        $pengesah = User::where('id', $request->pengesah)->first();
        
        $jabatan_pemeriksa = m_position::where('id', $pemeriksa->position_code)->first();
        $jabatan_pengesah = m_position::where('id', $pengesah->position_code)->first();
        // dd($tanggal_awal1);
        // dd($tanggal_akhir);

        $whereMonth = substr($tanggal_input, 0, 7);
        // echo $whereMonth;

        $data = DB::SELECT("
            SELECT users.nip,
            users.name,
            COALESCE(inb.count_sttp,0) as count_sttp,
            COALESCE(inb.count_in_item,0) as count_in_item,
            COALESCE(inb.SUM,0) as sttp_sum,
            COALESCE(oub.count_bpm,0) as count_bpm,
            COALESCE(oub.count_out_item,0) as count_out_item,
            COALESCE(oub.SUM,0) as bpm_sum,
            ((COALESCE(inb.SUM,0) + COALESCE(oub.SUM,0))/(COALESCE(inb.count_in_item,0)+COALESCE(oub.count_out_item,0))) as average_hour
            FROM users
            INNER JOIN model_has_roles ON model_has_roles.model_id = users.id
            INNER JOIN roles ON model_has_roles.role_id = roles.id
            LEFT JOIN (
                SELECT t_inbounds.*,
                AVG(TIME_TO_SEC(t_inbounds.posting_date)-COALESCE(TIME_TO_SEC(sap_t_sttps.enter_date),sap_t_sttps.created_at)) as AVG,
                SUM(TIME_TO_SEC(t_inbounds.posting_date)-COALESCE(TIME_TO_SEC(sap_t_sttps.enter_date),sap_t_sttps.created_at)) as SUM,
                COUNT(DISTINCT sttp_id) as count_sttp,
                COUNT(line_item) as count_in_item
                FROM t_inbounds
                INNER JOIN sap_t_sttps
                ON sap_t_sttps.id = t_inbounds.sttp_id
                AND sap_t_sttps.status='PROCESSED'
                WHERE (t_inbounds.posting_date BETWEEN ? AND ?)
                GROUP BY user_id
            ) inb
                ON users.id = inb.user_id

            LEFT JOIN (
                SELECT t_outbounds.*,
                AVG(TIME_TO_SEC(t_outbounds.posting_date)-COALESCE(TIME_TO_SEC(sap_t_bpms.enter_date),sap_t_bpms.created_at)) as AVG,
                SUM(TIME_TO_SEC(t_outbounds.posting_date)-COALESCE(TIME_TO_SEC(sap_t_bpms.enter_date),sap_t_bpms.created_at)) as SUM,
                COUNT(DISTINCT bpm_id) as count_bpm,
                COUNT(line_item) as count_out_item
                FROM t_outbounds
                INNER JOIN sap_t_bpms
                ON sap_t_bpms.id = t_outbounds.bpm_id
                AND sap_t_bpms.status='PROCESSED'
                WHERE (t_outbounds.posting_date BETWEEN ? AND ?)
                GROUP BY user_id
            ) oub
                ON users.id = oub.user_id

            WHERE roles.name = 'Operator'
            GROUP BY users.id

            ", [$tanggal_awal1, $tanggal_akhir1, $tanggal_awal1, $tanggal_akhir1]);

        // dd($data);
        // echo $data;


        $sttp_count_doc = t_inbound::join('sap_t_sttps', 'sttp_id', '=', 'sap_t_sttps.id')
            ->where('sap_t_sttps.status', 'PROCESSED')
            ->whereBetween('posting_date', [$request->date, $request->date1])
            ->distinct('sttp_id')
            ->count('sttp_id');

        $sttp_count_line = t_inbound::join('sap_t_sttps', 'sttp_id', '=', 'sap_t_sttps.id')
            ->where('sap_t_sttps.status', 'PROCESSED')
            ->distinct('sttp_id', 'line_item')
            ->whereBetween('posting_date', [$request->date, $request->date1])
            ->count('line_item');

        $sttp_count_qty = t_inbound::join('sap_t_sttps', 'sttp_id', '=', 'sap_t_sttps.id')
            ->where('sap_t_sttps.status', 'PROCESSED')
            ->whereBetween('posting_date', [$request->date, $request->date1])
            ->sum('qty_in');

        $bpm_count_doc = t_outbound::join('sap_t_bpms', 'bpm_id', '=', 'sap_t_bpms.id')
            ->where('sap_t_bpms.status', 'PROCESSED')
            ->whereBetween('posting_date', [$request->date, $request->date1])
            ->distinct('bpm_id')
            ->count('bpm_id');

        $bpm_count_line = t_outbound::join('sap_t_bpms', 'bpm_id', '=', 'sap_t_bpms.id')
            ->where('sap_t_bpms.status', 'PROCESSED')
            ->distinct('bpm_id', 'line_item')
            ->whereBetween('posting_date', [$request->date, $request->date1])
            ->count('line_item');

        $bpm_count_qty = t_outbound::join('sap_t_bpms', 'bpm_id', '=', 'sap_t_bpms.id')
            ->where('sap_t_bpms.status', 'PROCESSED')
            ->whereBetween('posting_date', [$request->date, $request->date1])
            ->sum('qty_out');


        $pdf = PDF::loadview('generatedreport', [
            'title' => "Report",
            'sttp_count_doc'    => $sttp_count_doc,
            'sttp_count_line'   => $sttp_count_line,
            'sttp_count_qty'    => $sttp_count_qty,
            'bpm_count_doc'     => $bpm_count_doc,
            'bpm_count_line'    => $bpm_count_line,
            'bpm_count_qty'     => $bpm_count_qty,
            'data' => $data,
            'header_date'  => $header_date,
            'header_date1' => $header_date1,
            'tanggal' => $tanggal,
            'date1' => "01-3-2022",
            'date2' => "30-3-2022",
            'jabatan_pemeriksa' => $jabatan_pemeriksa->position_name,
            'nama_pemeriksa' => $pemeriksa->name,
            'jabatan_pengesah' => $jabatan_pengesah->position_name,
            'nama_pengesah' => $pengesah->name,
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('REPORT BULANAN PENGELOLAAN GUDANG PT INKA' . ' ' . $header_date);
    }
}
