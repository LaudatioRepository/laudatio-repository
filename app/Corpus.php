<?php

namespace App;


class Corpus extends Model
{

    public function corpusProject(){
        return $this->belongsTo(CorpusProject::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}