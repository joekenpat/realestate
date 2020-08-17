<?php

use App\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $SiteConfigs = [
      ['key' => 'logo', 'value' => null],
      ['key' => 'home_slider', 'value' => '[]'],
      ['key' => 'paystack', 'value' => json_encode(["secret"=>"","public"=>""])],
      ['key' => 'property_max_media', 'value' => 10],
      ['key' => 'property_life_span', 'value' => json_encode(["free" => 3, "distress" => 6, "featured" => 12])],
      ['key' => 'property_plan_fee', 'value' => json_encode(["distress" => 0, "featured" => 0])],
    ];
    $SiteConfigProgressBar = $this->command->getOutput()->createProgressBar(count($SiteConfigs));
    foreach ($SiteConfigs as $SiteConfig) {
      SiteConfig::create($SiteConfig);
      $SiteConfigProgressBar->advance();
    }
    $SiteConfigProgressBar->finish();
  }
}
