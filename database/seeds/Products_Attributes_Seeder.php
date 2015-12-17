<?php

    class Products_Attributes_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            DB::table('products_to_attributes')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();
            $faker = Faker\Factory::create();

            $languages = Language::all();
            $products = Product::all();

            $attributes = Attribute::all();

            $attributes_options = array();
            foreach ($languages as $language) {
                $options = DB::table('attributes_options')
                    ->whereLanguageId($language->id)->get();

                $options = new Illuminate\Database\Eloquent\Collection($options);
                $options = $options->lists("options", 'attribute_id');

                $attributes_options[$language->id] = $options;
            }

            $attributes_key = $attributes->modelKeys();
            $products->each(function ($product) use ($attributes_key, $languages, $faker, $attributes_options) {

                $count_to_insert = rand(0, rand(0, count($attributes_key) - 1));

                for ($i = 1; $i <= $count_to_insert; $i++) {

                    foreach ($languages as $language) {
                        $attribute_id = $attributes_key[rand(0, count($attributes_key) - 1)];
                        $options = $attributes_options[$language->id][$attribute_id];
                        $tokens = explode("|", $options);
                        try {
                            DB::table('products_to_attributes')->insert(array(
                                'product_id' => $product->id,
                                'language_id' => $language->id,
                                'attribute_id' => $attribute_id,
                                'value' => $tokens[rand(0, count($tokens) - 1)]
                            ));
                        } catch (Exception $x) {
                            var_dump($x);
                        }

                    }
                }
            });
        }
    }