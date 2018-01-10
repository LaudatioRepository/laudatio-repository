<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vid')->nullable();
            $table->string('file_name')->nullable();
            $table->string('annotation_id')->nullable();
            $table->string('annotation_group')->nullable();
            $table->string('annotation_size_type')->nullable();
            $table->string('annotation_size_value')->nullable();
            $table->integer('corpus_id')->nullable();
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
        Schema::dropIfExists('annotations');
    }
}
