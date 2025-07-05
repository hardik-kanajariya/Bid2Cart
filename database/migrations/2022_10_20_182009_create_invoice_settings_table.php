<?php

use App\Models\InvoiceSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('tax');
            $table->integer('b2c_fee');
            $table->timestamps();
        });

        // Inserting one Default Record 
        $new = new InvoiceSettings();
        $new->tax = 10;
        $new->b2c_fee = 10;
        $new->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_settings');
    }
}
