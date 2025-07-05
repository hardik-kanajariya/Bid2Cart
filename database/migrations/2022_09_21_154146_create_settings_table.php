<?php

use App\Models\Settings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // $table->string("app_name")->default('Bid2Cart');
            // $table->string("app_logo")->default('');
            // $table->string("app_description")->default('');
            $table->longText("policy");
            $table->longText("terms");
            $table->longText("about_us");
            $table->longText("shipping_info");
            $table->longText("consignments");
            $table->longText("account_suspension");
            // $table->string('bid_time')->default('');
            $table->timestamps();
        });

        // Inserting one dummy records 
        $s = new Settings();
        $s->policy = 'Privacy policy';
        $s->terms = 'Terms & Conditions';
        $s->about_us = 'about us';    
        $s->shipping_info = 'shipping_info';
        $s->consignments = 'consignments';
        $s->account_suspension = 'account_suspension';
        $s->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
