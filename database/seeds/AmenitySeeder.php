<?php

use App\Amenity;
use Illuminate\Database\Seeder;

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
          ['name'=>'Garden','category_id'=>1],
          ['name'=>'Swimming Pool','category_id'=>1],
          ['name'=>'Air Condition','category_id'=>1],
          ['name'=>'Parking / Garage','category_id'=>1],
          ['name'=>'Elevator','category_id'=>1],
          ['name'=>'Bathtub','category_id'=>1],
        ];
        $amenityProgressBar = $this->command->getOutput()->createProgressBar(count($amenities));
        foreach ($amenities as $amenity) {
          Amenity::create($amenity);
          $amenityProgressBar->advance();
        }
        $amenityProgressBar->finish();
    }
}
