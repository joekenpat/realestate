<?php

use App\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeStatusOnProducts extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // Include old and new enum values
    DB::statement("ALTER TABLE properties MODIFY COLUMN plan ENUM('free', 'vip', 'featured', 'premium', 'distress')");
    // Replace distress with vip
    Property::where('plan', 'distress')->update(['plan' => 'vip']);
    // Delete old values
    DB::statement("ALTER TABLE properties MODIFY COLUMN plan ENUM('free', 'vip', 'featured','premium')");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // Include old and new enum values
    DB::statement("ALTER TABLE properties MODIFY COLUMN plan ENUM('free', 'vip', 'featured', 'premium', 'distress')");
    // Replace distress with vip
    Property::where('plan', 'vip')->update(['plan' => 'distress']);
    // Delete old values
    DB::statement("ALTER TABLE properties MODIFY COLUMN plan ENUM('free', 'distress', 'featured')");
  }
}
