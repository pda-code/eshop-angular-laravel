<?php

    class Tax_Classes_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('tax_classes')->truncate();
            DB::table('tax_rules')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            $tax_rate_23 = TaxRate::whereName("FPA 23%")->first();
            $tax_rate_8 = TaxRate::whereName("FPA 8%")->first();


            $tax_class_id = DB::table('tax_classes')->insertGetId(array('name' => "Taxable products",'description' => "Taxable products"));
            DB::table('tax_rules')->insert(array('tax_class_id' => $tax_class_id,'tax_rate_id' => $tax_rate_23->id));
            DB::table('tax_rules')->insert(array('tax_class_id' => $tax_class_id,'tax_rate_id' => $tax_rate_8->id));

            $tax_class_id = DB::table('tax_classes')->insertGetId(array('name' => "Non Taxable products",'description' => "Non Taxable products"));
        }
    }