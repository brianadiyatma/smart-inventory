<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_uoms;

class GetMasterUom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-uom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Material from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-uom';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $uoms = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($uoms as $key => $data) {
            
            $uom = sap_m_uoms::where('uom_code', $data->uom_code)->first();

            if(is_null($uom)){
                $uom = sap_m_uoms::create([
                    'uom_code' => $data->uom_code,
                    'uom_name' => $data->uom_name
                ]);

                echo $uom->uom_code .'-'. $uom->uom_name . '--> CREATED'.PHP_EOL;
            }else{
                $uom->update([
                    'uom_code' => $data->uom_code,
                    'uom_name' => $data->uom_name
                ]);

                echo $uom->uom_code .'-'. $uom->uom_name . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
