<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $row = 1;
      $cities = [];
      if(($handle = fopen(base_path("public/includes/cities.csv"), "r")) !== false){
        $cityProgressBar = $this->command->getOutput()->createProgressBar(142146);
        while (($data = fgetcsv($handle, 0, ",")) !== false){
          if($row === 1){
            $row++;
            continue;
          }
          $row++;
          $city = [
            'name' => $data[1],
            'state_code' => $data[3],
            'country_iso2' => $data[5],
            'latitude' => $data[6],
            'longtitude' => $data[7],
            'created_at'=> now()->format('Y-m-d H:i:s.u'),
            'updated_at'=> now()->format('Y-m-d H:i:s.u'),
            'deleted_at'=> null,
          ];
          $cities [] = $city;
          if(($row % 1000 == 0) || ($row == 142146)){
            DB::table('cities')->insert($cities);
            $cities = [];
          }
          $city = [];
          $cityProgressBar->advance();
        }
        fclose($handle);
        $cityProgressBar->finish();
      }
    }
}
