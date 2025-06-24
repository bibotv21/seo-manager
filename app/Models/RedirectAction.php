<?php

namespace App\Models;

use Carbon\Carbon;
use Flasher\Laravel\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

class RedirectAction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'redirect_action';

    protected $fillable = [
        'from_domain_id',
        'to_domain_id',
        'impl_date',
        'is_check_bl'
    ];

    public static function get_all_301($dm_id)
    {
        $domain_ids = self::get_all_ids_301($dm_id);
        
        $web_names = Website::whereIn('id', $domain_ids)->get()->pluck('name');

        return $web_names;
    }

    public static function get_all_ids_301($dm_id)
    {
        $domain_ids = [$dm_id];
        $f_domain_ids = [$dm_id];
        $t_domain_ids = [$dm_id];
        do{
            $f_domain_ids = self::whereIn('to_domain_id', $f_domain_ids)->pluck('from_domain_id');
            $f_domain_ids = array_values(array_diff($f_domain_ids->toArray(), [$dm_id]));
            $tmp_list = $domain_ids;
            $domain_ids = array_unique(array_merge($domain_ids, $f_domain_ids));
        }while((!empty($f_domain_ids) && !empty(array_diff($f_domain_ids, $tmp_list))));

        do{
            $t_domain_ids = self::whereIn('from_domain_id', $t_domain_ids)->pluck('to_domain_id');
            $t_domain_ids = array_values(array_diff($t_domain_ids->toArray(), [$dm_id]));
            $tmp_list2 = $domain_ids;
            $domain_ids = array_unique(array_merge($domain_ids, $t_domain_ids));
        }while(!empty($t_domain_ids) && !empty(array_diff($t_domain_ids, $tmp_list2)));
        
        return array_unique($domain_ids);
    }

    public static function store($request)
    {
        DB::beginTransaction();
        try {
            $request['impl_date'] = Carbon::now();
            RedirectAction::create($request);
            DB::commit();
            return true;                    
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return false;
        }
    }
}
