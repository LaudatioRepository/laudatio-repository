<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{

    protected $guarded = array();
    protected $fillable = ['annotation_id', 'file_name','annotation_size_type', 'annotation_size_value','corpus_id'];

    public function annotationvalue()
    {
        return $this->hasOne(AnnotationValue::class);
    }

    /**
     * Editors
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function editors(){
        return $this->belongsToMany(Editor::class);
    }

    /**
     * Annotators
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function annotators(){
        return $this->belongsToMany(Annotator::class);
    }

    /**
     * Preparations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function preparations(){
        return $this->hasMany(Preparation::class);
    }

    /**
     * Documents
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents(){
        return $this->belongsToMany(Document::class);
    }

    /**
     * Corpora
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function corpus(){
        return $this->belongsTo(Corpus::class);
    }

    /**
     * The publications that belong to the Annotation.
     */
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

}
