<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthDriver extends Model
{
    protected $table = 'oauth_drivers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'active'
    ];

    protected $hidden = [
    ];

    protected $guarded = [
        'id'
    ];
}
