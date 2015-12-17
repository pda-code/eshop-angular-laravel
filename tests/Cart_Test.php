<?php

    use CodeTrim\Models\StoreSettings;
    use CodeTrim\Models\Product;
    use CodeTrim\Models\Cart;
    use CodeTrim\Models\CartItem;

    use CodeTrim\Services\TaxService;
    use CodeTrim\Services\CurrencyService;
    use CodeTrim\Services\LanguageService;
    use CodeTrim\Services\CatalogService;

class Cart_Test extends TestCase {

    private $catalogService;

    private function createSettings()
    {
        $app=app();

        $app->settings=new StoreSettings();
        $app->taxService=new TaxService();
        $app->currencyService=new CurrencyService();
        $app->languageService=new LanguageService();

        $app->settings->currencies=$app->currencyService->getAll();
        $app->settings->languages=$app->languageService->getAll();

        $app->settings->language=$app->languageService->getById(1);
        $app->settings->currency=$app->currencyService->getById(3);
    }

    public function setUp()
    {
        parent::SetUp();

        $this->createSettings();
        $this->catalogService = new CatalogService();
    }

	public function testCart()
    {
        $product1=Product::find(1);
        $product1->price=500;
        $product1->save();

        $product2=Product::find(2);
        $product2->price=1000;
        $product2->save();

        //tax=23+13=33%;
        $product1=$this->catalogService->getCartItem(1); //MacBook price:500

        $this->assertNotNull($product1);
        $this->assertEquals(500,$product1->price);
        $this->assertEquals(665,$product1->price_including_tax);

        $product2=$this->catalogService->getCartItem(2); //MacBook price:1000
        $this->assertNotNull($product2);
        $this->assertEquals(1000,$product2->price);
        $this->assertEquals(1330,$product2->price_including_tax);

        //Add 2 products
        $cart=new Cart(Cart::SHOPPING_CART);
        $cart->add(1,$product1);
        $cart->add(1,$product2);

        $this->assertEquals(1500,$cart->getTotal());
        $this->assertEquals(495,$cart->getTax());
        $this->assertEquals(1995,$cart->getTotalIncludingTax());

        //print
        echo json_encode($cart,JSON_PRETTY_PRINT);

        //Add another 2 quantities
        $cart->add(2,$product1);
        $this->assertEquals(2500,$cart->getTotal());
        $this->assertEquals(825,$cart->getTax());
        $this->assertEquals(3325,$cart->getTotalIncludingTax());

        //Remove 2 quantities
        $cart->update(1,$product1->id);
        $this->assertEquals(1500,$cart->getTotal());
        $this->assertEquals(495,$cart->getTax());
        $this->assertEquals(1995,$cart->getTotalIncludingTax());

        //dummy remove
        $cart->remove(111);
        $cart->remove(222);

        //Remove first
        $cart->remove($product1->id);
        $this->assertEquals(1000,$cart->getTotal());
        $this->assertEquals(330,$cart->getTax());
        $this->assertEquals(1330,$cart->getTotalIncludingTax());

        //Remove second
        $cart->remove($product2->id);
        $this->assertEquals(0,$cart->getTotal());
        $this->assertEquals(0,$cart->getTax());
        $this->assertEquals(0,$cart->getTotalIncludingTax());

        echo json_encode($cart,JSON_PRETTY_PRINT);

        $cart=unserialize(serialize($cart));
        $this->assertEquals(0,$cart->getTotal());
        $this->assertEquals(0,$cart->getTax());
        $this->assertEquals(0,$cart->getTotalIncludingTax());
    }
}
