<?php

namespace App\Imports;

use App\Models\sap_m_plant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SapMStoragePlant implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $plant = sap_m_plant::where('plant_code', $row['code'])->first();

        if(!$plant){
            return new sap_m_plant([
                'plant_code'    => $row['code'],
                'plant_name'    => $row['description'],
            ]);
        }
    }
}
