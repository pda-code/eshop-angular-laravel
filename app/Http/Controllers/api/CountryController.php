<?php
  namespace App\Http\Controllers;

  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use CodeTrim\Services\CountryService;

  use App\Http\Controllers\MyBaseController;
  use \Response;
  use \Request;


  class CountryController extends MyBaseController {
    protected $service = NULL;

    public function __construct() {
      $this->service = new CountryService();
    }

    public function getAll() {
      $params = json_decode(Input::get('params'), TRUE);
      return $this->service->getAll($params);
    }

    public function getById($id) {

    }

    public function insert() {
      $input = Input::all();
      $item = ProductReview::create($input);

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
  }


