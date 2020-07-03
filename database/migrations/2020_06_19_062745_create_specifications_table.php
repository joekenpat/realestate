<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specifications', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->unsignedBigInteger('category_id');
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
        Schema::dropIfExists('specifications');
    }
}
