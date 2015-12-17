<?php

    class Payment_Methods_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('payment_methods')->truncate();
            DB::table('payment_methods_descriptions')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            $payment_method_id = DB::table('payment_methods')->insertGetId(['cost' => 10]);
            DB::table('payment_methods_descriptions')->insert([
                'payment_method_id' => $payment_method_id,
                'language_id' => 1,
                'name' => 'Cash On Delivery'
            ]);

            $payment_method_id = DB::table('payment_methods')->insertGetId(['cost' => 20]);
            DB::table('payment_methods_descriptions')->insert([
                'payment_method_id' => $payment_method_id,
                'language_id' => 1,
                'name' => 'Credit Card'
            ]);

            $payment_method_id = DB::table('payment_methods')->insertGetId(['cost' => 20]);
            DB::table('payment_methods_descriptions')->insert([
                'payment_method_id' => $payment_method_id,
                'language_id' => 1,
                'name' => 'PayPal'
            ]);
        }
    }