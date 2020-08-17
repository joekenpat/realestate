<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('transaction_records', function (Blueprint $table) {
      $table->id();
      $table->string('payment_gateway');
      $table->string('amount');
      $table->enum('status', ['failed', 'pending', 'success'])->default('pending');
      $table->enum('plan',['distress','featured']);
      $table->string('transaction_ref');
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
    Schema::dropIfExists('transaction_records');
  }
}
