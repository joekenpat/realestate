<?php

use App\Specification;
use Illuminate\Database\Seeder;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specifications = [];
        foreach ($specifications as $specification) {
          Specification::create($specification);
        }
    }
}
