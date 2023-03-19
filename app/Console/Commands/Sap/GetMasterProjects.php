<?php

namespace App\Console\Commands\SAP;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\sap_m_project;

class GetMasterProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sap:get-master-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Master Project from SAP';

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
        $api_url = config('sap_connect.sap_host').'/master-data-projects';
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);
        $projects_data = $json_response->data;

        echo '******************************' .PHP_EOL;
        echo 'GET MASTER DATA FROM SAP' . PHP_EOL;
        echo '******************************' .PHP_EOL;
        
        foreach($projects_data as $data){
            $project = sap_m_project::where('project_code',$data->project_code)->first();
            
            if(!$project)
            {
                $project = sap_m_project::create([
                    'project_code' => $data->project_code,
                    'project_desc' => $data->project_description,
                    'start_date' => $data->start_date,
                    'end_date' => $data->finish_date,
                ]);

                echo $project->project_code .'-'. $project->project_desc . '--> CREATED'.PHP_EOL;
            }else{
                $project->update([
                    'project_code' => $data->project_code,
                    'project_desc' => $data->project_description,
                    'start_date' => $data->start_date,
                    'end_date' => $data->finish_date,
                ]);
                   
                echo $project->project_code .'-'. $project->project_desc . '--> UPDATED'.PHP_EOL;
            }
        }
    }
}
