<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnToTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('amenities', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
    Schema::table('specifications', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
    Schema::table('posts', function (Blueprint $table) {
      $table->string('slug')->unique()->after('title')->nullable()->default(null);
    });
    Schema::table('subcategories', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
    Schema::table('categories', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
    Schema::table('tags', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
    Schema::table('properties', function (Blueprint $table) {
      $table->string('slug')->unique()->after('title')->nullable()->default(null);
    });
    Schema::table('states', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
    Schema::table('cities', function (Blueprint $table) {
      $table->string('slug')->unique()->after('name')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('amenities', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('specifications', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('posts', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('subcategories', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('categories', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('tags', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('properties', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('states', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
    Schema::table('cities', function (Blueprint $table) {
      $table->dropColumn('slug');
    });
  }
}
