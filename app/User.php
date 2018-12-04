<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password','affiliation', 'gitlab_ssh_pubkey', 'gitlab-use-agree', 'terms-of-use-agree'
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
        return $this->belongsToMany(CorpusProject::class)->withPivot('role_id');
    }

    public function corpora() {
        return $this->belongsToMany(Corpus::class)->withPivot('role_id');
    }
}
