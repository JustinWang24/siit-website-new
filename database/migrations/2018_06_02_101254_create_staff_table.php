<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Staff;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('type')->default(Staff::TRAINING_STAFF);
            $table->unsignedInteger('brand_id')->default(0);    // 所属的campus

            $table->string('name');
            $table->string('feature_image');
            $table->string('job_title');
            $table->text('content');

            $table->string('email');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('password')->nullable();

            $table->boolean('status')->default(true);
            $table->string('staff_badge_code')->nullable();
            $table->string('wechat_qrcode')->nullable();
            $table->unsignedSmallInteger('job_group')->nullable();
            $table->unsignedSmallInteger('division')->nullable();


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
        Schema::dropIfExists('staff');
    }
}
