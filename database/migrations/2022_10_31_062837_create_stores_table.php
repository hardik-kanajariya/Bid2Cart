<?php

use App\Models\Stores;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('phone');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country')->default('canada');
            $table->string('status')->default('open'); // closed
            $table->timestamps();
        });

        // $new = new Stores();
        // $new->store_name = "Bid2Cart";
        // $new->phone = "9638527410";
        // $new->street = "somewhere";
        // $new->city = "ontario";
        // $new->state = "toronto";
        // $new->pincode = "361350";
        // $new->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
