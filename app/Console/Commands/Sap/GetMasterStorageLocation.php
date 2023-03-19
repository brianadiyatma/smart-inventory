<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_storage_locations;

class GetMasterStorageLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-storage-loc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Storage Location from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-storage-loc';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $storage_location = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($storage_location as $key => $data) {
            
            $stor_loc = sap_m_storage_locations::where('storage_location_code', $data->storage_location_code)->first();

            if(is_null($stor_loc)){
                $stor_loc = sap_m_storage_locations::create([
                    'storage_location_code' => $data->storage_location_code,
                    'storage_location_name' => $data->storage_location_name
                ]);

                echo $stor_loc->storage_location_code .'-'. $stor_loc->storage_location_name . '--> CREATED'.PHP_EOL;
            }else{
                $stor_loc->update([
                    'storage_location_code' => $data->storage_location_code,
                    'storage_location_name' => $data->storage_location_name
                ]);

                echo $stor_loc->storage_location_code .'-'. $stor_loc->storage_location_name . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
