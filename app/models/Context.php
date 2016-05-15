<?php
    namespace CodeTrim\Models;

    use CodeTrim\Services\CurrencyService;
    use CodeTrim\Services\CustomerService;
    use CodeTrim\Services\LanguageService;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;

    Class Context {
      public $currency = NULL;
      public $language = NULL;
      public $customer = NULL;

      public $currency_id = NULL;
      public $language_id = NULL;
      public $customer_id = NULL;
      public $zone_id = NULL;

      //public $carts = array();

      public $configuration = NULL;

      //maybe there is NO LOGEDIN customer so we must keep seperated these
      //public $billingAddress = null;
      //public $shippingAddress = null;

      public function __construct($language_id, $currency_id, $customer_id) {
        $this->configuration = new StoreConfiguration();
      }


      public function getLanguageId()
      {
        return $this->language_id;
      }

      public function getCurrencyId()
      {
        return $this->currency_id;
      }

      public function getCustomerId()
      {
        return $this->customer_id;
      }

      public function getZoneId()
      {
        return $this->zone_id;
      }


      public function init($language_id, $currency_id, $customer_id) {
        //language and default
        $this->language_id = $language_id;
        if ($this->language_id == NULL) {
          $this->language_id = 1;
        }

        //Currency and default
        $this->currency_id = $currency_id;
        if ($this->currency_id == NULL) {
          $this->currency_id = 3;
        }

        //customer;
        $this->customer_id = $customer_id;

        //Zone on which we will calculate taxes
        $this->zone_id = $this->getActiveZoneId();

        //$this->carts[Cart::SHOPPING_CART] = new Cart(Cart::SHOPPING_CART);
        //$this->carts[Cart::WISHLIST_CART] = new Cart(Cart::WISHLIST_CART);
        //$this->carts[Cart::COMPARE_CART] = new Cart(Cart::COMPARE_CART);
      }

      public function getCurrency() {
        //SOS: $this->currency_id always has a value
        $service = new CurrencyService();
        return $service->getById($this->currency_id);
      }

      public function getLanguage() {
        //SOS: $this->language_id always has a value
        $service = new LanguageService();
        return $service->getById($this->language_id);
      }

      public function getCustomer() {
        if ($this->customer_id == NULL) {
          return NULL;
        }
        else {
          $service = new CustomerService();
          return $service->getById($this->customer_id);
        }
      }

      public function setCustomer($customer) {
        $this->customer = $customer;
      }

      public function changeLanguage($language_id) {
        $app = app();
        $language = $app->languageService->getById($language_id);
        if ($language == NULL) {
          return;
        }
        $this->language = $language;

        $this->save();
      }

      public function changeCurrency($currency_id) {
        $app = app();
        $currency = $app->currencyService->getById($currency_id);
        if ($currency == NULL) {
          return;
        }
        $this->currency = $currency;

        $this->save();
      }

      public function addToCart($cart_type, $quantity, $product) {
        $cart = $this->getCart($cart_type);
        if ($cart === NULL) {
          return;
        }

        //add to cart
        $cart->add($quantity, $product);

        $this->save();
      }

      public function removeFromCart($cart_type, $product_id) {
        $cart = $this->getCart($cart_type);
        if ($cart === NULL) {
          return;
        }

        //add to cart
        $cart->remove($product_id);

        $this->save();
      }

      public function updateCart($cart_type, $quantity, $product_id) {
        $cart = $this->getCart($cart_type);
        if ($cart === NULL) {
          return;
        }

        //add to cart
        $cart->update($product_id, $quantity);

        $this->save();
      }


      private function getActiveZoneId() {
        $base_zone_id = ($this->configuration->zone != NULL) ? $this->configuration->zone->id : NULL;

        switch ($this->configuration->taxBasedOn) {

          //Zone of Store
          case StoreConfiguration::TAX_ON_STORE_ADDRESS:
            return $base_zone_id;
            break;

          //Zone of customer's Billing Address
          case StoreConfiguration::TAX_ON_BILLING_ADDRESS:
            $customer = $this->getCustomer();
            if ($customer == NULL) {
              return $base_zone_id;
            }
            else {
              $this->billingAdress = $customer->defaultAddress;
              $this->shippingAdress = $this->billingAdress;

              if ($this->billingAdress != NULL) {
                return $this->billingAdress->zone_id;
              }
              else {
                return $base_zone_id;
              }
            }
            break;

          //Zone of customer's shipping address
          case StoreConfiguration::TAX_ON_SHIPPING_ADDRESS:
            $customer = $this->getCustomer();

            if ($customer == NULL) {
              return $base_zone_id;
            }
            else {
              $this->billingAdress = $customer->defaultAddress;
              $this->shippingAdress = $this->billingAdress;

              if ($this->shippingAdress != NULL) {
                return $this->shippingAdress->zone_id;
              }
              else {
                return $base_zone_id;
              }
            }
        }
      }

      public function getCart($type) {
        return $this->carts[$type];

        switch ($type) {
          case Cart::SHOPPING_CART:
            return $this->shoppingCart;
            break;
          case Cart::WISHLIST_CART:
            return $this->wishlistCart;
            break;
          case Cart::COMPARE_CART:
            return $this->compareCart;
            break;
          default:
            return NULL;
            break;
        }
      }

      public function save() {
        Session::put("settings", $this);
        if ($this->customer != NULL) {
          DB::table('customers')
            ->where('id', $this->customer->id)
            ->update([
              'cart' => serialize($this->carts[Cart::SHOPPING_CART]),
              'wishlist' => serialize($this->carts[Cart::WISHLIST_CART])
            ]);
        }
      }
    }