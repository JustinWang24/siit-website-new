<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreInProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            // For RTO course
            $table->string('passport_expiry_date')->nullable();
            $table->boolean('enrolled_at_siit_previously')->default(false);
            $table->string('siit_student_id')->nullable();
            /**
             * Recognition of Prior Learning (RPL) and/or Current Competencies (RCC)?
             */
            $table->boolean('seeking_credits_transfer')->default(false);
            $table->string('completed_education')->nullable();
            $table->boolean('is_english_your_first_language')->default(false);
            $table->boolean('hold_certificate_of_english_proficiency')->default(false);
            $table->boolean('complete_any_secondary_study')->default(false);
        });

        /**
         * 学生提交的RTO课程的文件保存路径
         */
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->smallInteger('type');    // 提交的文件的类型
            $table->string('path');
            $table->string('name');
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
