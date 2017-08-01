<?php

namespace App;


class Corpus extends Model
{

    public function corpusprojects(){
        return $this->belongsToMany(CorpusProject::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}