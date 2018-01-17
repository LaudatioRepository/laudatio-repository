<?php

namespace App;

class Role extends \Spatie\Permission\Models\Role
{
    public function users(){
        return $this->belongsToMany(User::class);
    }
}