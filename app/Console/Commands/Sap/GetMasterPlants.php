<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_plant;

class GetMasterPlants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-plant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Plant from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-plants';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $plants = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($plants as $key => $data) {
            
            $plant = sap_m_plant::where('plant_code', $data->plant_code)->first();

            if(is_null($plant)){
                $plant = sap_m_plant::create([
                    'plant_code' => $data->plant_code,
                    'plant_name' => $data->plant_name
                ]);

                echo $plant->plant_code .'-'. $plant->plant_name . '--> CREATED'.PHP_EOL;
            }else{
                $plant->update([
                    'plant_code' => $data->plant_code,
                    'plant_name' => $data->plant_name
                ]);

                echo $plant->plant_code .'-'. $plant->plant_name . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
