<?php

namespace App\Imports;

use App\Models\sap_m_storage_bin;
use App\Models\sap_m_storage_type;
use App\Imports\SapMStorageBin;
use App\Imports\SapMStorageType;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SapMStorage implements WithHeadingRow, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function sheets(): array
    {
        return [
            'storage_bin' => new SapMStorageBin(),
            'stor_type' => new SapMStorageType(),
            // 'warehouse' => new SapMStoragePlant(),
        ];
    }
}
