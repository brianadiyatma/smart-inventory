<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_wbs;
use App\Models\sap_t_sttp;
use App\Models\sap_t_sttp_dtl;
use App\Models\sap_m_materials;

use Carbon\Carbon;

class GetSttp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-sttp {--dateFrom=}{--dateTo=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get STTP data transaction from SAP ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dt_from = $this->option('dateFrom');
        $dt_to = $this->option('dateTo');

        if($dt_from && $dt_to){
            $from = Carbon::parse($dt_from)->toDateString();
            $to = Carbon::parse($dt_to)->toDateString();
        }else{
            $from = Carbon::today()->toDateString(); 
            $to = Carbon::today()->toDateString();   
        }

        $api_url = env('SAP_API_URL','google.com').'/sttp/data-sttp/'.$from.'/'.$to;

        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);

        $sttp_headers = $json_response->sttp_headers;
        $sttp_details = $json_response->sttp_details;
        
        $this->createSttpHeader($sttp_headers);
        $this->createSttpDetails($sttp_details);
        
    }


    public function createSttpHeader($sttp_headers){
        echo '******************************' . PHP_EOL;
        echo 'Downloading STTP HEADERS DATA' .PHP_EOL;
        echo '******************************' . PHP_EOL;

        foreach($sttp_headers as $hdr){
            $sttp_header = sap_t_sttp::where('doc_number', $hdr->DocNumber)
            ->where('fiscal_year',$hdr->DocYear)
            ->first();

            $enter_date = Carbon::parse($hdr->EntryDate . $hdr->EntryTime);

            if(!$sttp_header){
                $sttp_header = sap_t_sttp::create([
                    'pembuat' => $hdr->EntryName,
                    'doc_number' => $hdr->DocNumber,
                    'doc_date' => $hdr->DocDate,
                    // 'status' => $hdr->Status,
                    'status' => 'UNPROCESSED',
                    'fiscal_year' => $hdr->DocYear,
                    'enter_date' => $enter_date
                ]);

                echo $sttp_header->doc_number .'-->'. 'CREATED'.PHP_EOL;
            }else{
                $sttp_header->update([
                    'pembuat' => $hdr->EntryName,
                    'doc_number' => $hdr->DocNumber,
                    'doc_date' => $hdr->DocDate,
                    // 'status' => $hdr->Status,
                    'status' => 'UNPROCESSED',
                    'fiscal_year' => $hdr->DocYear,
                    'enter_date' => $enter_date
                ]);            
                
                echo $sttp_header->doc_number .'-->'. 'UPDATED'.PHP_EOL;
            }
        }
    }

    public function createSttpDetails($sttp_details){
        echo '******************************' . PHP_EOL;
        echo 'Downloading STTP HEADERS DATA' .PHP_EOL;
        echo '******************************' . PHP_EOL;
         
        foreach($sttp_details as $dtl){
            $hdr = sap_t_sttp::where('doc_number', $dtl->DocNumber)
                ->where('fiscal_year',$dtl->DocYear)->first();

            $sttp_dtl = sap_t_sttp_dtl::where('sttp_id', $hdr->id)
            ->where('line_item',$dtl->Item)
            ->first();
             
            $material = sap_m_materials::with('type','group')
                ->where('material_code',$dtl->MaterialCode)->first();

            $wbs = sap_m_wbs::with('project')->where('wbs_code', $dtl->WbsCode)->first();
            // dd($wbs, $dtl);
            
            if(!$sttp_dtl){
                $sttp_dtl = sap_t_sttp_dtl::create([
                    'sttp_id'=> $hdr->id,
                    'line_item' => $dtl->Item,
                    'wbs_code' => $dtl->WbsCode,
                    'material_code'=> $dtl->MaterialCode,
                    'material_desc' => $material->material_desc,
                    'uom' => $dtl->Uom,
                    'qty_po' => $dtl->QtyPo,
                    'qty_gr_105' => $dtl->QtyLppb
                ]);

                $hdr->update([
                    'po_number' => $dtl->PoNumber,
                    'project_code' => !is_null($wbs) ? $wbs->project->project_code : $dtl->WbsCode,
                ]);

                echo 'STTP HDR : '. $hdr->doc_number .'-->'. 'UPDATED'.PHP_EOL;
                echo 'STTP DTL : '.$sttp_dtl->line_item .'-->'. 'CREATED'.PHP_EOL;
                
            }else{
                    
                $sttp_dtl->update([
                    'sttp_id'=> $hdr->id,
                    'line_item' => $dtl->Item,
                    'wbs_code' => $dtl->WbsCode,
                    'material_code'=> $dtl->MaterialCode,
                    'material_desc' => $material->material_desc,
                    'uom' => $dtl->Uom,
                    'qty_po' => $dtl->QtyPo,
                    'qty_gr_105' => $dtl->QtyLppb
                ]);

                $hdr->update([
                    'po_number' => $dtl->PoNumber,
                    'project_code' => !is_null($wbs) ? $wbs->project->project_code : $dtl->WbsCode,
                ]);

                echo 'STTP HDR : '. $hdr->doc_number .'-->'. 'UPDATED'.PHP_EOL;
                echo 'STTP DTL : '.$sttp_dtl->line_item .'-->'. 'UPDATED'.PHP_EOL;

            }
        }
    }
}
