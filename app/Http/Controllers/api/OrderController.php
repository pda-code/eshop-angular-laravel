<?php
  namespace App\Http\Controllers;

  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use CodeTrim\Services\OrderService;
  use CodeTrim\Services\CountryService;
  use CodeTrim\Services\ZoneService;
  use CodeTrim\Services\ShippingMethodService;
  use CodeTrim\Services\PaymentMethodService;

  use App\Http\Controllers\MyBaseController;
  use \Response;
  use \Request;

  class OrderController extends MyBaseController {
    protected $service = NULL;

    public function __construct() {
      parent::__construct();
      $this->service = new OrderService();
    }

    public function getAll() {
      $params = json_decode(Input::get('params'), TRUE);
      return $this->service->getAll($params);
    }

    public function getById($id) {

    }

    public function insert() {
      $input = Input::all();
      $item = $this->service->create($input);
      return Response::json($item);
      //$validation = Validator::make($input, User::$rules);

      //if ($validation->passes()) {
      //    User::create($input);

      //    return Redirect::route('users.index');
      //}
    }

    public function update($id) {

    }

    public function delete($id) {

    }

    public function getCheckoutOptions() {
      $shipping_method_service = new ShippingMethodService();
      $payment_method_service = new PaymentMethodService();

      $customer = $this->active_settings->getCustomer();
      $zones = [];

      if ($customer != NULL) {
        //load country and zones
        $customer->load('defaultAddress', 'addresses');
      }

      return Response::json([
        'customer' => $customer,
        'shipping_methods' => $shipping_method_service->getAll([
          'sorting' => ['sort_order']
        ], $this->active_settings->language_id),
        'payment_methods' => $payment_method_service->getAll([
          'sorting' => ['sort_order']
        ], $this->active_settings->language_id),
      ]);
    }


    public function checkout() {
      $data = Input::all();
      array_set($data, 'customer_id', $this->active_customer_id);
      array_set($data, 'language_id', $this->active_language_id);
      array_set($data, 'currency_id', $this->active_language_id);

      $order = $this->service->checkout($data);
      if ($order->validationErrors->count() == 0) {
        return Response::json($order);
      }
      else {
        return Response::json($order->validationErrors, 400);
      }
    }
  }


