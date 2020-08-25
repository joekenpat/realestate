<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
      ['name' => 'Residential', 'slug' => Str::slug('Residential')],
      ['name' => 'Commercial', 'slug' => Str::slug('Commercial')],
      ['name' => 'Industrial', 'slug' => Str::slug('Industrial')],
      ['name' => 'Land', 'slug' => Str::slug('Land')],
    ];
    $categoryProgressBar = $this->command->getOutput()->createProgressBar(count($categories));
    foreach ($categories as $category) {
      Category::create($category);
      $categoryProgressBar->advance();
    }
    $categoryProgressBar->finish();
  }
}
