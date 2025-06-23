<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TextLink;

class AjaxCTVController extends Controller
{
    protected $textLink, $textLink_attrs;
    public function __construct(TextLink $textLink)
    {
        $this->textLink = $textLink;
        $this->textLink_attrs = $this->textLink->removeTLAttrs([5]);
    }

    public function check_text_link(Request $request)
    {        
        $td_group = $this->textLink->with('website')->where('ctv_id', $request->input('id'))->get()->groupBy('target_domain');
        return $this->textLink->check_textlinks($td_group, $this->textLink_attrs);
    }
}
