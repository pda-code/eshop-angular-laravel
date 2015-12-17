<?php
  use Illuminate\Database\Eloquent\ModelNotFoundException;

  class apiProductController extends BaseController {
    public function getAll() {
      $sortColumn = Input::get('sortColumn');
      $sortDirection = Input::get('sortDirection');
      $pageIndex = Input::get('pageIndex');
      $pageSize = Input::get('pageSize');
      $includes = Input::get('includes');
      $criteria = Input::get('criteria');

      $result = array(
        "sortColumn" => Input::get('sortColumn'),
        "sortDirection" => $sortDirection,
        "pageIndex" => $pageIndex,
        "pageSize" => $pageSize,
        "includes" => $includes,
        "criteria" => $criteria
      );

      if ($pageIndex == NULL) {
        $pageIndex = 1;
      }
      if ($pageSize == NULL) {
        $pageSize = 10;
      }

      Paginator::setCurrentPage($pageIndex);
      return Response::json(Product::paginate($pageSize));
    }


    public function getById($id) {
      $includes = Input::get('includes');

      $result = array("includes" => $includes);

      return Response::json($result);
    }

    public function create() {

      $result = array("includes" => $includes);

      return Response::json($result);
    }

    public function update($id) {

      $result = array("includes" => $includes);

      return Response::json($result);
    }

    public function delete($id) {
      $result = array("includes" => $includes);

      return Response::json($result);
    }

  }


