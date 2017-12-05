<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{

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
    public function document(){
        return $this->belongsTo(Document::class);
    }


}
