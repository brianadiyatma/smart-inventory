<?php

namespace App\Console\Commands\sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_storage_type;

class GetMasterStorageType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-storage-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Storage Type from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-storage-type';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $storage_type = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($storage_type as $key => $data) {
            
            $stor_type = sap_m_storage_type::where('storage_type_code', $data->storage_type_code)->first();

            if(is_null($stor_type)){
                $stor_type = sap_m_storage_type::create([
                    'storage_type_code' => $data->storage_type_code,
                    'storage_type_name' => $data->storage_type_name
                ]);

                echo $stor_type->storage_type_code .'-'. $stor_type->storage_type_name . '--> CREATED'.PHP_EOL;
            }else{
                $stor_type->update([
                    'storage_type_code' => $data->storage_type_code,
                    'storage_type_name' => $data->storage_type_name
                ]);

                echo $stor_type->storage_type_code .'-'. $stor_type->storage_type_name . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
