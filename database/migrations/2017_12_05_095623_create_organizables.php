<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizables', function (Blueprint $table) {
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger("organizable_id");
            $table->string("organizable_type");
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('organizables');
    }
}
