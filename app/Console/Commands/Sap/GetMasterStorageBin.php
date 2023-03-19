<?php

namespace App\Console\Commands\sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_storage_bin;

class GetMasterStorageBin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-storage-bin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Storage Bin from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-storage-bin';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $storage_bin = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($storage_bin as $key => $data) {
            
            $stor_bin = sap_m_storage_bin::where('storage_bin_code', trim($data->storage_bin_code))->first();

            if(is_null($stor_bin)){
                $stor_bin = sap_m_storage_bin::create([
                    'plant_code' => $data->plant_code,
                    'storage_loc_code' => $data->storage_loc_code,
                    'storage_type_code' => $data->storage_type_code,
                    'storage_bin_code' => trim($data->storage_bin_code),
                    'storage_bin_name' => trim($data->storage_bin_name)
                ]);

                echo $stor_bin->storage_bin_code .'-'. $stor_bin->storage_bin_name . '--> CREATED'.PHP_EOL;
            }else{
                $stor_bin->update([
                    'plant_code' => $data->plant_code,
                    'storage_loc_code' => $data->storage_loc_code,
                    'storage_type_code' => $data->storage_type_code,
                    'storage_bin_code' => trim($data->storage_bin_code),
                    'storage_bin_name' => trim($data->storage_bin_name)
                ]);

                echo $stor_bin->storage_bin_code .'-'. $stor_bin->storage_bin_name . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
