<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = array();
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'oauth_id', 'avatar','password','uid'
    ];

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
     * Annotations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function annotations(){
        return $this->belongsToMany(Annotation::class);
    }

    /**
     * The publications that belong to the Document.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * Authors
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function corpus(){
        return $this->belongsTo(Corpus::class);
    }
}
