<?php

namespace App;

class CorpusProject extends Model
{
    /**
     * Get the corpora for a Corpus Project
     */
    public function corpora(){
        return $this->belongsToMany(Corpus::class, "corpus_corpus_project", "corpus_id", "corpus_project_id");
    }

    /**
     * Preparations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function preparations(){
        return $this->hasMany(Preparation::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('role_id');
    }
}