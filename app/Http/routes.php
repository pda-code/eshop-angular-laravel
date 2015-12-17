<?php

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the controller to call when that URI is requested.
    |
    */


    Route::controllers([
        'auth' => '\App\Http\Controllers\Auth\AuthController',
        'password' => '\App\Http\Controllers\Auth\PasswordController',
    ]);


    // Display all SQL executed in Eloquent
    Event::listen('illuminate.query', function ($sql, $bindings) {
        foreach ($bindings as $val) {
            $sql = preg_replace('/\?/', "'{$val}'", $sql, 1);
        }

        //$sql;
        //var_dump($sql);
    });


    Route::get('/hello', function () {
        return '<h1>12</h1>';
    });


    Route::get('/', function () {
        return View::make('front.index');
    });

    //Admin routes
    Route::group(array('prefix' => 'admin', 'namespace' => 'App\\Http\\Admin\\Controllers',), function () {
        Route::get('/', array('uses' => 'AdminController@index'));
    });


    Route::get('/generator', array('uses' => 'GeneratorController@index'));

    Route::get('/createtoken', function () {
        $customer = Customer::whereEmail('pda.clms@gmail.com')->first();
        $token = JWTAuth::fromUser($customer);
        return Response::json($token);
    });

    Route::get('/testtoken', function () {
        $headers1 = Request::header("custom");
        JWTAuth::setRequest(Request::instance());
        $headers2 = JWTAuth::getRequest()->header();


        $token = JWTAuth::getToken();
        return Response::json(JWTAuth::toUser($token));
    });

    Route::get('/testpost', function () {
        $param = \Illuminate\Support\Facades\Input::all();
        $name = $param->name;
        return \Symfony\Component\HttpFoundation\Response::json($param);
    });

    //Front routes
    Route::group(array('prefix' => 'api'), function () {

        // customers
        Route::post('customers/login', array('uses' => 'CustomerController@login'));
        Route::post('customers/logout', array('uses' => 'CustomerController@logout'));
        Route::post('customers/register', array('uses' => 'CustomerController@register'));
        Route::get('customers/new', array('uses' => 'CustomerController@getEmpty'));

        // catalog
        Route::get('catalog/top', array('uses' => 'CatalogController@getTopCategories'));
        Route::get('catalog/top-with-preselection/{id}', array('uses' => 'CatalogController@getTopCategoriesWithPreselection'));
        Route::get('catalog/{id}/categories', array('uses' => 'CatalogController@getSubCategories'));
        Route::get('catalog/{id}/products', array('uses' => 'CatalogController@getProducts'));
        Route::get('catalog/{id}/attributes', array('uses' => 'CatalogController@getCategoryAttributes'));
        Route::get('catalog/products/{id}', array('uses' => 'CatalogController@getProduct'));
        Route::get('catalog/products/{id}/reviews', array('uses' => 'CatalogController@getProductReviews'));
        Route::get('catalog/products/{id}/specs', array('uses' => 'CatalogController@getProductSpecs'));
        Route::get('catalog/compare-products', array('uses' => 'CatalogController@compareProducts'));

        //store
        Route::get('store/flush', function () {
            session::flush();
        });

        Route::get('store/countries-zones', array('uses' => 'StoreController@getCountriesAndZones'));
        Route::get('store/context', array('uses' => 'StoreController@getSettings'));
        Route::put('store/context/changeLanguage', array('uses' => 'StoreController@changeLanguage'));
        Route::put('store/context/changeCurrency', array('uses' => 'StoreController@changeCurrency'));
        Route::get('store/cart/{cart_type}', array('uses' => 'StoreController@getCartContents'));
        Route::post('store/cart/{cart_type}/{id}', array('uses' => 'StoreController@addToCart'));
        Route::delete('store/cart/{cart_type}/{id}', array('uses' => 'StoreController@removeFromCart'));

        //product reviews
        Route::get('reviews', array('uses' => 'ProductReviewController@getAll'));
        Route::post('reviews', array('uses' => 'ProductReviewController@insert'));
        Route::put('reviews/{id}', array('uses' => 'ProductReviewController@update'));

        //countries
        Route::get('countries', array('uses' => 'CountryController@getAll'));
        Route::post('countries', array('uses' => 'CountryController@insert'));
        Route::put('countries/{id}', array('uses' => 'CountryController@update'));

        //zones
        Route::get('zones', array('uses' => 'ZoneController@getAll'));
        Route::post('zones', array('uses' => 'ZoneController@insert'));
        Route::put('zones/{id}', array('uses' => 'ZoneController@update'));

        //address
        Route::get('addresses', array('uses' => 'AddressController@getAll'));
        Route::post('addresses', array('uses' => 'AddressController@insert'));
        Route::put('addresses/{id}', array('uses' => 'AddressController@update'));
        Route::get('addresses/new', array('uses' => 'AddressController@getEmpty'));

        //ShippingMethod
        Route::get('shipping-methods', array('uses' => 'ShippingMethodController@getAll'));
        Route::post('shipping-methods', array('uses' => 'ShippingMethodController@insert'));
        Route::put('shipping-methods/{id}', array('uses' => 'ShippingMethodController@update'));

        //Payment Method
        Route::get('payment-methods', array('uses' => 'PaymentMethodController@getAll'));
        Route::post('payment-methods', array('uses' => 'PaymentMethodController@insert'));
        Route::put('payment-methods/{id}', array('uses' => 'PaymentMethodController@update'));

        //Orders
        Route::get('orders', array('uses' => 'OrderController@getAll'));
        Route::get('orders/checkout-options', array('uses' => 'OrderController@getCheckoutOptions'));
        Route::put('orders/checkout-order', array('uses' => 'OrderController@checkout'));
        Route::post('orders', array('uses' => 'OrderController@insert'));
        Route::put('orders/{id}', array('uses' => 'OrderController@update'));
    });
