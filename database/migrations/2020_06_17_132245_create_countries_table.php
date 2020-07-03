<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('countries', function (Blueprint $table) {
      $table->id();
      $table->string('iso2', 2)->index();
      $table->string('iso3', 3)->index();
      $table->string('name', 100);
      $table->string('native', 100);
      $table->string('phone_code', 30)->nullable()->default(null);
      $table->string('capital', 100)->nullable()->default(null);
      $table->string('emoji', 50)->nullable()->default(null);
      $table->string('emojiU', 50)->nullable()->default(null);
      $table->boolean('is_allowed')->default(false);
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
    Schema::dropIfExists('countries');
  }
}
