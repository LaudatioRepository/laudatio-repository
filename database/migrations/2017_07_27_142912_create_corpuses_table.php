<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vid')->nullable();
            $table->text('name');
            $table->text('description');
            $table->string('corpus_size_type')->nullable();
            $table->string('corpus_size_value')->nullable();
            $table->string('directory_path');
            $table->string('file_name')->nullable();
            $table->text('gitlab_group_id')->nullable();
            $table->integer('gitlab_id')->nullable();
            $table->text('gitlab_web_url')->nullable();
            $table->text('gitlab_namespace_path')->nullable();
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
        Schema::dropIfExists('corpuses');
    }
}
