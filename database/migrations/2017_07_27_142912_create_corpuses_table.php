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
            $table->string('name');
            $table->text('description');
            $table->string('corpus_size_type')->nullable();
            $table->string('corpus_size_value')->nullable();
            $table->string('directory_path');
            $table->text('gitlab_group_id')->nullable();
            $table->integer('gitlab_id')->nullable();
            $table->text('gitlab_web_url')->nullable();
            $table->text('gitlab_namespace_path')->nullable();
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
