<?php

    class Products_Review_Seeder extends Seeder
    {
        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            DB::table('products_review')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();
            $faker=Faker\Factory::create();

            $products = Product::all();
            $products->each(function ($product) use ($faker) {

                //product reviews
                $reviews_count = rand(0, 30);
                for ($i = 0; $i < $reviews_count-1; $i++) {
                    DB::table('products_review')->insert(array(
                        'product_id' => $product->id,
                        'author' => $faker->firstName,
                        'title' => $faker->sentence,
                        'text' => $faker->text(),
                        'rating' => rand(1, 5),
                        'approved' => 1,
                        'created_at' => \Carbon\Carbon::createFromDate(rand(2012, 2014), rand(1, 12), rand(1, 29))->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::createFromDate(rand(2012, 2014), rand(1, 12), rand(1, 29))->toDateTimeString()
                    ));
                }
            });
        }
    }