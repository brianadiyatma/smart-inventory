<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_wbs;

class GetMasterWbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-wbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Wbs from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-wbs';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $wbs_data = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($wbs_data as $key => $data) {
            // dd($data, $data->wbs_code);
            $wbs = sap_m_wbs::where('wbs_code', $data->wbs_code)->first();

            if(is_null($wbs)){
                $wbs = sap_m_wbs::create([
                    'project_id' => $data->project_id,
                    'wbs_code' => $data->wbs_code,
                    'wbs_desc' => $data->wbs_description
                ]);

                echo $wbs->wbs_code .'-'. $wbs->wbs_desc . '--> CREATED'.PHP_EOL;
            }else{
                $wbs->update([
                    'project_id' => $data->project_id,
                    'wbs_code' => $data->wbs_code,
                    'wbs_desc' => $data->wbs_description
                ]);

                echo $wbs->wbs_code .'-'. $wbs->wbs_desc . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
