<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    /**
     * The corpora that belong to the user.
     */
    public function corpus()
    {
        return $this->belongsTo(Corpus::class);
    }


    /**
     * The documents that belong to the publication.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documents()
    {
        return $this->belongsTo(Document::class);
    }


    /**
     * The Annotations that belong to the Publication
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function annotations()
    {
        return $this->belongsTo(Document::class);
    }

}
