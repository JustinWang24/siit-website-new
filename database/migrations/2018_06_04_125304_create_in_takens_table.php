<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInTakensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_takes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->date('online_date')->nullable();
            $table->date('offline_date')->nullable();

            // 最后操作该项记录的人
            $table->unsignedInteger('last_updated_user_id')->default(0);
            $table->unsignedSmallInteger('type')->default(0);

            $table->string('title')->nullable();    // 入学录取记录名称
            $table->string('code')->nullable();     // 入学录取记录唯一代码
            $table->text('description')->nullable();     // 入学录取记录说明
            $table->text('description_cn')->nullable();     // 入学录取记录说明

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('in_takes');
    }
}
