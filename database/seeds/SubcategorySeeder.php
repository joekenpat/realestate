<?php

use App\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\support\str;

class SubcategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $subcategories = [
      ['name' => 'Duplex', 'slug' => Str::slug('Duplex'), 'category_id' => 1],
      ['name' => 'High Value', 'slug' => Str::slug('High Value'), 'category_id' => 1],
      ['name' => 'Triple Decker', 'slug' => Str::slug('Triple Decker'), 'category_id' => 1],
      ['name' => 'Condos', 'slug' => Str::slug('Condos'), 'category_id' => 1],
      ['name' => 'Shopping Center', 'slug' => Str::slug('Shopping Center'), 'category_id' => 2],
      ['name' => 'Strip Malls', 'slug' => Str::slug('Strip Malls'), 'category_id' => 2],
      ['name' => 'Medical', 'slug' => Str::slug('Medical'), 'category_id' => 2],
      ['name' => 'Educational', 'slug' => Str::slug('Educational'), 'category_id' => 2],
      ['name' => 'Hotel', 'slug' => Str::slug('Hotel'), 'category_id' => 2],
      ['name' => 'Offices', 'slug' => Str::slug('Offices'), 'category_id' => 2],
      ['name' => 'Ware Houses', 'slug' => Str::slug('Ware Houses'), 'category_id' => 3],
      ['name' => 'Storages', 'slug' => Str::slug('Storages'), 'category_id' => 3],
      ['name' => 'Research', 'slug' => Str::slug('Research'), 'category_id' => 3],
      ['name' => 'Production', 'slug' => Str::slug('Production'), 'category_id' => 3],
      ['name' => 'Vacant', 'slug' => Str::slug('Vacant'), 'category_id' => 4],
      ['name' => 'Farm', 'slug' => Str::slug('Farm'), 'category_id' => 4],

    ];
    $subcategoryProgressBar = $this->command->getOutput()->createProgressBar(count($subcategories));
    foreach ($subcategories as $subcategory) {
      Subcategory::create($subcategory);
      $subcategoryProgressBar->advance();
    }
    $subcategoryProgressBar->finish();
  }
}
