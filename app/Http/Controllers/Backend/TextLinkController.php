<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CTV;
use App\Models\TextLink;
use App\Models\Website;
use App\Http\Requests\SaveTextLinkRequest;
use App\Http\Requests\UploadCSVFile;
use App\Imports\TextLinkImport;
use App\Services\HelperService;
use App\Services\Interfaces\TextLinkServiceInterface as TLService;
use Maatwebsite\Excel\Facades\Excel;

class TextLinkController extends Controller
{
    protected $textLink, $website, $ctv, $tlService, $helper;

    public function __construct(TLService $tlService, TextLink $textLink, Website $website, CTV $ctv, HelperService $helper)
    {
        $this->textLink = $textLink;
        $this->website = $website;
        $this->ctv = $ctv;
        $this->tlService = $tlService;
        $this->helper = $helper;
    }

    public function index()
    {
        $tl_data = $this->textLink->get_tls(array_merge($this->textLink->textLinkAttrs(), ['is_expired_soon']));

        $tl_expired = $this->textLink->get_expired_tl();

        $tl_trashed = $this->textLink->get_trashed_tl();


        $template = "pages.textlinks.textlink-dashboard";
        return view('dashboard.layout', compact(
            'template',
            'tl_data',
            'tl_expired',
            'tl_trashed'
        ));
    }
    
    public function add_textlink_layout($id = null)
    {

        $default_data = [];
        $tl_data = null;
        if($id){
            $action = 'edit';
            $tl_data = $this->textLink->find($id);
        }else{
            $action = 'add';
        }

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

        $template = 'pages.textlinks.add-layout';
        return view('dashboard.layout', compact(
            'template',
            'tl_data',
            'default_data',
            'action'
        ));
    }

    public function add_textlink_action(SaveTextLinkRequest $request)
    {
        if ($this->tlService->create($request)) {
            return redirect()->route('textlinks.index', $request->input('domain_id'))->with('success', 'Thêm Text Link mới thành công');
        } else {
            return redirect()->route('add.tl.layout', $request->input('domain_id'))->with('error', 'Thêm Text Link mới không thành công, kiểm tra lại');
        }
    }

    public function update_textlink_action(SaveTextLinkRequest $request)
    {
        if ($this->tlService->update($request)) {
            return redirect()->to($request->input('previous_url'))->with('success', 'Cập nhật Text Link thành công');
        } else {
            return redirect()->route('edit.tl.layout', $request->input('textlink_id'))->with('error', 'Cập nhật Text Link không thành công, kiểm tra lại');
        }
    }

    public function delete_textlink($id)
    {
        $tl = $this->textLink->find($id);
        if ($this->tlService->delete($tl)) {
            return back()->with('success', 'Xóa Text Link thành công');
        } else {
            return back()->with('error', 'Xóa Text Link không thành công, kiểm tra lại');
        }
    }

    public function add_textlink_quick()
    {
        $first_time = true;
        $template = 'pages.textlinks.add-quickly';
        return view('dashboard.layout', compact(
            'template',
            'first_time'
        ));
    }

    public function preview_data_before_import(UploadCSVFile $request)
    {
        $first_time = false;

        $preview_data = $this->helper->previewCSVData($request, 'text-link');

        $template = 'pages.textlinks.add-quickly';
        return view('dashboard.layout', compact(
            'template',
            'preview_data',
            'first_time'
        ));
    }

    public function add_tl_quickly_action($file_name)
    {
        $file_path = storage_path('app/csv_files/' . $file_name);
        if (file_exists($file_path)) {
            try{
                Excel::import(new TextLinkImport, $file_path);
            }catch(\Exception $e){
                return redirect()->route('add.textlink.quickly')->with('error', 'Kiểm tra lại dữ liệu! Thêm Text Links không thành công! ');
            }            
            return redirect()->route('textlinks.index')->with('success', 'Thêm Text Link bằng file csv thành công!');
        } else {
            return redirect()->route('add.textlink.quickly')->with('error', 'Không tìm thấy file');
        }
    }

}
