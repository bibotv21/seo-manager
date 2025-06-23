<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GuestPost;
use App\Http\Requests\GuestPostInput;
use App\Http\Requests\UploadCSVFile;
use App\Imports\GuestPostImport;
use App\Models\Website;
use App\Models\CTV;
use App\Services\HelperService;
use Maatwebsite\Excel\Facades\Excel;

class GuestPostController extends Controller
{
    protected $gp, $ctv, $website, $helper;
    public function __construct(GuestPost $gp, CTV $ctv, Website $website , HelperService $helper)
    {
        $this->ctv = $ctv;
        $this->website = $website;
        $this->gp = $gp;
        $this->helper = $helper;
    }

    public function index()
    {
        $gp_data = $this->gp->getAllGP();
        $template = 'pages.guest-post.dashboard';
        return view('dashboard.layout', compact(
            'template',
            'gp_data'
        ));
    }

    public function delete_guest_post($id)
    {
        $this->gp->deleteGP($id);
        return redirect()->route('guestpost.index');
    }

    public function input_gp_layout($id = null)
    {
        if ($id) {
            $gp_data = $this->gp->find($id);
            $action = 'edit';
        } else {
            $gp_data = null;
            $action = 'add';
        }

        $default_data = $this->helper->getDefaultDataInput();
        $template = 'pages.guest-post.input-layout';
        return view('dashboard.layout', compact(
            'template',
            'action',
            'default_data',
            'gp_data'
        ));
    }

    public function add_gp_action(GuestPostInput $request)
    {
        if ($this->gp->createGP($request)) {
            return redirect()->route('guestpost.index')->with('success', 'Thêm mới Guest Post thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy ra khi thêm Guest Post này!');
        }
    }

    public function update_gp_action(GuestPostInput $request)
    {
        if ($this->gp->updateGP($request)) {
            return redirect()->to($request->input('previous_url'))->with('success', 'Cập nhật Guest Post thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật Guest Post này!');
        }
    }

    public function add_gp_csv_layout()
    {
        $first_time = true;
        $template = 'pages.guest-post.add-by-csv';
        return view('dashboard.layout', compact(
            'template',
            'first_time'
        ));
    }

    public function preview_data_first(UploadCSVFile $request)
    {
        $first_time = false;
        $preview_data = $this->helper->previewCSVData($request, 'guest-post');
        $template = 'pages.guest-post.add-by-csv';
        return view('dashboard.layout', compact(
            'template',
            'first_time',
            'preview_data'
        ));
    }

    public function add_gp_csv_action($file_name)
    {
        $file_path = storage_path('app/csv_files/' . $file_name);
        if (file_exists($file_path)) {
            try{
                Excel::import(new GuestPostImport($this->ctv, $this->website), $file_path);
            } catch (\Exception $e) {
                return redirect()->route('guestpost.index')->with('error', 'Kiểm tra lại dữ liệu CSV file! Thêm Guest Posts không thành công,');
            }            
            return redirect()->route('guestpost.index')->with('success', 'Thêm Guest Post bằng file csv thành công!');
        } else {
            return redirect()->route('guestpost.index')->with('error', 'Some thing went wrong!');
        }
    }
}
