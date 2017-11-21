<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'oauth_id', 'avatar','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function corpus_projects() {
        return $this->belongsToMany(CorpusProject::class);
    }

    public function corpora() {
        return $this->belongsToMany(Corpus::class);
    }

    /**
     * The entitlements that belong to the user.
     */
    public function entitlements()
    {
        return $this->belongsToMany(Entitlement::class);
    }
}
