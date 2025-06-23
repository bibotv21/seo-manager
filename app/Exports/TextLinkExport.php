<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TextLinkExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Website Đặt',
            'Anchor Text',
            'Ngày Đặt',
            'Ngày Hết Hạn',
            'Website',
            'Giá',
            'CTV',
            'Trạng Thái',
            'Thẻ Rel'
        ];
    }

    public function map($tl): array
    {
        return [
            $tl->target_domain,
            $tl->anchor_text,
            Carbon::parse($tl->impl_date)->format('d/m/Y'),
            Carbon::parse($tl->expired_date)->format('d/m/Y'),
            $tl->website->name,
            $tl->amount,
            $tl->ctv->account_id,
            $tl->status ? 'OK' : 'Chưa Đặt',            
            $tl->rel
        ];
    }
}
