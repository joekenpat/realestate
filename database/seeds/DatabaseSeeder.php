<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(CategorySeeder::class);
    $this->call(SubcategorySeeder::class);
    $this->call(AmenitySeeder::class);
    $this->call(StateSeeder::class);
    $this->call(SiteConfigSeeder::class);
    $this->call(CitySeeder::class);
    // $this->call(SpecificationSeeder::class);
    // $this->call(TagSeeder::class);
  }
}
