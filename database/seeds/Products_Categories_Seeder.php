<?php
    class Products_Categories_Seeder extends Seeder
    {
        private function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            DB::table('products_to_categories')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();
            $languages = Language::all();
            $products = Product::all();
            $categories = Category::all();
            $categories_array = $categories->toArray();

            $products->each(function ($product) use ($categories_array) {

                // product to categories
                DB::table('products_to_categories')->insert(array(
                    'product_id' => $product->id,
                    'category_id' => $categories_array[rand(0, count($categories_array) - 1)]['id']
                ));

            });
        }
    }