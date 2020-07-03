<?php

use App\Subcategory;
use Illuminate\Database\Seeder;

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
          ['name'=>'Duplex','category_id'=>1],
          ['name'=>'High Value','category_id'=>1],
          ['name'=>'Triple Decker','category_id'=>1],
          ['name'=>'Condos','category_id'=>1],
          ['name'=>'Shopping Center','category_id'=>2],
          ['name'=>'Strip Malls','category_id'=>2],
          ['name'=>'Medical','category_id'=>2],
          ['name'=>'Educational','category_id'=>2],
          ['name'=>'Hotel','category_id'=>2],
          ['name'=>'Offices','category_id'=>2],
          ['name'=>'Ware Houses','category_id'=>3],
          ['name'=>'Storages','category_id'=>3],
          ['name'=>'Research','category_id'=>3],
          ['name'=>'Production','category_id'=>3],
          ['name'=>'Vacant','category_id'=>4],
          ['name'=>'Farm','category_id'=>4],

        ];
        $subcategoryProgressBar = $this->command->getOutput()->createProgressBar(count($subcategories));
        foreach ($subcategories as $subcategory) {
          Subcategory::create($subcategory);
          $subcategoryProgressBar->advance();
        }
        $subcategoryProgressBar->finish();
    }
}
