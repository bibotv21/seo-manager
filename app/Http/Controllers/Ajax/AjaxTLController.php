<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CTV;
use App\Models\TextLink;
use App\Services\HelperService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxTLController extends Controller
{
    protected $tl, $ctv, $helper;
    public function __construct(TextLink $tl, CTV $ctv, HelperService $helper)
    {
        $this->tl = $tl;
        $this->ctv = $ctv;
        $this->helper = $helper;
    }

    public function check_all_text_links()
    {
        return $this->tl->check_textlinks($this->tl->with('website', 'ctv')->get()->groupBy('target_domain'), $this->tl->textLinkAttrs());
    }

    public function renew_text_links(Request $request)
    {
        $ids = array_column($request->input('data'), 'id');
        $rn_date = Carbon::createFromFormat('Y-m-d', $request->input('rn_date'));
        $this->tl->whereIn('id', $ids)->update([
            'expired_date' => $rn_date,
            'updated_at' => Carbon::now()
        ]);

        return $this->get_tl_dashboard_data();
    }

    public function delete_selected_tl(Request $request)
    {
        $ids = array_column($request->input('data'), 'id');
        $this->tl->whereIn('id', $ids)->delete();

        return $this->get_tl_dashboard_data();
    }

    public function get_tl_dashboard_data()
    {

        return [
            'expired_data' => $this->tl->get_expired_tl()->all(),
            'tl_dashboard' =>  $this->tl->get_tls(array_merge($this->tl->textLinkAttrs(), ['is_expired_soon']))
        ];
    }

    public function export_excel_file($id = null)
    {
        return $this->helper->exportExcel(config('my_config.common.text-link-type'), $id);
    }
}
