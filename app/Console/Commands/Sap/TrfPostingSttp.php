<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use Carbon\Carbon;


class TrfPostingSttp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smarti:sap-trf-posting-sttp {--docNumber=}{--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer Posting of STTP to Warehouse';

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
        $doc_numb = $this->option('docNumber');
        $year = $this->option('year');

        $api_url = env('SAP_API_URL','google.com').'/sttp/transfer-posting/'.$doc_numb.'/'.$year;
        
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($api_url,[]);
        $status = $response->getBody()->getContents();
        $json_response = json_decode($status);

        // ini belum merubah status di SMART INVENTORY namun sudah merubah di SAP
        dd($json_response);
    }
}
