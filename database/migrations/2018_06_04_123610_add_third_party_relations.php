<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThirdPartyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('axcelerate_contact_id')->nullable();           // axcelerate 学生 contact 的ID
            $table->string('axcelerate_contact_json')->nullable();         // axcelerate 学生 contact 的 密码
            $table->string('moodle_id')->nullable();                // moodle
            $table->string('moodle_data_json')->nullable();             // moodle
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('axcelerate_course_id')->nullable();           // axcelerate 课程的ID
            $table->string('axcelerate_course_json')->nullable();         // axcelerate 课程的类型
            $table->string('moodle_course_id')->nullable();           // moodle
            $table->string('moodle_course_json')->nullable();         // moodle
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
