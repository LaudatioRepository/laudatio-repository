<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnotationValue extends Model
{
    /**
     * Get the annotation that owns the AnnotationValue.
     */
    public function annotation()
    {
        return $this->belongsTo(Annotation::class);
    }
}
