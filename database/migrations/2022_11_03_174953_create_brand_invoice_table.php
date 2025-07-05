<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('auction_id');
            $table->string('brand_name');
            $table->string('invoice_number');
            $table->string('total_purchase');
            $table->string('total_sells');
            $table->string('total_tax');
            $table->string('total_b2c_fee');
            $table->string('profit')->nullable();
            $table->string('loss')->nullable();
            $table->string('pdf');
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
        Schema::dropIfExists('brand_invoice');
    }
}
