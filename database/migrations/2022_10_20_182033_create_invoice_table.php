<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('aid'); // Auction ID 
            $table->string('uid'); // User ID 
            $table->string('pid'); // Product ID 
            $table->string('sid'); // Store ID 
            $table->string('bid'); // Bid Amount
            $table->string('invoice_number');
            $table->string('invoice_total');
            $table->string('product_name');
            $table->string('winning_amount');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('pdf')->default('');
            $table->string('acknowledgement')->default('pending'); // accepted\declined
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
        Schema::dropIfExists('invoice');
    }
}
