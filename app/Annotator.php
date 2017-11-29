<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotator extends Person
{

    /**
     * annotations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function annotations(){
        return $this->belongsToMany(Annotation::class);
    }
}
