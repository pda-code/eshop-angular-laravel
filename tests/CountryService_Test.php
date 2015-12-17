<?php
    use CodeTrim\Services\CountryService;

    class CountryService_Test extends TestCase
    {
        public $service = null;

        public function setUp()
        {
            parent::SetUp();
            $this->service = new CountryService();
        }

        public function test_getById()
        {
            $item = $this->service->getById(1);
            $this->assertNotNull($item);
        }

        public function test_getAll()
        {
            $items = $this->service->getAll(
                [
                    'columns' => ['id', 'name'],
                    'sorting' => ['name'],
                    'paging' => '3:3',
                    'includes' => ['zones' => [
                        'columns' => ['name', 'country_id'],
                        'sorting'=>['name:desc'],
                        'criteria' => []
                    ]],
                    'criteria' => ['id=84']
                ]
            );

            print_r($items->toArray());
            //print_r(json_encode($items->toArray(),JSON_PRETTY_PRINT));
        }

        public function test_create()
        {

        }

        public function test_destroy()
        {

        }
    }
