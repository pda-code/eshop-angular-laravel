<?php

    class Shipping_Methods_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('shipping_methods')->truncate();
            DB::table('shipping_methods_descriptions')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            $shipping_method_id = DB::table('shipping_methods')->insertGetId(['cost' => 10]);
            DB::table('shipping_methods_descriptions')->insert([
                'shipping_method_id' => $shipping_method_id,
                'language_id' => 1,
                'name' => 'Flat Rate'
            ]);

            $shipping_method_id = DB::table('shipping_methods')->insertGetId(['cost' => 20]);
            DB::table('shipping_methods_descriptions')->insert([
                'shipping_method_id' => $shipping_method_id,
                'language_id' => 1,
                'name' => 'Acs Courier'
            ]);
        }
    }