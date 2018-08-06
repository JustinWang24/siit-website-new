<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealerBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->date('start_at');
            $table->date('end_at');
            $table->float('total')->default(0);
            $table->unsignedSmallInteger('status')->default(\App\Models\Dealer\DealerBill::STATUS_PENDING);

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
        Schema::dropIfExists('dealer_bills');
    }
}
