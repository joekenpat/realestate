<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $row = 1;
      $states = [];
      if(($handle = fopen(base_path("public/includes/states.csv"), "r")) !== false){
        $stateProgressBar = $this->command->getOutput()->createProgressBar(4856);
        while (($data = fgetcsv($handle, 0, ",")) !== false){
          if($row === 1){
            $row++;
            continue;
          }
          $row++;
          $state = [
            'name' => $data[1],
            'code' => $data[4],
            'country_iso2' => $data[3],
            'created_at'=> now()->format('Y-m-d H:i:s.u'),
            'updated_at'=> now()->format('Y-m-d H:i:s.u'),
            'deleted_at'=> null,
          ];
          $states [] = $state;
          if(($row % 100 == 0) || ($row == 4856)){
            DB::table('states')->insert($states);
            $states = [];
          }
          $state = [];
          $stateProgressBar->advance();
        }
        fclose($handle);
        $stateProgressBar->finish();
      }
    }
}
