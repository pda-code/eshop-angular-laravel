<?php
  namespace App\Http\Controllers;

  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use CodeTrim\Services\AddressService;
  use CodeTrim\Services\CountryService;
  use Illuminate\Support\Facades\Input;

  use App\Http\Controllers\MyBaseController;
  use \Response;
  use \Request;

  class AddressController extends MyBaseController {
    protected $service = NULL;

    public function __construct() {
      $this->service = new AddressService();
    }

    public function getEmpty() {
      $country_service = new CountryService();
      $country = $country_service->getById(84);
      $zones = $country->zones->toArray();

      $faker = \Faker\Factory::create();
      $data = [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'company' => $faker->company,
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'country_id' => $country->id,
        'zone_id' => $zones[rand(0, count($zones) - 1)]['id']
      ];

      return Response::json($data);
    }

    public function getAll() {
      $params = Input::all();
      return $this->service->getAll($params);
    }

    public function getById($id, $includes = []) {
      return $this->service->getById($id, $includes);
    }

    public function insert() {
      $attributes = Input::all();
      $item = $this->service->create($attributes);

      if ($item->validationErrors->count() == 0) {
        return Response::json($item);
      }
      else {
        return Response::json($item->validationErrors, 400);
      }

      return Response::json($item);
    }

    public function update($id) {
      $attributes = Input::all();
      $item = $this->service->update($id, $attributes);

      if ($item->validationErrors->count() == 0) {
        return Response::json($item);
      }
      else {
        return Response::json($item->validationErrors, 400);
      }
    }

    public function delete($id) {
      $this->service->destroy($id);
    }
  }


