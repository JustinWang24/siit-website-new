<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('agent_id')->default(0);

            $table->string('family_name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('previous_name')->nullable();
            $table->string('birthday')->nullable();
            $table->boolean('gender')->default(true);
            $table->string('country_of_citizenship')->nullable();
            $table->string('passport')->nullable();
            $table->string('visa_category')->nullable();
            $table->boolean('disability_required')->default(false);

            $table->string('home_address')->nullable();
            $table->string('province')->nullable();
            $table->string('post_code')->nullable();
            $table->string('country')->nullable();
            $table->string('current_address')->nullable();
            $table->string('province_current')->nullable();
            $table->string('post_code_current')->nullable();
            $table->string('country_current')->nullable();

            $table->string('current_residing')->nullable();
            $table->boolean('is_pr')->default(false);
            $table->string('document_evidence')->nullable();
            $table->string('telephone_country_code')->nullable();
            $table->string('area_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedSmallInteger('form_of_test')->default(0);
            $table->string('form_of_test_other')->nullable();
            $table->string('test_score')->nullable();
            $table->string('test_taken_date')->nullable();
            $table->string('english_proficiency_certificate')->nullable();

            $table->string('course_1')->nullable();
            $table->string('institute_1')->nullable();
            $table->string('date_commenced')->nullable();
            $table->string('date_completed')->nullable();
            $table->string('course_2')->nullable();
            $table->string('institute_2')->nullable();
            $table->string('date_commenced_2')->nullable();
            $table->string('date_completed_2')->nullable();
            $table->boolean('applying_exemptions')->default(false);
            $table->string('applying_exemptions_files')->nullable();
            $table->unsignedSmallInteger('heard_from')->default(0);
            $table->boolean('authorize_to_agent')->default(false);

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
        Schema::dropIfExists('student_profiles');
    }
}
