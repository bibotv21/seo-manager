<?php

namespace App\Services\Interfaces;

use App\Http\Requests\UploadCSVFile;

/**
 * Interface HelperInterface
 * @package App\Services\Interfaces
 */
interface HelperInterface
{
    public function getDefaultDataInput();

    public function previewCSVData(UploadCSVFile $request, $type);
    
    public function exportExcel($type, $id = null);
}
