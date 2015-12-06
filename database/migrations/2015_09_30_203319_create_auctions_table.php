<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            //Для категории "Недвижимость"
            $table->string('property_type');
            $table->string('property_material');
            $table->string('property_floors');
            $table->string('property_areas');
            $table->string('property_totalarea');
            $table->string('property_livingarea');

            $table->string('region');
            $table->string('city');
            $table->string('img');
            $table->string('img_min');

            $table->string('status');
            $table->string('guarantee_fee');
            $table->string('starting_price');
            $table->string('bid_price');
            $table->date('data_start');
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
        Schema::drop('auctions');
    }
}
