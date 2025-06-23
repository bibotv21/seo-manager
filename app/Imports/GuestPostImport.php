<?php

namespace App\Imports;

use App\Models\GuestPost;
use App\Models\Website;
use App\Models\CTV;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class GuestPostImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    protected $website, $ctv;

    public function __construct(CTV $ctv, Website $website)
    {
        $this->ctv = $ctv;
        $this->website = $website;
    }

    public function model(array $row)
    {
        return  new GuestPost([        
            'target_domain' => strtolower($row['trang_dat']),
            'source_link' => $row['link_bai_viet'],
            'post_link' => $row['link_dat'],
            'amount' => $row['gia'],
            'domain_id' => $this->website::where('name', strtolower($row['domain']))->first()->id,
            'impl_date' => Carbon::createFromFormat('d/m/Y', $row['ngay_dat']),
            'ctv_id' => $this->ctv::where('account_id', strtolower($row['ctv']))->first()->id,            
        ]);
    }

    public function onError(\Throwable $e){
        dd($e);
    }
}