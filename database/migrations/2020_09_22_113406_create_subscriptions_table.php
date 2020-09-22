<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('subscriptions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('subscriber_id');
      $table->unsignedBigInteger('category_id');
      $table->unsignedBigInteger('subcategory_id');
      $table->unsignedBigInteger('state_id');
      $table->timestamp('created_at', 6)->nullable()->default(null);
      $table->timestamp('updated_at', 6)->nullable()->default(null);
      $table->timestamp('deleted_at', 6)->nullable()->default(null);
      $table->foreign('subscriber_id')->references('id')->on('subscribers')->cascadeOnDelete();
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
      $table->foreign('subcategory_id')->references('id')->on('subcategories')->cascadeOnDelete();
      $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('subscriptions');
  }
}
