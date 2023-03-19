<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_material_groups;

class GetMasterMaterialGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-material-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Material Group from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-material-groups';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $material_groups = $json_response->data;
        
        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;

        foreach ($material_groups as $key => $data) {
            
            $mat_group = sap_m_material_groups::where('material_group_code', $data->material_group_code)->first();

            if(is_null($mat_group)){
                $mat_group = sap_m_material_groups::create([
                    'material_group_code' => $data->material_group_code,
                    'material_group_name' => $data->material_group_name
                ]);

                echo $mat_group->material_group_code .'-'. $mat_group->material_group_name . '--> CREATED'.PHP_EOL;
            }else{
                $mat_group->update([
                    'material_group_code' => $data->material_group_code,
                    'material_group_name' => $data->material_group_name
                ]);

                echo $mat_group->material_group_code .'-'. $mat_group->material_group_name . '--> UPDATE'.PHP_EOL;
            }
        }
    }
}
