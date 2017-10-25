<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Adldap\Laravel\Traits\HasLdapUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes, HasLdapUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'oauth_id', 'avatar', 'password', // was 'email' instead of 'username'
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
}
