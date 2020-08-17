<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_views', function (Blueprint $table) {
          $table->id();
          $table->uuid('property_id');
          $table->uuid('user_id')->nullable()->default(null);
          $table->ipAddress('viewer_ip');
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
        Schema::dropIfExists('property_views');
    }
}
