<?php

use App\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AmenitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $amenities = [
      ['name' => 'Garden', 'slug' => Str::slug('Garden'), 'category_id' => 1],
      ['name' => 'Swimming Pool', 'slug' => Str::slug('Swimming Pool'), 'category_id' => 1],
      ['name' => 'Air Condition', 'slug' => Str::slug('Air Condition'), 'category_id' => 1],
      ['name' => 'Parking / Garage', 'slug' => Str::slug('Parking / Garage'), 'category_id' => 1],
      ['name' => 'Elevator', 'slug' => Str::slug('Elevator'), 'category_id' => 1],
      ['name' => 'Bathtub', 'slug' => Str::slug('Bathtub'), 'category_id' => 1],
    ];
    $amenityProgressBar = $this->command->getOutput()->createProgressBar(count($amenities));
    foreach ($amenities as $amenity) {
      Amenity::create($amenity);
      $amenityProgressBar->advance();
    }
    $amenityProgressBar->finish();
  }
}
