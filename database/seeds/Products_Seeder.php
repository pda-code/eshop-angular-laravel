<?php

    class Products_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            DB::table('products')->truncate();
            DB::table('products_to_attributes')->truncate();
            DB::table('products_description')->truncate();
            DB::table('products_discount')->truncate();
            DB::table('products_image')->truncate();
            DB::table('products_reward')->truncate();
            DB::table('products_review')->truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();
            $languages = Language::all();
            $categories = Category::all()->toArray();
            $attributes = Attribute::all()->toArray();

            //Insert product
            for ($i_product = 1; $i_product < 1000; $i_product++) {
                $product_id = DB::table('products')->insertGetId(array(
                    'model' => 'Model ' . $i_product,
                    'tax_class_id' => rand(1, 2),
                    'weight_class_id' => rand(1, 4),
                    'length_class_id' => rand(1, 3),
                    'image' => 'catalog/demo/product/product (' . rand(1, 86) . ').jpg',
                    'price' => rand(10, 200),
                    'stock_status_id' => rand(1, 4),
                    'manufacturer_id' => rand(1, 6),
                ));

                //product image
                $images_count = rand(0, 5);
                for ($i = 0; $i < $images_count; $i++) {
                    DB::table('products_image')->insert(array(
                        'product_id' => $product_id,
                        'image' => 'catalog/demo/product/product (' . rand(1, 86) . ').jpg'
                    ));
                }

                foreach ($languages as $language)
                    DB::table('products_description')->insert(array(
                        'product_id' => $product_id,
                        'language_id' => $language->id,
                        'name' => 'Product ' . $product_id,
                        'description' => '#' . $product_id . ' Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
                    ));

                //product reward
                DB::table('products_reward')->insert(array(
                    'product_id' => $product_id,
                    'customer_group_id' => 1,
                    'points' => $product_id,
                ));
          }
        }
    }