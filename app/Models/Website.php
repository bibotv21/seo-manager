<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'domains';

    protected $fillable = [
        'name',
        'amount',
        'purchase_date',
        'expired_date',
        'index_opening_date',
        'provider'
    ];

    public function textLinks()
    {
        return $this->hasMany(TextLink::class, 'domain_id');
    }

    public function guestPosts()
    {
        return $this->hasMany(GuestPost::class, 'domain_id');
    }

    public static function websiteAttrs()
    {
        return [
            'name',
            'amount',
            'purchase_date',
            'expired_date',
            'index_opening_date',
            'provider',
            'number_of_backlinks',
            'actions',
            'is_expired_soon'
        ];
    }

    public function mappingWebsiteData($attrs)
    {
        foreach ($attrs as $attr) {
            switch ($attr) {
                case 'name':
                    $website[$attr] = [route('website.bl.index', $this->id), $this->name];
                    break;
                case 'purchase_date':
                case 'expired_date':
                case 'index_opening_date':
                    $website[$attr] = Carbon::parse($this->$attr)->format('d-m-Y');
                    break;
                case 'number_of_backlinks':
                    $website[$attr] = $this->textLinks->count() + $this->guestPosts->count();
                    break;
                case 'actions':
                    $website[$attr] = [
                        'url_edit' => route('wc_edit.layout', $this->id),
                        'url_delete' => route('website.delete', $this->id),
                        'name' => $this->name
                    ];
                    break;
                case 'is_expired_soon':
                    $expired_date = Carbon::parse($this->expired_date);
                    $now = Carbon::now();

                    if ($expired_date >= $now) {
                        if ($expired_date->diffInDays($now) < 30) {
                            $website[$attr] = true;
                        } else {
                            $website[$attr] = false;
                        }
                    } else {
                        $website[$attr] = true;
                    }
                    break;
                default:
                    $website[$attr] = $this->$attr;
                    break;
            }
        }

        return $website;
    }

    public function delete()
    {
        $this->textLinks()->delete();
        $this->guestPosts()->delete();
        return parent::delete();
    }
}
