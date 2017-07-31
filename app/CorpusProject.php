<?php

namespace App;

class CorpusProject extends Model
{
    /**
     * Get the corpora for a Corpus Project
     */
    public function corpora(){
        return $this->hasMany(Corpus::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}