<?php

    class Geo_Zones_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('geo_zones')->truncate();
            DB::table('zones_to_geo_zones')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            DB::table('geo_zones')->insert(array('name' => 'Geo Zone with FPA 23%'));
            DB::table('geo_zones')->insert(array('name' => 'Geo Zone with FPA 8%'));
        }
    }