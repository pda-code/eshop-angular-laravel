<?php

    class Application extends TestCase {

        public function testAppBind()
        {
            $app=app();
            $app->bind('tmp',function($app){
                return new Cart(Cart::SHOPPING_CART);
            }) ;


            $cart=App::make('tmp');
            $this->assertNotNull($cart);
            $this->assertNotNull($app['tmp']);
            $this->assertNotNull($app->tmp);
        }

        public function testAppBindSingleton()
        {
            $app=app();
            App::singleton('tmp',function($app){
                $var=new stdClass();
                $var->total=10;
                return $var;
            }) ;


            $cart1=App::make('tmp');
            $cart2=App::make('tmp');

            $this->assertEquals(10,$cart1->total);
            $this->assertEquals(10,$cart2->total);
            $this->assertEquals($cart1,$cart2);
        }

        public function testAppBoot()
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

            $this->assertEquals(1,$app->settings->language->language_id);
            $this->assertEquals(3,$app->settings->currency->currency_id);

            $catalogService = new CatalogService();
            $app->settings->carts[Cart::SHOPPING_CART]->add(1,$catalogService->getCartItem(43)); //MacBook price:500)
            $app->settings->carts[Cart::SHOPPING_CART]->add(1,$catalogService->getCartItem(44)); //MacBook Air price:1000)

            //Save to Session
            $app->settings->save();

            //Restore From session
            $app->settings = Session::get("settings");
            $this->assertEquals(1,$app->settings->language->language_id);
            $this->assertEquals(3,$app->settings->currency->currency_id);
            $this->assertEquals(3,count($app->settings->carts[Cart::SHOPPING_CART]->items)==2);

            $cart_items=$app->settings->carts[Cart::SHOPPING_CART]->items;
            $this->assertEquals(43,$app->settings->carts[Cart::SHOPPING_CART]->items[43]->product->product_id);
            $this->assertEquals(44,$app->settings->carts[Cart::SHOPPING_CART]->items[44]->product->product_id);
        }




    }
