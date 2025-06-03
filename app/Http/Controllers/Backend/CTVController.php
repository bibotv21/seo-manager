<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CTVRequest;
use App\Models\CTV;
use App\Models\GuestPost;
use App\Models\TextLink;

class CTVController extends Controller
{
    protected $ctv, $textLink, $gp, $textLink_attrs, $gp_attrs;
    public function __construct(CTV $ctv, TextLink $textLink, GuestPost $gp)
    {
        $this->ctv = $ctv;
        $this->textLink = $textLink;
        $this->gp = $gp;
        $this->textLink_attrs = $this->textLink->removeTLAttrs([5]);
        $this->gp_attrs = $this->gp->removeGPAttrs([7]);
    }

    public function index()
    {
        $ctv_data = $this->ctv->with('textLinks', 'guestPosts')->get()->map(function ($ctv) {
            return $ctv->mappingCTVData();
        });
        $template = 'pages.ctv.index';
        return view('dashboard.layout', compact(
            'template',
            'ctv_data'
        ));
    }

    public function add_ctv_layout($id = null)
    {
        $ctv = null;

        if ($id) {
            $ctv = $this->ctv->find($id);
            $action = 'edit';
        } else {
            $action = 'add';
        }
        $template = 'pages.ctv.add-layout';

        return view('dashboard.layout', compact(
            'template',
            'ctv',
            'action'
        ));
    }

    public function add_ctv_action(CTVRequest $request)
    {
        if ($this->ctv->create_method($request)) {
            return redirect()->route('ctv.index')->with('success', 'Thêm CTV thành công');
        } else {
            return redirect()->route('ctv.index')->with('error', 'Thêm CTV không thành công, kiểm tra lại');
        }
    }

    public function edit_ctv_layout(CTVRequest $request)
    {
        if ($this->ctv->update_method($request)) {
            return redirect()->route('ctv.index')->with('success', 'Cập nhật CTV thành công');
        } else {
            return redirect()->route('ctv.index')->with('error', 'Cập nhật CTV không thành công, kiểm tra lại');
        }
    }

    public function delete_ctv_action($id)
    {
        if ($this->ctv->delete_method($id)) {
            return redirect()->route('ctv.index')->with('success', 'Xóa CTV thành công');
        } else {
            return redirect()->route('ctv.index')->with('error', 'Xóa CTV không thành công, kiểm tra lại');
        }
    }

    public function get_back_link($id)
    {
        $ctv = $this->ctv->with('textLinks', 'guestPosts')->find($id);

        if (!$ctv) {
            abort(404);
        }

        $ctv_tl = [];
        $ctv_gp['data'] = [];

        foreach ($ctv->textLinks as $val) {
            $ctv_tl[] = $val->text_links_result_new($this->textLink_attrs);
        }

        foreach ($ctv->guestPosts as $gp_val) {
            $ctv_gp['data'][] = $this->gp->get_gps_data($gp_val, $this->gp_attrs);
        }

        $ctv_gp['status_no'] = $ctv->guestPosts->where('status', 0)->count();
        $ctv_gp['status_yes'] = $ctv->guestPosts->where('status', 1)->count();

        $template = 'pages.ctv.back-link-details';

        return view('dashboard.layout', compact(
            'template',
            'ctv',
            'ctv_tl',
            'ctv_gp'
        ));
    }
}
