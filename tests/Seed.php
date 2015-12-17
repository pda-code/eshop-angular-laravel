<?php

    class Seed extends TestCase
    {
        public function setUp()
        {
            parent::SetUp();
        }


        public function test_seed()
        {
            $seeder=new Shipping_Methods_Seeder();
            $seeder->run();

            $seeder=new Payment_Methods_Seeder();
            $seeder->run();

            return;
            $seeder=new Geo_Zones_Seeder();
            $seeder->run();

            $seeder=new Zones_Geo_Zones_Seeder();
            $seeder->run();

            $seeder=new Tax_Rates_Seeder();
            $seeder->run();

            $seeder=new Tax_Classes_Seeder();
            $seeder->run();

            $seeder=new Attributes_Seeder();
            $seeder->run();

            $seeder=new Categories_Seeder();
            $seeder->run();

            $seeder=new Products_Seeder();
            $seeder->run();

            $seeder=new Products_Attributes_Seeder();
            $seeder->run();

            $seeder=new Products_Review_Seeder();
            $seeder->run();

            $seeder=new Products_Categories_Seeder();
            $seeder->run();
        }
    }
