<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_t_bpm;
use App\Models\sap_t_bpm_dtl;
use App\Models\sap_m_materials;
use App\Models\sap_m_wbs;

use Carbon\Carbon;

class GetBpm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-bpm {--dateFrom=}{--dateTo=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get BPM data transaction from SAP';

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
        // $dt_from = '2020-09-10';
        // $dt_to = '2020-09-20';

        if($dt_from && $dt_to){
            $from = Carbon::parse($dt_from)->toDateString();
            $to = Carbon::parse($dt_to)->toDateString();
        }else{
            $from = Carbon::today()->toDateString(); 
            $to = Carbon::today()->toDateString();   
        }

        $api_url = env('SAP_API_URL','google.com').'/bpm/data-bpm/'.$from.'/'.$to;

        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);

        $bpm_headers = $json_response->bpm_headers;
        $bpm_details = $json_response->bpm_details;
        
        $this->createBpmHeader($bpm_headers);
        $this->createBpmDetails($bpm_details, $bpm_headers);
    }

    public function createBpmHeader($bpm_headers){
        echo '******************************' . PHP_EOL;
        echo 'Downloading BPM HEADERS DATA' .PHP_EOL;
        echo '******************************' . PHP_EOL;

        foreach($bpm_headers as $hdr){
            $bpm_header = sap_t_bpm::where('doc_number', $hdr->DocNumber)
            ->where('doc_date',$hdr->DocDate)
            ->first();

            $fiscal_year = Carbon::parse($hdr->DocDate)->format('Y');
            
            if(!$bpm_header){
                $bpm_header = sap_t_bpm::create([
                    'pembuat' => $hdr->RequestedBy,
                    'doc_number' => $hdr->DocNumber,
                    'doc_date' => $hdr->DocDate,
                    'status' => 'UNPROCESSED',
                    'fiscal_year' => $fiscal_year,
                    'storage_location_code' => $hdr->StorageLocation,
                    // 'enter_date' => $hdr->BaseDate
                ]);

                echo $bpm_header->doc_number .'-->'. 'CREATED'.PHP_EOL;
            }
            // else{
                // $bpm_header->update([
                //     'pembuat' => $hdr->RequestedBy,
                //     'doc_number' => $hdr->DocNumber,
                //     'doc_date' => $hdr->DocDate,
                //     'status' => 'UNPROCESSED',
                //     'fiscal_year' => $fiscal_year,
                //     'storage_location_code' => $hdr->StorageLocation,
                //     // 'enter_date' => $hdr->BaseDate
                // ]);            
                
                // echo $bpm_header->doc_number .'-->'. 'UPDATED'.PHP_EOL;
            // }
        }
    }

    public function createBpmDetails($bpm_details, $bpm_headers){
        echo '******************************' . PHP_EOL;
        echo 'Downloading BPM DETAILS DATA' .PHP_EOL;
        echo '******************************' . PHP_EOL;
        // dd($bpm_headers);
        // dd($bpm_details);
        foreach($bpm_details as $dtl){
            $hdr = sap_t_bpm::where('doc_number', $dtl->ReservationNumber)
                ->first();
            
            $bpm_dtl = sap_t_bpm_dtl::where('bpm_id', $hdr->id)
                ->where('item',$dtl->Item)
                ->first();
             
            $material = sap_m_materials::with('type','group','Rbun')
                ->where('material_code',$dtl->MaterialCode)->first();
            
            $wbs = sap_m_wbs::with('project')->where('wbs_code', $dtl->WbsCode)->first();
            
            if(is_null($wbs)){
                $wbs = collect($bpm_headers)->where('DocNumber', $dtl->ReservationNumber)->first();
                $wbs = $wbs->WbsCode;
            }else{
                $wbs = $wbs->wbs_code;
            }

            if(!$bpm_dtl){
                $bpm_dtl = sap_t_bpm_dtl::create([
                    'bpm_id'=> $hdr->id,
                    'reservation_number' => $dtl->ReservationNumber,
                    'item' => $dtl->Item,
                    'wbs_code' => $wbs,
                    'material_code'=> $dtl->MaterialCode,
                    // 'material_desc' => $material->material_desc,
                    'plant_code'=> $dtl->PlantCode,
                    'requirement_date' => $dtl->RequirementDate,
                    'requirement_qty' => $dtl->RequirementQty,
                    'uom_code' => $material->Rbun->uom_code,
                    'note' => $dtl->Note,
                    'storage_location_code' => $dtl->StorageLocation
                ]);

                echo 'BPM HDR : '. $hdr->doc_number .'-->'. 'UPDATED'.PHP_EOL;
                echo 'BPM DTL : '.$bpm_dtl->line_item .'-->'. 'CREATED'.PHP_EOL;
                
            }
            // else{
                    
                // $bpm_dtl->update([
                //     'bpm_id'=> $hdr->id,
                //     'reservation_number' => $dtl->ReservationNumber,
                //     'line_item' => $dtl->Item,
                //     'wbs_code' => $wbs,
                //     'material_code'=> $dtl->MaterialCode,
                //     // 'material_desc' => $material->material_desc,
                //     'plant_code'=> $dtl->PlantCode,
                //     'requirement_date' => $dtl->RequirementDate,
                //     'requirement_qty' => $dtl->RequirementQty,
                //     'uom_code' => $material->Rbun->uom_code,
                //     'note' => $dtl->Note,
                //     'storage_location_code' => $dtl->StorageLocation
                // ]);

                // echo 'BPM HDR : '. $hdr->doc_number .'-->'. 'UPDATED'.PHP_EOL;
                // echo 'BPM DTL : '.$bpm_dtl->line_item .'-->'. 'UPDATED'.PHP_EOL;

            // }
        }
    }
}
