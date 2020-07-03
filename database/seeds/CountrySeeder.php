<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $row = 1;
      if(($handle = fopen(base_path("public/includes/countries.csv"), "r")) !== false){
        $countryProgressBar = $this->command->getOutput()->createProgressBar(247);
        while (($data = fgetcsv($handle, 0, ",")) !== false){
          if($row === 1){
            $row++;
            continue;
          }
          $row++;
          $country = [
            'name' => $data[1],
            'native' => $data[7],
            'iso2' => $data[3],
            'iso3' => $data[2],
            'phone_code' => $data[4],
            'capital' => $data[5],
            'emoji' => $data[8],
            'emojiU' => $data[9],
            'is_allowed' => false,
          ];
          Country::create($country);
          $countryProgressBar->advance();
        }
        fclose($handle);
        $countryProgressBar->finish();
      }
    }
}
