<?php

namespace App\Services;

use App\Services\Interfaces\WebsiteServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Website;
use Carbon\Carbon;

/**
 * Class WebsiteService
 * @package App\Services
 */
class WebsiteService implements WebsiteServiceInterface
{
    public function create($request)
    {
        return $this->cud_action('create', $request);
    }

    public function update($request)
    {
        return $this->cud_action('update', $request);
    }

    public function delete($request)
    {
        return $this->cud_action('delete', $request);
    }

    public function prepare_data($request){
        $data =  $request->except('_token','wb_id');
        $data['name'] = strtolower($data['name']);
        $data['purchase_date'] = Carbon::createFromFormat('Y-m-d', $data['purchase_date']);
        $data['expired_date'] = Carbon::createFromFormat('Y-m-d', $data['expired_date']);
        $data['index_opening_date'] = $data['index_opening_date'] ? Carbon::createFromFormat('Y-m-d', $data['index_opening_date']) : $data['index_opening_date'];
        return $data;
    }

    public function cud_action($action, $request){
        DB::beginTransaction();
        try {
            if (!($action == 'delete')) {
                $data = $this->prepare_data($request); 
            }
            switch ($action) {
                case 'create':     
                    Website::create($data);
                    break;
                case 'update':
                    $data['updated_at'] = Carbon::now();
                    Website::find($request->wb_id)->update($data);
                    break;
                case 'delete':
                    $request->delete();
                    break;
                default:
                    # abcd-xya
                    break;
            }
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollBack();
            dd($e);
            return false;
        }
    }
}
