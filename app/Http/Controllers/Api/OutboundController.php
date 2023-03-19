<?php

namespace App\Http\Controllers\Api;

use App\Models\t_outbound;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OutboundResource;

class OutboundController extends Controller
{
    public function index()
    {
        $outbound = t_outbound::latest()->paginate(5);

        return new OutboundResource(true, 'List Data Posts', $outbound);
    }

    public function show(t_outbound $outbound)
    {
        //return single post as a resource
        return new OutboundResource(true, 'Data Post Ditemukan!', $outbound);
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
        $outbound = t_outbound::create([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new OutboundResource(true, 'Data Post Berhasil Ditambahkan!', $outbound);
    }

    public function update(Request $request, t_outbound $outbound)
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
        $outbound->update([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);
    

        //return response
        return new OutboundResource(true, 'Data Post Berhasil Diubah!', $outbound);
    }

    public function destroy(t_outbound $outbound)
    {
        //delete post
        $outbound->delete();

        //return response
        return new OutboundResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
