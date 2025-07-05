<?php

use App\Models\Advertisement;
use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_ads', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('link');
            $table->string('status')->default('pending'); // -active -expired
            $table->timestamps();
        });

        // Inserting Default Invoice
        $new = new Advertisement();
        $new->image = "bid2cart-default.png";
        $new->link = "https://www.b2c.com";
        $new->status = "active";
        $new->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_ads');
    }
}
