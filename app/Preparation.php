<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{
    /**
     * Get the annotation that owns the comment.
     */
    public function annotation()
    {
        return $this->belongsTo(Annotation::class);
    }

    public function corpusprojects()
    {
        return $this->belongsToMany(CorpusProject::class)->withPivot('corpus_id');
    }
}
