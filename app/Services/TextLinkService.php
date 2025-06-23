<?php

namespace App\Services;

use App\Services\Interfaces\TextLinkServiceInterface;
use Carbon\Carbon;
use App\Models\TextLink;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Log;

/**
 * Class TextLinkService
 * @package App\Services
 */
class TextLinkService implements TextLinkServiceInterface
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

    public function tl_default_update($tl){
        return $tl->update([
            'status' => false,
            'rel_tag' => '',
            'anchor_text' => ''
        ]);
    }

    public function prepare_data($request){
        $data = $request->except('_token', 'textlink_id');
        $data['impl_date'] = Carbon::createFromFormat('Y-m-d', $data['impl_date']);
        $data['expired_date'] = Carbon::createFromFormat('Y-m-d', $data['expired_date']);
        $data['target_domain'] = strtolower($data['target_domain']);
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
                    TextLink::create($data);
                    break;
                case 'update':
                    $data['updated_at'] = Carbon::now();
                    TextLink::find($request->textlink_id)->update($data);
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
