<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->uuid('id')->primary()->unique();
          $table->string('first_name');
          $table->string('last_name');
          $table->string('username')->unique();
          $table->string('phone')->unique();
          $table->string('email')->unique();
          $table->string('avatar')->nullable()->default(null);
          $table->enum('gender',['male','female']);
          $table->string('country');
          $table->boolean('verification_status')->default(false);
          $table->string('city')->nullable()->default(null);
          $table->enum('role',['user','agent','admin','super_admin'])->default('user');
          $table->string('facebook')->nullable()->unique()->default(null);
          $table->string('instagram')->nullable()->unique()->default(null);
          $table->string('google')->nullable()->unique()->default(null);
          $table->string('twitter')->nullable()->unique()->default(null);
          $table->string('oauth_provider')->nullable()->unique()->default(null);
          $table->string('oauth_link')->nullable()->unique()->default(null);
          $table->string('oauth_id')->nullable()->unique()->default(null);
          $table->ipAddress('last_ip');
          $table->string('password');
          $table->string('address')->nullable()->default(null);
          $table->text('bio')->nullable()->default(null);
          $table->rememberToken();
          $table->timestamp('last_login',6)->nullable()->default(null);
          $table->timestamp('activated_at',6)->nullable()->default(null);
          $table->timestamp('blocked_at',6)->nullable()->default(null);
          $table->timestamp('email_verified_at', 6)->nullable();
          $table->timestamp('created_at',6)->nullable()->default(null);
          $table->timestamp('updated_at',6)->nullable()->default(null);
          $table->timestamp('deleted_at',6)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
