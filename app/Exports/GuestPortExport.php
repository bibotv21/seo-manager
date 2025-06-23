<?php

namespace App\Exports;

use App\Models\GuestPost;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuestPortExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($gp)
    {
        $this->data = $gp;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Website Đặt',
            'Link Bài Viết',
            'Link Đặt',
            'Giá',
            'Website',
            'Ngày Đặt',
            'CTV',
            'Trạng Thái',
        ];
    }

    public function map($gp): array
    {
        return [
            $gp->target_domain,            
            $gp->source_link,
            $gp->post_link,
            $gp->amount,
            $gp->website->name,
            Carbon::parse($gp->impl_date)->format('d/m/Y'),
            $gp->ctv->account_id,
            $gp->status ? 'Indexed' : 'No'
        ];
    }
}
