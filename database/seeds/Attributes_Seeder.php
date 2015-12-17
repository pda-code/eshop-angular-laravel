<?php

    class Attributes_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All attributes
            DB::table('attributes')->truncate();
            DB::table('attributes_options')->truncate();
            DB::table('attributes_description')->truncate();
            DB::table('attributes_group_description')->truncate();
            DB::table('attributes_group')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();
            $languages = Language::all();
            $products = Product::all();

            // insert attributes
            $doc = new DOMDocument();
            $doc->load(app_path() . "/database/seed_data/attributes.xml");
            $xpath = new DOMXPath($doc);

            foreach ($xpath->evaluate("/groups/group", $doc) as $element) {
                $attributes_group_id = DB::table('attributes_group')->insertGetId([]);

                foreach ($languages as $language)
                    DB::table('attributes_group_description')->insert(array(
                        'attribute_group_id' => $attributes_group_id,
                        'language_id' => $language->id,
                        'name' => $element->getAttribute('title-el')
                    ));

                foreach ($xpath->evaluate("attribute", $element) as $attr) {
                    $attribute_id = DB::table('attributes')->insertGetId(['attribute_group_id' => $attributes_group_id,
                        'data_type'=>$attr->getAttribute('data-type'),
                        'is_filterable'=>true,
                        'is_variant'=>false]);

                    foreach ($languages as $language) {
                        DB::table('attributes_options')->insert(array(
                            'attribute_id' => $attribute_id,
                            'language_id' => $language->id,
                            'options'=>$attr->getAttribute('options-el')
                        ));

                        DB::table('attributes_description')->insert(array(
                            'attribute_id' => $attribute_id,
                            'language_id' => $language->id,
                            'name' => $attr->getAttribute('title-el')
                        ));
                    }
                }
            }
        }
    }