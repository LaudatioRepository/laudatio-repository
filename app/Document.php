<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Editors
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function editors(){
        return $this->belongsToMany(Editor::class);
    }

    /**
     * Authors
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    /**
     * The publications that belong to the Document.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
}
