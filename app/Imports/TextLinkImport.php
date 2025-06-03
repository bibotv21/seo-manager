<?php

namespace App\Imports;

use App\Models\TextLink;
use App\Models\Website;
use App\Models\CTV;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class TextLinkImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return  new TextLink([
            'domain_id' => Website::where('name', $row['domain'])->first()->id,
            'target_domain' => strtolower($row['trang_dat']),
            'impl_date' => Carbon::createFromFormat('d/m/Y', $row['ngay_dat']),
            'expired_date' => Carbon::createFromFormat('d/m/Y', $row['ngay_het_han']),
            'anchor_text' => $row['anchor_text'],
            'amount' => $row['gia'],
            'ctv_id' => CTV::where('account_id', strtolower($row['ctv']))->first()->id
        ]);
    }

    public function onError(\Throwable $e){
        dd($e);
    }
}
