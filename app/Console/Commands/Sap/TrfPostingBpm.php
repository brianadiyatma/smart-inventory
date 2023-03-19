<?php

namespace App\Console\Commands\Sap;

use Illuminate\Console\Command;

class TrfPostingBpm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smarti:sap-trf-posting-bpm {--reserv=}{--storeloc=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer Posting of BPM';

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
        $reserv = $this->option('reservation_number');
        $storeloc = $this->option('storage_loc');

        $api_url = env('SAP_API_URL','google.com').'/bpm/transfer-posting-bpm/'.$reserv.'/'.$storeloc;
        
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
