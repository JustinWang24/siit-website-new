<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntakeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intake_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('in_take_id');
            $table->unsignedSmallInteger('language_id');
            $table->unsignedInteger('seats')->nullable();
            $table->unsignedInteger('enrolment_count')->nullable();
            $table->date('scheduled')->nullable();
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
        Schema::dropIfExists('intake_items');
    }
}
