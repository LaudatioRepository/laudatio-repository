<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpusCorpusProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpus_corpus_project', function (Blueprint $table) {
            $table->integer('corpus_id');
            $table->integer('corpus_project_id');
            $table->primary(['corpus_id','corpus_project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corpus_corpus_project');
    }
}
