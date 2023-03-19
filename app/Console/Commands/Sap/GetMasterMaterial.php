<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_materials;

class GetMasterMaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-material';

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
        $api_url = config('sap_connect.sap_host').'/master-data-material';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $materials = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($materials as $key => $data) {
            
            $material = sap_m_materials::where('material_code', $data->material_code)->first();

            if(is_null($data->specification)){
                $specification = '-';
            }else{
                $specification = $data->specification;
            }

            if(is_null($material)){
                $material = sap_m_materials::create([
                    'material_code' => $data->material_code,
                    'material_desc' => $data->material_description,
                    'specification' => $specification,
                    'uom_id' => $data->uom_id,
                    'material_group_id' => $data->material_group_id,
                    'material_type_id' => $data->material_type_id
                ]);

                echo $material->material_code .'-'. $material->material_desc . '--> CREATED'.PHP_EOL;
            }else{
                $material->update([
                    'material_code' => $data->material_code,
                    'material_desc' => $data->material_description,
                    'specification' => $specification,
                    'uom_id' => $data->uom_id,
                    'material_group_id' => $data->material_group_id,
                    'material_type_id' => $data->material_type_id
                ]);

                echo $material->material_code .'-'. $material->material_desc . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
