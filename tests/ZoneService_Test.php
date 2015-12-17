<?php
    use \LaravelBook\Ardent\Ardent;
class ZoneService_Test extends TestCase
{
    public $service=null;

    public function setUp()
    {
        parent::SetUp();
        $this->service = new ZoneService();
    }

    public function test_getById()
    {
        //1280=Attica
        $item = $this->service->getById(1280);
        $this->assertNotNull($item);

        $items=$item->geoZones;

        foreach($item->geoZones as $geozone){
            print $geozone->name;
        }

        $this->assertNotNull($item->geoZones);
    }

    public function test_getAll()
    {
        $items = $this->service->getAll(
            ['includes' =>['country','geoZones'],
             'page_size'=>1]
        );

        $this->assertNotNull($items);
        print_r($items->toArray());
    }

    public function test_create()
    {

    }

    public function test_destroy()
    {

    }
}
