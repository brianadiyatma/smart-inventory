<?php

namespace App\Http\Controllers;

use App\Models\sap_m_wbs;
use App\Models\sap_m_uoms;
use Illuminate\Http\Request;

class masterController extends Controller
{
    public function wbs()
    {
        return view('wbs', [
            'data' => sap_m_wbs::all(),
            'title' => 'WBS'
        ]);
    }

    public function uom()
    {
        return view('uom', [
            'data' => sap_m_uoms::all(),
            'title' => 'UoM'
        ]);        
    }
}
