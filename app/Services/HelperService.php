<?php

namespace App\Services;

use App\Exports\GuestPortExport;
use App\Exports\TextLinkExport;
use App\Http\Requests\UploadCSVFile;
use App\Imports\ArrayImport;
use App\Services\Interfaces\HelperInterface;
use App\Models\CTV;
use App\Models\GuestPost;
use App\Models\TextLink;
use App\Models\Website;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class HelperService
 * @package App\Services
 */
class HelperService implements HelperInterface
{
    protected $website, $ctv, $gp, $tl;

    public function __construct(CTV $ctv, Website $website, GuestPost $gp, TextLink $tl)
    {
        $this->ctv = $ctv;
        $this->website = $website;
        $this->gp = $gp;
        $this->tl = $tl;
    }

    public function getDefaultDataInput()
    {
        foreach ($this->ctv->all() as $key => $val) {
            $default_data['ctv'][] = [
                'id' => $val->id,
                'name' => $val->account_id
            ];
        }

        foreach ($this->website->all() as $key => $val) {
            $default_data['website'][] = [
                'id' => $val->id,
                'name' => $val->name
            ];
        }

        return $default_data;
    }

    public function previewCSVData(UploadCSVFile $request, $type)
    {
        $preview_data = [];
        $file_name = '';
        $file = $request->file('csv_file');
        $data = Excel::toArray(new ArrayImport, $file);
        $message = '';

        if(!$this->checkIsValidFieldsCSV($type, $data[0][0])){
            return [
                'data' => [],
                'file_name' => '',
                'error_message' => config('my_config.common.invalid_csv_file_message')
            ];
        }

        foreach ($data[0] as $val) {
            $domain = $this->website->where('name', strtolower($val['domain']))->first();
            $ctv = $this->ctv->where('account_id', strtolower($val['ctv']))->first();
            if (empty($domain) || empty($ctv)) {
                $message = config('my_config.common.invalid_data_message');
                $val['domain'] = empty($domain) ? '--> <span style="color:red">' . $val['domain'] . '</span>' : $val['domain'];
                $val['ctv'] = empty($ctv) ? '--> <span style="color:red">' . $val['ctv'] . '</span>' : $val['ctv'];
            }

            if ($type == 'guest-post') {
                $preview_data[] = $this->gp->mappingDataFromCSV($val);
            } else {
                $row = [];
                foreach ($val as $row_val) {

                    $row[] = $row_val;
                }
                $preview_data[] = $row;
            }
        }

        if (empty($message)) {
            $pre_fix = $type == 'guest-post' ? 'GuestPost_Data' : 'TextLink_Data';
            $file_name = $pre_fix . Carbon::now()->format('dmY_His') . '.csv';
            $file->storeAs('csv_files', $file_name);
        }

        return [
            'data' => $preview_data,
            'file_name' => $file_name,
            'error_message' => $message
        ];
    }

    public function exportExcel($type, $id = null)
    {
        if ($type == config('my_config.common.text-link-type')) {
            $obj = $this->tl;
            $route_name = 'ajax.ctv-tl.export';
            $expot_file_name = TextLinkExport::class;
        } else {
            $obj = $this->gp;
            $route_name = 'ajax.ctv-gp.export';
            $expot_file_name = GuestPortExport::class;
        }

        if ($id) {
            $obj_eloquent = [];
            if (request()->route()->named($route_name)) {
                $obj_eloquent = $obj->with('website', 'ctv')->where('ctv_id', $id)->get();
                $name = $obj_eloquent->isEmpty() ? 'no_data-' : $obj_eloquent->first()->ctv->account_id . '-' . $type . '-';
                
            } else {
                $obj_eloquent = $obj->with('website', 'ctv')->where('domain_id', $id)->get();
                $name = $obj_eloquent->isEmpty() ? 'no_data-' : $obj_eloquent->first()->website->name . '-' . $type . '-';
            }
        } else {
            $obj_eloquent = $obj->get();
            $name = 'all_' . $type . '-';
        }

        return Excel::download(new $expot_file_name($obj_eloquent), $name . Carbon::now()->format('d_m_Y_His') . '.xlsx');
    }

    public function checkIsValidFieldsCSV($type, $data){
        $is_valid = true;
        $fields = $type == 'guest-post' ? $this->gp->csvFields() : $this->tl->csvFields();
        foreach ($fields as $val) {
            if(!array_key_exists($val, $data)){
                $is_valid = false;
                break;
            }
        }
        return $is_valid;
    }
}
