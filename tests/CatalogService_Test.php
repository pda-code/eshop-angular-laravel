<?php
    use CodeTrim\Models\Category;

    class CatalogService_Test extends TestCase {

      public function setUp() {
        parent::SetUp();
        $this->service = new CodeTrim\Services\CatalogService();
      }

      public function test_category() {
        $items = Category::i18n(['i18n.name','i18n.description'],1)->get();
        $this->printLastQuery();
        print_r($items->toArray());
      }

      public function test_relationship_products() {
        $item = Category::i18n(['i18n.name','i18n.description'],1)->first();
        $this->printLastQuery();
        print_r($item);
      }



      public function test_query() {
        $items = Category::select('c.category_id', 'c.parent_id', 'cd.name', DB::raw('(SELECT count(category_id) FROM oc_category) AS childrenCount'))
          ->from('oc_category as c')
          ->where('c.parent_id', 0)
          ->where('cd.language_id', 1)
          ->join('oc_category_description as cd', 'c.category_id', '=', 'cd.category_id')
          ->orderBy('c.sort_order')
          ->get();

        $queries = DB::getQueryLog();
        $last_query = end($queries);

        var_dump($last_query['query']);
        var_dump(count($items));
        var_dump($items->count());
        $this->assertNotNull($items->count());

      }

      public function test_getById() {
        $root = $this->service->getById(5435, TRUE, FALSE, FALSE);
      }

      public function test_getLevel() {
        $level = $this->service->getLevel(5435);
        $this->assertEquals(3, $level);
      }

      public function test_getTopCategoriesWithPreselection() {
        $items = $this->service->getTopCategoriesWithPresection(5435, TRUE, TRUE);
        dd($items);
      }

      public function test_getParentsId() {
        $items = $this->service->getParentsId(5435);
        $this->assertEquals(3, count($items));
      }

      public function test_getProduct() {
        $item = $this->service->getProduct(10);
        $this->assertNotNull($item);
      }

      public function test_getCategoryAttributes() {

        $items = $this->service->getCategoryAttributes(4);
        $app = App::getFacadeRoot();
        echo $app->lastSql;
        print_r($items);
        $this->assertNotNull($items);
      }

      public function test_getProductAttributes() {
        $items = $this->service->getProductAttributes(4);
        print_r($items);
        $this->assertNotNull($items);
      }

      public function test_compareProducts() {
        $items = $this->service->compareProducts([4, 10, 14]);
        print_r($items);
        $this->assertNotNull($items);
      }


      public function test_group() {
        $items = $this->service->getCategoryAttributes(4);
        print_r($items);
      }
    }
