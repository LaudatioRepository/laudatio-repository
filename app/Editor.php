<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 28.11.17
 * Time: 16:34
 */

namespace App;


class Editor extends Person
{

    /**
     * corpora
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function corpora(){
        return $this->belongsToMany(Corpus::class);
    }

    /**
     * documents
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents(){
        return $this->belongsToMany(Document::class);
    }

    /**
     * annotations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function annotations(){
        return $this->belongsToMany(Annotation::class);
    }
}