<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CTV extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ctv';

    protected $fillable = [
        'account_id',
        'social_network',
        'note'
    ];

    public static function attrsCTV()
    {
        return [
            'account_id_link',
            'quantity_text_links',
            'quantity_guest_posts',
            'social_network',
            'note',
            'actions'
        ];
    }

    public function textLinks()
    {
        return $this->hasMany(TextLink::class, 'ctv_id');
    }

    public function guestPosts()
    {
        return $this->hasMany(GuestPost::class, 'ctv_id');
    }

    public static function create_method($request)
    {
        return self::cud_action('create', $request);
    }

    public static function update_method($request)
    {
        return self::cud_action('update', $request);
    }

    public static function delete_method($request)
    {
        return self::cud_action('delete', $request);
    }

    public function mappingCTVData($attr = null)
    {
        $tmp_attr = empty($attr) ? self::attrsCTV() : $attr;
        $ctv_result = [];
        foreach ($tmp_attr as $att) {
            switch ($att) {
                case 'account_id_link':
                    $ctv_result[$att] = [route('ctv.get.backlinks', $this->id), $this->account_id];
                    break;
                case 'quantity_text_links':
                    $ctv_result[$att] = $this->textLinks->count();
                    break;
                case 'quantity_guest_posts':
                    $ctv_result[$att] = $this->guestPosts->count();
                    break;
                case 'actions':
                    $ctv_result[$att] = [
                        'url_edit' => route('edit.ctv.lay_out', $this->id),
                        'url_delete' => route('delete.ctv.action', $this->id),
                        'name' => $this->account_id
                    ];
                    break;
                default:
                    $ctv_result[$att] = $this->$att;
                    break;
            }
        }

        return $ctv_result;
    }

    public static function cud_action($action, $request)
    {
        DB::beginTransaction();
        try {
            if (!($action == 'delete')) {
                $data = $request->except('_token');
                $data['account_id'] = strtolower($data['account_id']);
            }

            switch ($action) {
                case 'create':
                    CTV::create($data);
                    break;
                case 'update':
                    $data['updated_at'] = Carbon::now();
                    CTV::find($data['id'])->update($data);
                    break;
                case 'delete':
                    CTV::find($request)->delete();
                    break;
                default:
                    # abcd-xya
                    break;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return false;
        }
    }

    public function delete()
    {
        $this->textLinks()->delete();
        $this->guestPosts()->delete();
        return parent::delete();
    }
}
