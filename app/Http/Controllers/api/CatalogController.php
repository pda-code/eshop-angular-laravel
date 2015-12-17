<?php
  namespace App\Http\Controllers;

  use Illuminate\Database\Eloquent\ModelNotFoundException;
  use \Illuminate\Support\Facades\Input;
  use CodeTrim\Services\CatalogService;
  use CodeTrim\Services\ProductReviewService;
  use CodeTrim\Helpers\ParameterHelper;
  use CodeTrim\Models\Cart;

  use App\Http\Controllers\MyBaseController;
  use \Response;
  use \Request;
  use Context;

  class CatalogController extends MyBaseController {

    public function __construct() {
      parent::__construct();
      $this->catalogService = new CatalogService();
    }

    public function getTopCategories() {
      $depth = Input::get('depth', 3);
      $include_children_count = Input::get('children_count', FALSE);
      $include_products_count = Input::get('products_count', FALSE);

      return Response::json($this->catalogService->getTopCategories($depth, $include_children_count, $include_products_count));
    }

    public function getTopCategoriesWithPreselection($id) {
      $depth = 1;
      $include_children_count = Input::get('children_count', FALSE);
      $include_products_count = Input::get('products_count', FALSE);

      return Response::json($this->catalogService->getTopCategoriesWithPresection($id, $include_children_count, $include_products_count));
    }

    public function getSubCategories($id) {
      $include_children_count = Input::get('children_count', FALSE);
      $include_products_count = Input::get('products_count', FALSE);

      return Response::json($this->catalogService->getSubCategories($id, $include_children_count, $include_products_count));
    }

    public function getById($id) {

    }

    public function insert() {

    }

    public function update($id) {

    }

    public function delete($id) {
    }


    public function getProducts($category_id) {
      $params = Input::only(['paging', 'sorting']);

      return Response::json($this->catalogService->getProducts($category_id, Context::getLanguageId(), $params));
    }


    public function getProduct($id) {
      $params = json_decode(Input::get('params'), TRUE);
      $update_views = $params['update_views'];
      return Response::json($this->catalogService->getProduct($id, Context::getLanguageId(), $update_views));
    }

    public function getProductReviews($id) {
      $product_review_service = new ProductReviewService();
      $params = Input::all();

      $params = array_except($params, ['criteria']);
      $params = array_except($params, ['sorting']);

      array_set($params, 'criteria', ['product_id=' . $id . ' and approved=1']);
      array_set($params, 'sorting', ['created_at:desc']);

      $items = $product_review_service->getAll($params);
      return Response::json($items);
    }

    public function getProductSpecs($id) {
      return Response::json($this->catalogService->getProductAttributes($id));
    }

    public function getCategoryAttributes($id) {
      return Response::json($this->catalogService->getCategoryAttributes($id));
    }

    public function compareProducts() {
      $params = Input::all(); //json_decode(Input::all(), true);
      $ids = array_get(Input::all(), 'product_ids', []);
      //return Response::json($params['product_ids']);
      //$compare_items=$app->settings->carts[Cart::COMPARE_CART]->items;
      //$ids=Input::get("ids");
      //foreach ($compare_items as $key=>$value)
      //    $ids[]=$key;

      if (count($ids) == 0) {
        return Response::json(array('error' => 'No items to compare'), 400);
      }
      else {
        return Response::json($this->catalogService->compareProducts($ids, Context::getLanguageId()));
      }
    }
  }


