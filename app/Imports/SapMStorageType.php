<?php

namespace App\Imports;

use App\Models\sap_m_storage_type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SapMStorageType implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $stor_type = sap_m_storage_type::where('storage_type_code', $row['stor_type_code'])->first();

        if(!$stor_type){
            return new sap_m_storage_type([
                'storage_type_code'    => $row['stor_type_code'],
                'storage_type_name'    => $row['stor_type_name'],
            ]);
        }
    }
}
