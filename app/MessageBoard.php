<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageBoard extends Model
{
    public function corpusproject() {
        return $this->belongsTo(CorpusProject::class);
    }

    public function boardmessages() {
        return $this->hasMany(BoardMessage::class);
    }
}
