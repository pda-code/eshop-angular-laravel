<?php

    use CodeTrim\Models\Product;
    use CodeTrim\Services\ProductService;
    use CodeTrim\Models\EloquentRepository;

    class ProductService_Test extends TestCase
    {
        public function setUp()
        {
            parent::SetUp();
            $this->faker = Faker\Factory::create();
            $this->service = new ProductService();
        }

        public function test_repo_getAll()
        {
            $repo = new EloquentRepository(new Product());
            $items = $repo->getAll([
                'columns' => ['id', 'model','price'],
                'sorting' => ['price:desc'],
                'paging' => [1,200],
                'includes' => [
                    'productDescriptions' => [
                        'columns' => ['product_id','language_id','name','description'],
                        'sorting' => ['language_id'],
                        'criteria' => ["language_id=1 and name='Product 816'"]
                    ]],
                'criteria' => ['id>=12']
            ])->getItems();

            $queries = DB::getQueryLog();
            $last_query = end($queries);

            foreach ($items as $item) {

            }

            print_r(json_encode($items, JSON_PRETTY_PRINT));
        }

        public function test_getAll()
        {
            $items = $this->service->getAll([
                'columns'=>['id','model'],
                'page_index' => 1,
                'page_size' =>20000,
                'includes' =>['productDescriptions'],
                'criteria' =>[]
            ])->getItems();

            $queries = DB::getQueryLog();
            $last_query = end($queries);

            foreach($items as $item)
            {

            }

            print_r(json_encode($items,JSON_PRETTY_PRINT));
        }
        public function testGetById()
        {
            $product1 = Product::with("description.language")->find(1); //MacBook price:500
            $this->assertNotNull($product1);
            $this->assertEquals(500, $product1->price);

            $product2 = Product::find(44); //MacBook price:1000
            $this->assertNotNull($product2);
            $this->assertEquals(1000, $product2->price);
        }
    }
