<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorpusFile extends Model
{
    protected $guarded = [];
    /**
     * Authors
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function corpus(){
        return $this->belongsTo(Corpus::class);
    }
}
