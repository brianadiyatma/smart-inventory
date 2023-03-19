<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_material_type;

class GetMasterMaterialTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-material-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Material Type from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-material-types';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $material_types = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($material_types as $key => $data) {
            
            $mat_type = sap_m_material_type::where('material_type_code', $data->material_type_code)->first();

            if(is_null($mat_type)){
                $mat_type = sap_m_material_type::create([
                    'material_type_code' => $data->material_type_code,
                    'material_type_desc' => $data->material_type_name
                ]);

                echo $mat_type->material_type_code .'-'. $mat_type->material_type_desc . '--> CREATED'.PHP_EOL;
            }else{
                $mat_type->update([
                    'material_type_code' => $data->material_type_code,
                    'material_type_desc' => $data->material_type_name
                ]);

                echo $mat_type->material_type_code .'-'. $mat_type->material_type_desc . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
