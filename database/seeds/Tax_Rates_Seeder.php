<?php

    class Tax_Rates_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('tax_rates')->truncate();
            DB::table('tax_rules')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            $geoZoneWithFPA23 = GeoZone::whereName("Geo Zone with FPA 23%")->first();
            $geoZoneWithFPA8 = GeoZone::whereName("Geo Zone with FPA 8%")->first();

            DB::table('tax_rates')->insert(array('name' => 'FPA 23%', 'geo_zone_id' => $geoZoneWithFPA23->id, 'rate' => 23));
            DB::table('tax_rates')->insert(array('name' => 'FPA 8%', 'geo_zone_id' => $geoZoneWithFPA8->id, 'rate' => 8));
        }
    }