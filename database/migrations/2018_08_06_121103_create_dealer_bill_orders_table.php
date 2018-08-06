<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealerBillOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_bill_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dealer_bill_id');
            $table->unsignedInteger('order_id');
            $table->string('order_serial_number',20)->nullable();
            $table->float('order_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealer_bill_orders');
    }
}
