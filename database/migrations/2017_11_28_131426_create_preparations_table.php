<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreparationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preparations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('preparation_encoding_step')->nullable();
            $table->string('preparation_encoding_style')->nullable();
            $table->string('preparation_encoding_tool')->nullable();
            $table->string('preparation_encoding_full_name')->nullable();
            $table->text('preparation_encoding_description')->nullable();
            $table->string('preparation_encoding_annotation_style')->nullable();
            $table->string('preparation_encoding_segmentation_style')->nullable();
            $table->string('preparation_encoding_segmentation_type')->nullable();
            $table->text('preparation_encoding_segmentation_description')->nullable();
            $table->integer('annotation_id')->nullable();
            $table->integer('corpus_id')->nullable();
            $table->string('gitlab_commit_sha')->nullable();
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
        Schema::dropIfExists('preparations');
    }
}
