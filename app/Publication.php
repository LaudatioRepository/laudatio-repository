<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    /**
     * The roles that belong to the user.
     */
    public function corpora()
    {
        return $this->belongsTo(Corpus::class);
    }


    /**
     * The documents that belong to the publication.
     */
    public function documents()
    {
        return $this->belongsTo(Document::class);
    }
}
