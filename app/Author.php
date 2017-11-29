<?php
namespace App;
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 28.11.17
 * Time: 16:25
 */
class Author extends Person
{
    /**
     * documents
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents(){
        return $this->belongsToMany(Document::class);
    }
}