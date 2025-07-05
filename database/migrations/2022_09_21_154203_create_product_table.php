<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('prd_id');
            $table->string('auction_id');
            $table->string('category_id');
            $table->string('brand_name')->default('bid2cart');
            $table->string('title', 999);
            $table->string('thumbnail', 999);
            $table->json('images');
            $table->string('website', 999)->default("");
            $table->integer('condition_rating');
            $table->mediumText('condition_desc')->nullable();
            $table->string('condition_note', 999)->default('None');
            $table->string('sku', 20)->unique();
            $table->string('minimum_bid')->default('1');
            $table->string('purchase_price')->default('1');
            $table->string('retail_value')->default('1');
            $table->string('current_bid')->default('1');
            $table->string('auction_status')->default('active');
            $table->string('start_time')->default('');
            $table->string('end_time')->default('');
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
        Schema::dropIfExists('product');
    }
}
