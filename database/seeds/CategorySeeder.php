<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
    $categories = [
      ['name'=>'Residential'],
      ['name'=>'Commercial'],
      ['name'=>'Industrial'],
      ['name'=>'Land'],
    ];
    $categoryProgressBar = $this->command->getOutput()->createProgressBar(count($categories));
    foreach ($categories as $category) {
      Category::create($category);
      $categoryProgressBar->advance();
    }
    $categoryProgressBar->finish();
  }
}
