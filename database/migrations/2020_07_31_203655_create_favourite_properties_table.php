<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouritePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourite_properties', function (Blueprint $table) {
          $table->id();
          $table->uuid('property_id');
          $table->uuid('user_id');
          $table->timestamp('created_at', 6)->nullable()->default(null);
          $table->timestamp('updated_at', 6)->nullable()->default(null);
          $table->timestamp('deleted_at', 6)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourite_properties');
    }
}
