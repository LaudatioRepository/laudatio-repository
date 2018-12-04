<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vid')->nullable();
            $table->integer('uid')->nullable();
            $table->text('title');
            $table->string('file_name')->nullable();
            $table->string('document_genre')->nullable();
            $table->string('document_size_type')->nullable();
            $table->string('document_size_value')->nullable();
            $table->string('document_id')->nullable();
            $table->integer('corpus_id')->nullable();
            $table->string('elasticsearch_id')->nullable();
            $table->string('elasticsearch_index')->nullable();
            $table->string('publication_version')->nullable();
            $table->string('directory_path')->nullable();
            $table->string('gitlab_commit_sha')->nullable();
            $table->dateTime('gitlab_commit_date')->nullable();
            $table->text('gitlab_commit_description')->nullable();
            $table->string('gitlab_version_tag')->nullable();
            $table->integer('workflow_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
