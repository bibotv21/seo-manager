<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\RedirectAction;
use Illuminate\Support\Arr;
use App\Http\Requests\WebsiteInput;
use App\Models\GuestPost;
use App\Services\Interfaces\WebsiteServiceInterface as MyWebsiteService;

class WebsiteController extends Controller
{
    //

    protected $website, $gp, $my_wb_sv, $attr, $ra_301;

    public function __construct(Website $website, GuestPost $gp, MyWebsiteService $my_wb_sv, RedirectAction $redirect_301)
    {
        $this->website = $website;
        $this->gp = $gp;
        $this->my_wb_sv = $my_wb_sv;
        $this->attr = $this->gp->removeGPAttrs([6]);
        $this->$redirect_301 = $this->ra_301;
    }


    public function index()
    {
        $websites = $this->website->all();
        $template = 'pages.website.all-websites';

        $websites_data = [];

        foreach ($websites as $item) {
            $arr_wb_id = [];
            $ra = RedirectAction::where('to_domain_id', $item->id)->first();
            $ra_message = '';
            // if (!$ra) {
            //     $from_ra = RedirectAction::where('from_domain_id', $item->id)->first();
            //     if (!$from_ra) {
            //         $ra_message = 'n/a';
            //     } else {
            //         $from_wb = $this->website->find($from_ra->from_domain_id);
            //         $to_wb = $this->website->find($from_ra->to_domain_id);
            //         $ra_message = $from_wb->name . ' --> ' . $to_wb->name;
            //     }
            // } else {
            //     $arr_wb_id[] = [
            //         'id' => $ra->from_domain_id,
            //         'date' => $ra->impl_date
            //     ];
            //     $a = $ra;
            //     do {
            //         $t = RedirectAction::where('to_domain_id', $a->from_domain_id)->first();
            //         if ($t) {
            //             $arr_wb_id[] = [
            //                 'id' => $t->from_domain_id,
            //                 'date' => $t->impl_date
            //             ];
            //             $a = $t;
            //         }
            //     } while ($t);

            //     $sorted = array_values(Arr::sort($arr_wb_id, function (array $val) {
            //         return $val['date'];
            //     }));

            //     foreach ($sorted as $wb) {
            //         $ra_message .= $this->website->find($wb['id'])->name . ' --> ';
            //     }
            //     $ra_message .= $item->name;
            // }            

            $tmp_w = $item->mappingWebsiteData($this->website->websiteAttrs());
            $websites_data[] = array_merge($tmp_w, ['r301_message' => $ra_message]);
        }

        return view('dashboard.layout', compact(
            'template',
            'websites_data'
        ));
    }

    public function add_website_layout()
    {
        $template = 'pages.website.wb_add_layout';
        $wb_data = '';
        return view('dashboard.layout', compact(
            'template',
            'wb_data'
        ));
    }

    public function add_website_action(WebsiteInput $request)
    {
        if ($this->my_wb_sv->create($request)) {
            return redirect()->route('website.index')->with('success', 'Thêm mới website thành công');
        } else {
            return redirect()->route('wb_add.layout')->with('error', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
        }
    }

    public function edit_website_layout($id)
    {
        $template = 'pages.website.wb_add_layout';
        $wb_data = $this->website->find($id);
        return view('dashboard.layout', compact(
            'template',
            'wb_data'
        ));
    }

    public function edit_website_action(WebsiteInput $request)
    {
        $wb = $this->website->find($request->wb_id);
        if ($this->my_wb_sv->update($request)) {
            return redirect()->route('website.index')->with('success', 'Bạn đã cập nhập thông tin website: ' . $wb->name . ' thành công!');
        } else {
            return redirect()->route('edit_website_layout', $request->input('wb_id'))->with('error', 'Cập nhật website: ' . $wb->name . 'không thành công, vui lòng kiểm tra lại');
        }
    }

    public function delete_website_action($id)
    {
        $wb = $this->website->find($id);
        if ($this->my_wb_sv->delete($wb)) {
            return redirect()->route('website.index')->with('success', 'Xóa website: ' . $wb->name . ' thành công');
        } else {
            return redirect()->route('website.index')->with('success', 'Gặp lỗi khi xóa website: ' . $wb->name);
        }
    }

    public function website_back_links($id)
    {        
        $website = $this->website->with('textLinks','guestPosts')->find($id);
        $tl_data = $website->textLinks->map(function ($tl){
            return $tl->text_links_result_new();
        });

        $gp_data = $website->guestPosts->map(function ($gp){
            return $this->gp->get_gps_data($gp, $this->attr);
        });

        $template = 'pages.website.wb-back-links-details';
        return view('dashboard.layout', compact(
            'template',
            'website',
            'tl_data',
            'gp_data'
        ));
    }
}
