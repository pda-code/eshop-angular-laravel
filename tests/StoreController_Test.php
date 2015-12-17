<?php

    class StoreController_Test extends TestCase
    {

        private $catalogService;

        private function createSettings()
        {
            $app = app();

            $app->settings = new StoreSettings();
            $app->taxService = new TaxService();
            $app->taxService->setTaxPercent(20); //20%
            $app->currencyService = new CurrencyService();
            $app->languageService = new LanguageService();

            $app->settings->currencies = $app->currencyService->getAll();
            $app->settings->languages = $app->languageService->getAll();

            $app->settings->language = $app->languageService->getById(1);
            $app->settings->currency = $app->currencyService->getById(3);
        }

        public function setUp()
        {
            parent::SetUp();

            $this->createSettings();
            $this->catalogService = new CatalogService();
        }

        public function testWorkflow()
        {
            $customer = Customer::whereEmail('pda.clms@gmail.com')->first();
            $customer->cart=null;
            $customer->wishlist=null;

            $token = JWTAuth::fromUser($customer);

            //Initial get without login
            $response = $this->call('GET', '/');
            $app = app();

            $shoppingCart = $app->settings->carts[Cart::SHOPPING_CART];
            $this->assertEquals(0, count($shoppingCart->items));

            $response = $this->action('POST', 'StoreController@addToCart', array('cart_type' => Cart::SHOPPING_CART,
                'product_id' => 43,
                'quantity' => 1));

            $response = $this->call('GET', '/');

            $response = $this->action('POST', 'StoreController@addToCart', array('cart_type' => Cart::SHOPPING_CART,
                'product_id' => 44,
                'quantity' => 1));

            $this->assertEquals(2, count($shoppingCart->items));

            //login
            $response = $this->call('GET', '/',[],[],array('HTTP_authorization' => 'bearer ' . $token));
            $this->assertEquals(2, count($shoppingCart->items));
        }
    }
