<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\user_notifikasi;
use App\Models\t_stock;
use App\Models\sap_m_plant;
use DB;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view) {
            $view->with('vartest', 'hehehehehehe boyyy'); 
            $view->with('index', 1); 
            $view->with('index2', 1); 
            $view->with('indexsttp', 1); 
            $view->with('indexbpm', 1); 
            $view->with('indexbprm', 1); 
            $view->with('notif', user_notifikasi::all());
            $view->with('notifcount', user_notifikasi::all()->count('id')); 
            $view->with('plant', sap_m_plant::limit('5')->get());
            $view->with('stock', t_stock::orderBy('gr_date', 'DESC')->limit('5')->get());
            // $view->with('variable', model::all());
        });

        DB::listen(function ($query) {
            Log::info($query->sql);     // the query being executed
            Log::info($query->time);    // query time in milliseconds
        });
    }
}
