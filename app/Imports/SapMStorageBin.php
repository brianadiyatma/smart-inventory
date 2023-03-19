<?php

namespace App\Imports;

use App\Models\sap_m_storage_bin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SapMStorageBin implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $stor_bin = sap_m_storage_bin::where('storage_bin_code', $row['stor_bin_code'])->first();

        if(!$stor_bin){
            return new sap_m_storage_bin([
                'plant_code' => $row['plant'],
                'storage_loc_code' => $row['storage_loc'],
                'storage_type_code' => $row['stor_type'],
                'storage_bin_code'     => $row['stor_bin_code'],
                'storage_bin_name'    => $row['stor_bin_name'],
            ]);
        }
    }
}
