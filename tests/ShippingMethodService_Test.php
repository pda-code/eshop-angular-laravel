<?php

    use CodeTrim\Services\ShippingMethodService;
    use CodeTrim\Models\ShippingMethod;

class ShippingMethod_Test extends TestCase {

    public function setUp()
    {
        parent::SetUp();
        $this->service = new \CodeTrim\Services\ShippingMethodService();
    }

	public function test_getById()
    {

        $items=ShippingMethod::leftJoin("shipping_methods_descriptions", function($q)
        {
            $q->where('language_id', '=', '1');
        })->get(['shipping_methods.*','shipping_methods_descriptions.name']);

        $items= $this->service->getAll();

        dd($items);

        //$items=$this->service->getAll(['includes'=>'descriptions', 'criteria'=>[['column'=>'descriptions.language_id','value'=>1]]]);
        //dd(json_encode($items->toArray(),JSON_PRETTY_PRINT));
    }
}
