<?php

    class Zones_Geo_Zones_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('zones_to_geo_zones')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            $country=Country::whereName("Greece")->first();

            $zoneAttica=Zone::whereName("Attica")->first();
            $zoneIslands=Zone::whereName("Islands")->first();

            $geoZoneWithFPA23=GeoZone::whereName("Geo Zone with FPA 23%")->first();
            $geoZoneWithFPA8=GeoZone::whereName("Geo Zone with FPA 8%")->first();


             DB::table('zones_to_geo_zones')->insert(array(
                    'zone_id' => $zoneAttica->id,
                    'geo_zone_id' => $geoZoneWithFPA23->id
             ));

            DB::table('zones_to_geo_zones')->insert(array(
                'zone_id' => $zoneIslands->id,
                'geo_zone_id' => $geoZoneWithFPA8->id
            ));
        }
    }