<?php

namespace App\Http\Controllers\Api;

use App\Models\t_inbound;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\InboundResource;

class InboundController extends Controller
{
    public function index()
    {
        $inbound = t_inbound::with(['bins','materials','sttp','wbs','users','storloc','plants'])->get();
        $data = \App\Models\sap_m_project::with('sttp')->get();
        return new InboundResource(true, 'List Data Posts', $data);
    }

    public function show(t_inbound $inbound)
    {
        //return single post as a resource
        return new InboundResource(true, 'Data Post Ditemukan!', $inbound);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $inbound = t_inbound::create([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new InboundResource(true, 'Data Post Berhasil Ditambahkan!', $inbound);
    }

    public function update(Request $request, t_inbound $inbound)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //update post without image
        $inbound->update([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);
    

        //return response
        return new InboundResource(true, 'Data Post Berhasil Diubah!', $inbound);
    }

    public function destroy(t_inbound $inbound)
    {
        //delete post
        $inbound->delete();

        //return response
        return new InboundboundResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}


