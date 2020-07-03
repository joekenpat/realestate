<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('currencies', function (Blueprint $table) {
      $table->id();
      $table->string('country_iso',2)->nullable()->default(null);
      $table->string('country_iso3',3)->nullable()->default(null);
      $table->string('code',3)->nullable()->default(null);
      $table->string('name',50)->nullable()->default(null);
      $table->string('html_entity',30)->nullable()->default(null);
      $table->string('symbol')->nullable()->default(null);
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
    Schema::dropIfExists('currencies');
  }
}
