<?php
    use \LaravelBook\Ardent\Ardent;
class TaxService_Test extends TestCase
{
    public $service = null;

    public function setUp()
    {
        parent::SetUp();
        $this->service = new TaxService();
    }

    public function test_apply_tax()
    {
        $zone_Attica = Zone::whereName("Attica")->first();
        $zone_Islands = Zone::whereName("Islands")->first();

        $tax_class_Taxable = TaxClass::whereName("Taxable products")->first();
        $tax_class_NonTaxable = TaxClass::whereName("Non Taxable products")->first();

        //$geoZoneWithFPA23=GeoZone::whereName("Geo Zone with FPA 23%")->first();
        //$geoZoneWithFPA8=GeoZone::whereName("Geo Zone with FPA 8%")->first();
        $taxes = $this->service->calculateTaxes(100, $zone_Attica->id, $tax_class_Taxable->id);
        $this->assertEquals(2, count($taxes));
        print_r($taxes);

        $taxes = $this->service->calculateTaxes(100, $zone_Islands->id, $tax_class_Taxable->id);
        $this->assertEquals(1, count($taxes));
        print_r($taxes);

        $taxes = $this->service->calculateTaxes(100, -90, $tax_class_Taxable->id);
        $this->assertEquals(0, count($taxes));
        print_r($taxes);

        $taxes = $this->service->calculateTaxes(100, $zone_Attica->id, -1);
        $this->assertEquals(0, count($taxes));
        print_r($taxes);

    }

}
