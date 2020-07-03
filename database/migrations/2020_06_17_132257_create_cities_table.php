<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cities', function (Blueprint $table) {
      $table->id();
      $table->string('name',100)->nullable()->default(null);
      $table->string('state_code',10)->nullable()->default(null);
      $table->string('country_iso2',2)->nullable()->default(null);
      $table->string('latitude')->nullable()->default(null);
      $table->string('longtitude')->nullable()->default(null);
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
    Schema::dropIfExists('cities');
  }
}
