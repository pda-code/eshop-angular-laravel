<?php
  namespace App\Http\Controllers;

  use CodeTrim\Services\CustomerService;
  use \CodeTrim\Models\Customer;
  use \CodeTrim\Models\Cart;

  use App\Http\Controllers\MyBaseController;
  use \Response;
  use \Request;

  class CustomerController extends MyBaseController {
    protected $service = NULL;

    public function __construct() {
      parent::__construct();
      $this->service = new CustomerService();
    }

    public function logout() {
      $this->active_settings->customer_id = NULL;
      //$this->settings->save();
    }

    public function login() {
      $credentials = Input::only(['email', 'password']);

      $validator = Validator::make(
        $credentials,
        array(
          'email' => 'required|email',
          'password' => 'required|min:4'
        )
      );

      //validation
      if ($validator->fails()) {
        return Response::json($validator->messages(), 400);
      }

      if (!$token = JWTAuth::attempt($credentials)) {
        return Response::json(array('error' => array('message' => 'Authentication failed')), 401);
      }


      try {
        $customer = JWTAuth::toUser($token);
      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        // token has expired
        return Response::json(array('error' => array('message' => 'Token expired')), 401);
      }

      if (!$customer) {
        return Response::json(array('error' => array('message' => 'customer not found')), 404);
      }

      $this->active_settings->customer = $customer;

      $cart = NULL;
      $wishlist = NULL;
      try {
        $cart = unserialize($customer->cart);
      } catch (Exception $e) {
      };
      try {
        $wishlist = unserialize($customer->wishlist);
      } catch (Exception $e) {
      };

      if ($cart == NULL) {
        $cart = new Cart(Cart::SHOPPING_CART);
      }
      if ($wishlist == NULL) {
        $wishlist = new Cart(Cart::WISHLIST_CART);
      }

      //Import from session
      //$cart->import($this->active_settings->carts[Cart::SHOPPING_CART]);
      //$wishlist->import($this->active_settings->carts[Cart::WISHLIST_CART]);

      //$this->active_settings->carts[Cart::SHOPPING_CART] = $cart;
      //$this->active_settings->carts[Cart::WISHLIST_CART] = $wishlist;
      //$this->active_settings->save();

      return Response::json(array(
        'auth_token' => $token,
        'customer' => $customer,
        'shoppingCart' => $cart,
        'wishList' => $wishlist
      ));
    }

    public function getById($id) {
      return $this->service->getById($id);
    }

    public function register() {
      $attributes = Input::only([
        'first_name',
        'last_name',
        'email',
        'password',
        'password_confirmation',
        'newsletter'
      ]);
      array_set($attributes, 'approved', TRUE);
      array_set($attributes, 'status', TRUE);
      array_set($attributes, 'ip', Request::getClientIp());

      $customer = $this->service->register($attributes);
      if ($customer->validationErrors->count() == 0) {
        return Response::json($customer);
      }
      else {
        return Response::json($customer->validationErrors, 400);
      }
    }

    public function getEmpty() {
      $faker = \Faker\Factory::create();
      $data = [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'password' => $faker->password,
        'password_confirmation' => $faker->password,
        'newsletter' => TRUE
      ];
      $data['password_confirmation'] = $data['password'];

      return Response::json($data);
    }

    public function update($id) {
      $attributes = Input::all();
      return $this->service->update($id, $attributes);
    }

    public function destroy($id) {
      $this->service->destroy($id);
    }
  }