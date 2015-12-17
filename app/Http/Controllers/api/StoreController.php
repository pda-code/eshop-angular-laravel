<?php
  namespace App\Http\Controllers;

  use App\Http\Controllers\MyBaseController;

  use CodeTrim\Services\CatalogService;
  use CodeTrim\Services\CurrencyService;
  use CodeTrim\Services\LanguageService;
  use CodeTrim\Services\CountryService;
  use CodeTrim\Services\ZoneService;

  use CodeTrim\Models\Currency;
  use CodeTrim\Models\Language;
  use CodeTrim\Models\Address;
  use CodeTrim\Models\Customer;

  use \Response;
  use \Request;
  use Context;

  class StoreController extends MyBaseController {

    public function __construct() {
      parent::__construct();
    }

    public function getSettings() {
      return Response::json([
        'currency' => Context::getCurrency(),
        'language' => Context::getLanguage(),
        'customer' => Context::getCustomer(),
        'currencies' => with(new CurrencyService())->getAll(['sorting' => ['sort_order']]),
        'languages' => with(new LanguageService())->getAll(['sorting' => ['sort_order']])
      ]);
    }

    public function getCountriesAndZones() {
      $coutnry_service = new CountryService();
      $countries = $coutnry_service->getAll([
        'columns' => ['id', 'name'],
        'sort_column' => 'name'
      ]);

      $zone_service = new ZoneService();
      $zones = $zone_service->getAll([
        'columns' => ['id', 'name', 'country_id'],
        'sort_column' => 'name'
      ])->toArray();


      return Response::json([
        'countries' => $countries,
        'zones' => $zones
      ]);
    }


    public function changeLanguage() {
      $id = Input::get("id");
      $this->settings->changeLanguage($id);
      return Response::json($this->settings->language);
    }

    public function changeCurrency() {
      $id = Input::get("id");
      $this->settings->changeCurrency($id);
      return Response::json($this->settings->currency);
    }

    public function addToCart($cart_type, $id) {
      //paremeters
      $quantity = Input::get('quantity');
      if ($quantity == NULL) {
        $quantity = 1;
      }

      //product
      $product = $this->catalogService->getCartItem($id);
      if (!$product) {
        return;
      }

      $this->settings->addToCart($cart_type, $quantity, $product);

      return Response::json($this->settings->getCart($cart_type));
    }

    public function removeFromCart($cart_type, $id) {
      $this->settings->removeFromCart($cart_type, $id);

      return Response::json($this->settings->getCart($cart_type));
    }


    public function updateCart($cart_type, $id) {
      //paremeters
      $quantity = Input::get('quantity');

      $this->settings->updateCart($cart_type, $quantity, $id);

      return Response::json($this->settings->getCart($cart_type));
    }

    public function getCartContents($cart_type) {
      $cart = $this->settings->getCart($cart_type);
      if ($cart === NULL) {
        return NULL;
      }

      return Response::json($cart);
    }

  }


