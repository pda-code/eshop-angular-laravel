<?php
  namespace App\Http\Controllers;

  use CodeTrim\Services\ProductReviewService;

  use App\Http\Controllers\MyBaseController;
  use \Response;
  use \Request;

  class ProductReviewController extends MyBaseController {
    protected $service = NULL;

    public function __construct() {
      parent::__construct();
      $this->service = new ProductReviewService();
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


