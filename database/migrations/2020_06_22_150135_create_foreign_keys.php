<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
      $table->foreign('subcategory_id')->references('id')->on('subcategories')->cascadeOnDelete();
      $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
      $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
    });

    Schema::table('subcategories', function (Blueprint $table) {
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
    });

    Schema::table('cities', function (Blueprint $table) {
      $table->foreign('state_code')->references('code')->on('states')->cascadeOnDelete();
    });

    Schema::table('posts', function (Blueprint $table) {
      $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    });

    Schema::table('amenities', function (Blueprint $table) {
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
    });

    Schema::table('specifications', function (Blueprint $table) {
      $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
    });

    Schema::table('product_user', function (Blueprint $table) {
      $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
      $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    });

    Schema::table('product_tag', function (Blueprint $table) {
      $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
      $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
    });

    Schema::table('amenity_product', function (Blueprint $table) {
      $table->foreign('amenity_id')->references('id')->on('amenities')->cascadeOnDelete();
      $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
    });

    Schema::table('product_specification', function (Blueprint $table) {
      $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
      $table->foreign('specification_id')->references('id')->on('specifications')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->dropForeign('user_id');
      $table->dropForeign('category_id');
      $table->dropForeign('subcategory_id');
      $table->dropForeign('state_id');
      $table->dropForeign('city_id');
    });

    Schema::table('subcategories', function (Blueprint $table) {
      $table->dropForeign('category_id');
    });

    Schema::table('cities', function (Blueprint $table) {
      $table->dropForeign('state_code');
    });

    Schema::table('post', function (Blueprint $table) {
      $table->dropForeign('user_id');
    });

    Schema::table('product_user', function (Blueprint $table) {
      $table->dropForeign('category_id');
      $table->dropForeign('user_id');
    });

    Schema::table('product_tag', function (Blueprint $table) {
      $table->dropForeign('product_id');
      $table->dropForeign('tag_id');
    });

    Schema::table('amenity_product', function (Blueprint $table) {
      $table->dropForeign('amenity_id');
      $table->dropForeign('product_id');
    });

    Schema::table('product_specification', function (Blueprint $table) {
      $table->dropForeign('product_id');
      $table->dropForeign('specification_id');
    });
  }
}
