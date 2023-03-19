<?php

namespace App\Http\Controllers\Api;

use App\Models\Notifikasi;
use App\Http\Requests\StoreNotifikasiRequest;
use App\Http\Requests\UpdateNotifikasiRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FCMToken;
use Kutia\Larafirebase\Facades\Larafirebase;
use DB;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotifikasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotifikasiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notifikasi  $notifikasi
     * @return \Illuminate\Http\Response
     */
    public function show(Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notifikasi  $notifikasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotifikasiRequest  $request
     * @param  \App\Models\Notifikasi  $notifikasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotifikasiRequest $request, Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notifikasi  $notifikasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notifikasi $notifikasi)
    {
        //
    }

    public function updateToken(Request $request){
        try{
            // $request->user()->update(['fcm_token'=>$request->token]);
            $token =  FCMToken::firstOrCreate(
                ['device_token' =>  request('token')],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            return response()->json([
                'success'=>true,
                'message'=>''
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false,
                'message'=> $e,
            ],500);
        }
    }

    public function notification(Request $request){
        $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        try{
            $fcmTokens = FCMToken::whereNotNull('device_token')->pluck('device_token')->toArray();
            Larafirebase::fromRaw([
                'registration_ids' => $fcmTokens,
                'data' => [
                    'title' => $request->title,
                    'body' => $request->body,
                    'icon' => asset('img/image4.jpg'),
                    'image' => asset('img/image4.jpg')
                ],              
            ])->send();
                
                return response()->json([
                    'success'=>true,
                    'message'=>'success'
                ]);

        }catch(\Exception $e){
            
            return response()->json([
                'success'=>false,
                'message'=> $e,
            ],500);
        }
    }
}
