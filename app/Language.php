<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * Documents
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function documents()
    {
        return $this->hasMany(Document::class);
    }


    /**
     * Documents
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function annotations()
    {
        return $this->hasMany(Document::class);
    }
}
