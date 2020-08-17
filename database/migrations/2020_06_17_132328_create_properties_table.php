<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('properties', function (Blueprint $table) {
      $table->uuid('id')->primary()->unique();
      $table->string('title');
      $table->string('price');
      $table->string('images');
      $table->integer('views')->default(0);
      $table->integer('likes')->default(0);
      $table->string('phone');
      $table->string('address');
      $table->uuid('user_id');
      $table->unsignedBigInteger('category_id');
      $table->unsignedBigInteger('subcategory_id');
      $table->unsignedBigInteger('state_id');
      $table->unsignedBigInteger('city_id');
      $table->enum('status',['pending','active','declined','disabled','reported','expired','closed'])->default('active');
      $table->enum('list_as',['rent','sale'])->default('sale');
      $table->enum('plan',['free','distress','featured'])->default('free');
      $table->text('description');
      $table->timestamp('reported_at', 6)->nullable()->default(null);
      $table->timestamp('expires_at', 6)->nullable()->default(null);
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
    Schema::dropIfExists('properties');
  }
}
