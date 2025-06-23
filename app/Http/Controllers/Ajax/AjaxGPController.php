<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestPost;
use App\Services\HelperService;

class AjaxGPController extends Controller
{
    protected $gp, $helper;
    public function __construct(GuestPost $gp, HelperService $helper)
    {
        $this->gp = $gp;
        $this->helper = $helper;
    }

    public function check_all_gps()
    {
        $gps = $this->gp->get()->all();
        $data = $this->gp->check_index_gp($gps);
        return $data;
    }

    public function check_ctv_gps(Request $request)
    {
        $gps = $this->gp->with('website', 'ctv')->where('ctv_id', $request->id)->get()->all();
        return $this->gp->check_index_gp($gps);
    }

    public function export_excel_file($id = null)
    {
        return $this->helper->exportExcel(config('my_config.common.guest-post-type'), $id);
    }
}
