<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corpus extends Model
{

    public function corpusProject(){
        return $this->belongsTo(CorpusProject::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}