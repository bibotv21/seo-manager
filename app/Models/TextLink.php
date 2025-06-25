<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class TextLink extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'text_links';

    protected $fillable = [
        'domain_id',
        'target_domain',
        'impl_date',
        'expired_date',
        'text_link_full',
        'anchor_text',
        'amount',
        'ctv_id',
        'status',
        'rel_tag'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'domain_id');
    }

    public function ctv()
    {
        return $this->belongsTo(CTV::class, 'ctv_id');
    }

    public static function textLinkAttrs()
    {
        return [
            'target_domain',
            'impl_date',
            'expired_date',
            'anchor_text',
            'amount',
            'ctv_name',
            'status',
            'rel_tag',
            'website_name',
            'actions'
        ];
    }

    public static function csvFields()
    {
        return [
            'trang_dat',
            'anchor_text',
            'ngay_dat',
            'ngay_het_han',
            'domain',
            'gia',
            'ctv'
        ];
    }

    public static function getTextLinkQuery()
    {
        return TextLink::with('website', 'ctv');
    }

    public static function get_tls($at_arr = null)
    {
        return self::getTextLinkQuery()->get()->map(function ($tl_val) use ($at_arr) {
            return $tl_val->text_links_result_new($at_arr);
        });
    }

    public static function get_expired_tl($at_arr = null)
    {
        return self::getTextLinkQuery()->where('expired_date', '<', Carbon::now())->get()->map(function ($tl_val) use ($at_arr) {
            $tl_tmp = $tl_val->text_links_result_new($at_arr);
            $tl_tmp['id'] = $tl_val->id;
            return $tl_tmp;
        });
    }

    public static function get_trashed_tl($at_arr = null)
    {
        return self::getTextLinkQuery()->with(
            [
                'ctv' => function ($query) {
                    $query->withTrashed();
                },
                'website' => function ($query) {
                    $query->withTrashed();
                }
            ]
        )->onlyTrashed()->get()->map(function ($tl_val) use ($at_arr) {
            $tmp_tl = $tl_val->text_links_result_new($at_arr);
            array_pop($tmp_tl);
            return $tmp_tl;
        });
    }

    public static function check_textlinks($tl_groups, $at_arr = null)
    {
        $promises = [];
        $client = new Client();
        $dom = new \DOMDocument();
        $result = [];
        libxml_use_internal_errors(true);

        foreach ($tl_groups as $td_key => $tl_group) {
            $promises[] = function () use ($client, $dom, $td_key, $tl_group, &$result, $at_arr) {
                return $client->getAsync($td_key, ['connect_timeout' => 4])->then(
                    function ($response) use ($tl_group, $dom, &$result, $at_arr) {
                        $html = $response->getBody()->getContents();
                        $dom->loadHTML($html);
                        $xpath  = new \DOMXPath($dom);

                        foreach ($tl_group as $tl_val) {
                            $web_names = RedirectAction::get_all_301($tl_val->website->id);
                            $status = false;
                            $anchor_text = '';
                            $rel = '';
                            foreach($web_names as $wb_name){
                                $condition = "contains(translate(@href,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'), 'https://" . $wb_name . "')";
                                $match = $xpath->query('//a[' . $condition . ']')->item(0);
                                if (empty($match)){
                                    continue;
                                }else{
                                    $anchor_text = $match->nodeValue . " (" . $wb_name . ")";
                                    $rel = $match->getAttribute('rel');
                                    $status = true;
                                }
                            }                        

                            $tl_val->update([
                                'status' => $status,
                                'rel_tag' => $rel,
                                'anchor_text' => $anchor_text
                            ]);

                            $result[] = $tl_val->text_links_result_new($at_arr);
                        }
                    },
                    function (\Exception $e) use ($tl_group, &$result, $at_arr) {
                        foreach ($tl_group as $tl_val) {
                            $tl_val->update([
                                'status' => false,
                                'rel_tag' => '',
                                'anchor_text' => ''
                            ]);
                            $result[] = $tl_val->text_links_result_new($at_arr);
                        }
                    }
                );
            };
        }


        $pool = new Pool($client, $promises, [
            'concurrency' => 17,
            'rejected' => function ($reason, $i) {
                Log::error('rejected check text link: %s', ['exception' => $reason]);
            }

        ]);
        $pool->promise()->wait();
        return $result;
    }

    public function tl_default_update($tl)
    {
        return $tl->update([
            'status' => false,
            'rel_tag' => '',
            'anchor_text' => ''
        ]);
    }

    public function text_links_result_new($at_arr = null)
    {
        $tmp_atts = empty($at_arr) ? self::textLinkAttrs() : $at_arr;
        foreach ($tmp_atts as $at) {
            switch ($at) {
                case 'impl_date':
                case 'expired_date':
                    $tl[$at] = Carbon::parse($this->$at)->format('d-m-Y');
                    break;
                case 'actions':
                    $tl[$at] = [route('edit.tl.layout', $this->id), route('textlink.detele', $this->id)];
                    break;
                case 'website_name':
                    $tl[$at] = $this->website->name;
                    break;
                case 'ctv_name':
                    $tl[$at] = $this->ctv->account_id;
                    break;
                case 'is_expired_soon':
                    $expired_date = Carbon::parse($this->expired_date);
                    $now = Carbon::now();

                    if ($expired_date >= $now) {
                        if ($expired_date->diffInDays($now) < 3) {
                            $tl[$at] = true;
                        } else {
                            $tl[$at] = false;
                        }
                    } else {
                        $tl[$at] = true;
                    }
                    break;
                default:
                    $tl[$at] = $this->$at;
                    break;
            }
        }

        return $tl;
    }

    public function recordAllAttr()
    {
        return $this->text_links_result_new($this->textLinkAttrs());
    }

    public static function removeTLAttrs($arr_rm)
    {
        $tmp_atts = TextLink::textLinkAttrs();
        Arr::forget($tmp_atts, $arr_rm);
        return array_values($tmp_atts);
    }
}
