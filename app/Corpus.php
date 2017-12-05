<?php

namespace App;


class Corpus extends Model
{

    public function corpusprojects(){
        return $this->belongsToMany(CorpusProject::class);
    }

    /**
     * Editors
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function editors(){
        return $this->belongsToMany(Editor::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('role_id');
    }

    /**
     * The publications that belong to the Corpus.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * The documents that belong to the Corpus.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Annotations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function annotations(){
        return $this->hasMany(Annotation::class);
    }
}