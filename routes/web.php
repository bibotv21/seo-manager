<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\TextLinkController;
use App\Http\Controllers\Ajax\AjaxTLController;
use App\Http\Controllers\Backend\WebsiteController;
use App\Http\Controllers\Backend\GuestPostController;
use App\Http\Controllers\Ajax\AjaxGPController;
use App\Http\Controllers\Backend\CTVController;
use App\Http\Controllers\Ajax\AjaxCTVController;

use App\Http\Middleware\Authenticate;
use App\Models\CTV;
use App\Models\Website;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('auth.admin');
});

Route::get('admin', [AuthController::class, 'index'])->name('auth.admin');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('my_auth')->group(function () {
    Route::group(['prefix' => 'back-links'], function () {
        Route::group(['prefix' => 'text-link'], function () {
            Route::get('index', [TextLinkController::class, 'index'])->name('textlinks.index');
            Route::post('save', [TextLinkController::class, 'add_textlink_action'])->name('textlink.add');
            Route::post('update', [TextLinkController::class, 'update_textlink_action'])->name('textlink.update');
            Route::get('add', [TextLinkController::class, 'add_textlink_layout'])->name('add.tl.layout');

            Route::where(['id' => '[0-9]+'])->group(function () {                
                Route::get('{id}/edit', [TextLinkController::class, 'add_textlink_layout'])->name('edit.tl.layout');
                Route::get('{id}/delete', [TextLinkController::class, 'delete_textlink'])->name('textlink.detele');
            });
            Route::get('add-quickly', [TextLinkController::class, 'add_textlink_quick'])->name('add.textlink.quickly');
            Route::post('preview-data', [TextLinkController::class, 'preview_data_before_import'])->name('tl_csv_file.preview');
            Route::get('{file_name}/add-quickly-action', [TextLinkController::class, 'add_tl_quickly_action'])->name('add_tl_quickly.action');
            Route::get('delete-all-expired', [TextLinkController::class, 'delete_all_expired'])->name('delete.expired.all');

            Route::post('ajax/expired-tl/renew-tl', [AjaxTLController::class, 'renew_text_links'])->name('ajax.renew.tl');
            Route::post('ajax/delete-selected-tl', [AjaxTLController::class, 'delete_selected_tl'])->name('ajax.delete.tl');
        });

        Route::group(['prefix' => 'guest-post'], function () {
            Route::get('index', [GuestPostController::class, 'index'])->name('guestpost.index');
            Route::get('add', [GuestPostController::class, 'input_gp_layout'])->name('gp.input-add.layout');
            Route::get('add-csv-file', [GuestPostController::class, 'add_gp_csv_layout'])->name('add.gp-csv.layout');
            Route::post('update', [GuestPostController::class, 'update_gp_action'])->name('gp.update');
            Route::post('save', [GuestPostController::class, 'add_gp_action'])->name('gp.add');
            Route::post('preview-data', [GuestPostController::class, 'preview_data_first'])->name('gp_csv_file.preview');
            Route::get('{file_name}/add-csv', [GuestPostController::class, 'add_gp_csv_action'])->name('add_gp_csv.action');
            Route::where(['id' => '[0-9]+'])->group( function(){
                Route::get('{id}/delete', [GuestPostController::class, 'delete_guest_post'])->name('gp.delete');
                Route::get('{id}/edit', [GuestPostController::class, 'input_gp_layout'])->name('gp.input-edit.layout');
                
            });            
        });
    });

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::prefix('website')->group(function () {
        Route::get('index', [WebsiteController::class, 'index'])->name('website.index');
        Route::get('add', [WebsiteController::class, 'add_website_layout'])->name('wb_add.layout');
        Route::post('save', [WebsiteController::class, 'add_website_action'])->name('website.add');
        Route::post('edit/action', [WebsiteController::class, 'edit_website_action'])->name('website.edit');

        Route::where(['id' => '[0-9]+'])->group(function () {
            Route::get('{id}/edit', [WebsiteController::class, 'edit_website_layout'])->name('wc_edit.layout');
            Route::get('{id}/delete', [WebsiteController::class, 'delete_website_action'])->name('website.delete');
            Route::get('{id}/back-links', [WebsiteController::class, 'website_back_links'])->name('website.bl.index');
        });
    });

    Route::prefix('ctv')->group(function () {
        Route::get('index', [CTVController::class, 'index'])->name('ctv.index');
        Route::get('add-layout', [CTVController::class, 'add_ctv_layout'])->name('ctv.add.lay_out');
        Route::post('save', [CTVController::class, 'add_ctv_action'])->name('ctv.add.action');
        Route::post('update', [CTVController::class, 'edit_ctv_layout'])->name('ctv.update.action');
        Route::where(['id' => '[0-9]+'])->group(function () {
            Route::get('{id}/edit', [CTVController::class, 'add_ctv_layout'])->name('edit.ctv.lay_out');
            Route::get('{id}/delete', [CTVController::class, 'delete_ctv_action'])->name('delete.ctv.action');
            Route::get('{id}/back-links', [CTVController::class, 'get_back_link'])->name('ctv.get.backlinks');
        });
    });

    Route::prefix('ajax')->group(function () {
        Route::prefix('text-link')->group( function(){
            Route::post('check-ctv', [AjaxCTVController::class, 'check_text_link'])->name('ajax.ctv-tl.check');
            Route::get('check-all', [AjaxTLController::class, 'check_all_text_links'])->name('ajax.tl-all.check');
            Route::get('export-all', [AjaxTLController::class, 'export_excel_file'])->name('ajax.tl-all.export');
            Route::get('{id}/ctv-export', [AjaxTLController::class, 'export_excel_file'])->name('ajax.ctv-tl.export');
        });
        
        Route::prefix('guest-post')->group(function(){
            Route::post('check-ctv-guest-post', [AjaxGPController::class, 'check_ctv_gps'])->name('ajax.ctv-gp.check');        
            Route::get('check-all-gps', [AjaxGPController::class, 'check_all_gps'])->name('ajax.all-gps.check');
            Route::get('export-all', [AjaxGPController::class, 'export_excel_file'])->name('ajax.gp-all.export');
            Route::get('{id}/ctv-export', [AjaxGPController::class, 'export_excel_file'])->name('ajax.ctv-gp.export');
        });

    });
});
