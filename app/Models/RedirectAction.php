<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedirectAction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'redirect_action';

    protected $filable = [
        'from_domain_id',
        'to_domain_id',
        'impl_date'
    ];
}
