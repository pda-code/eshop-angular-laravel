<?php
    use \LaravelBook\Ardent\Ardent;
    use CodeTrim\Services\LanguageService;

class LanguageService_Test extends TestCase
{
    public $service=null;

    public function setUp()
    {
        parent::SetUp();
        $this->service = new LanguageService();
    }

    public function test_getById()
    {
        $item = $this->service->getById(1);
        $this->assertNotNull($item);
    }

    public function test_getAll()
    {
        $items = $this->service->getAll(
            ['columns' => ['id', 'name'],
                'sorting' => ['sort_order'],
                'includes' => [],
                'criteria' => []]
        );

        $this->assertNotNull($items);
        print_r(json_encode($items->toArray(),JSON_PRETTY_PRINT));
    }

    public function test_create()
    {

    }

    public function test_destroy()
    {

    }
}
