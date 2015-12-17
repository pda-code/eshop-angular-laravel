<?php
    namespace CodeTrim\Services;

    use CodeTrim\Helpers\ArrayHelper;
    use CodeTrim\Models\Product;
    use CodeTrim\Models\Category;
    //use CodeTrim\Models\ProductReview;
    //use CodeTrim\Models\StoreSettings;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Pagination\Paginator;

    use \Context;
    use \TaxService;

    class CatalogService
    {
        public function __construct()
        {
        }

        public function getTopCategories($max_level, $include_children_count, $include_products_count)
        {
            $categories = array();
            $this->buildTree(null, $categories, 1, $max_level, $include_children_count, $include_products_count);
            return $categories;
        }

        public function getTopCategoriesWithPresection($selected_id, $include_children_count, $include_products_count)
        {
            $categories = $this->getTopCategories(1, $include_children_count, $include_products_count);
            $parents = $this->getParentsId($selected_id);

            $container =& $categories;
            foreach ($parents as $parent) {
                $item = array_first($container, function ($key, $item) use ($parent) {
                    return $item->id == $parent;
                });

                if ($item) {
                    $item->expanded = true;
                    $item->loaded = true;
                    $item->children = $this->getSubCategories($item->id, $include_children_count, $include_products_count);
                    $container =& $item->children;
                };
            }

            return $categories;
        }


        public function getSubCategories($id, $include_children_count, $include_products_count)
        {
            $categories = array();

            $this->buildTree($id, $categories, 1, 1, $include_children_count, $include_products_count);
            return $categories;
        }

        private function buildTree($parent_id, &$container, $level, $max_level, $include_children_count, $include_products_count)
        {
            if ($level > $max_level) return;

            $select = array('c.id', 'c.parent_id', 'cd.name');
            $query = $this->buildQuery($include_children_count, $include_products_count);
            $query->where('c.parent_id', $parent_id);

            $items = $query->get();

            $queries = DB::getQueryLog();
            $last_query = end($queries)['query'];

            foreach ($items as $item) {
                $item->level = $level;
                $children = array();
                $this->buildTree($item->id, $children, $level + 1, $max_level, $include_children_count, $include_products_count);
                $item->children = $children;
                $container[] = $item;
            }
        }

        private function buildQuery($include_children_count, $include_products_count)
        {
            $select = array('c.id', 'c.parent_id', 'cd.name');

            if ($include_children_count) $select[] = DB::raw('(SELECT count(id) FROM categories WHERE categories.parent_id=c.id) AS children_count');
            if ($include_products_count) $select[] = DB::raw('(SELECT count(product_id) FROM products_to_categories WHERE products_to_categories.category_id=c.id) AS products_count');

            $query = DB::table('categories as c')
                ->select($select)
                ->where('cd.language_id', Context::getLanguageId())
                ->join('categories_descriptions AS cd', 'c.id', '=', 'cd.category_id')
                ->orderBy('c.sort_order');

            return $query;
        }

        /*
        public function createHierarchy($language_id)
        {
            $categories = array();
            $this->buildTree(0, $language_id, $categories, 0);

            return json_encode($categories);
        }

        public function build($language_id)
        {
            $languages = Language::All();

            DB::table('oc_category_tree')->delete();

            foreach ($languages as $language) {
                DB::table('oc_category_tree')->insert(array(
                    'language_id' => $language->language_id,
                    'category_tree' => $this->createHierarchy($language->language_id)));
            }
        }

        public function getChildren($category_id,$max_level)
        {
            $language_id = 1;
            $max_level = Input::get('maxlevel');

            $categories = array();
            $this->buildTree($category_id, $language_id, $categories, 1, $max_level);

            return json_encode($categories);
        }
        */

        public function getAll()
        {

        }

        public function getById($id, $include_parents, $include_children_count, $include_products_count)
        {
            $parents = $this->getParentsId($id);
            $root_id = reset($parents);

            $query = $this->buildQuery($include_children_count, $include_products_count);
            $query->where('c.id', $root_id);

            $root = $query->first();

            $root->level = count($parents);

            $children = array();
            $this->buildTree($root->id, $children, $root->level + 1, $root->level + 2, $include_children_count, $include_products_count);
            $root->children = $children;

            $fn = function (&$item) use (&$fn) {
                $item->expanded = true;
                $item->loaded = true;

                foreach ($item->children as $child)
                    $fn($child);
            };

            $fn($root);

            return $root;
        }


        public function getByIdWithParents($id, $include_children_count, $include_products_count)
        {
            $parents = $this->getParentsId($id);
            $root_id = reset($parents);

            $query = $this->buildQuery($include_children_count, $include_products_count);
            $query->where('c.id', $root_id);

            $root = $query->first();

            $root->level = count($parents);

            $children = array();
            $this->buildTree($root->id, $children, $root->level + 1, $root->level + 2, $include_children_count, $include_products_count);
            $root->children = $children;

            $fn = function (&$item) use (&$fn) {
                $item->expanded = true;
                $item->loaded = true;

                foreach ($item->children as $child)
                    $fn($child);
            };

            $fn($root);

            return $root;
        }


        public function getLevel($id)
        {
            $parents = $this->getParentsId($id);
            return count($parents);
        }

        public function getParentsId($id)
        {
            /*
            $items = DB::select('SELECT t1.id AS level1,
                                             t2.id as level2,
                                             t3.id as level3,
                                             t4.id as level4,
                                             t5.id as level5,
                                             t6.id as level6,
                                             t7.id as level7,
                                             t8.id as level8,
                                             t9.id as level9,
                                             t10.id as level10
                                  FROM categories AS t1
                                            LEFT JOIN categories AS t2 ON t2.parent_id = t1.id
                                            LEFT JOIN categories AS t3 ON t3.parent_id = t2.id
                                            LEFT JOIN categories AS t4 ON t4.parent_id = t3.id
                                            LEFT JOIN categories AS t5 ON t5.parent_id = t4.id
                                            LEFT JOIN categories AS t6 ON t6.parent_id = t5.id
                                            LEFT JOIN categories AS t7 ON t7.parent_id = t6.id
                                            LEFT JOIN categories AS t8 ON t8.parent_id = t7.id
                                            LEFT JOIN categories AS t9 ON t9.parent_id = t8.id
                                            LEFT JOIN categories AS t10 ON t10.parent_id = t9.id WHERE t1.id=?', [$id]);

            return $items;
            */
            $ids = [];
            $item = Category::find($id, ['id', 'parent_id']);
            while ($item != null) {
                $ids[] = $item->id;
                $item = Category::find($item->parent_id, ['id', 'parent_id']);
            }

            return array_reverse($ids);
        }

        private function findRootId($id)
        {
            $parents = getParentsId($id);
            return reset($parents);
        }


        public function insert()
        {

        }

        public function update()
        {

        }

        public function delete()
        {

        }

        public function getCartItem($id)
        {
            $item = Product::select('products.id', 'image', 'price', 'tax_class_id', 'name')
                ->where('products.id', $id)
                ->leftJoin('products_descriptions', function ($join) use ($language_id) {
                    $join->on('products.id', '=', 'products_descriptions.product_id')
                        ->where('products_descriptions.language_id', '=', Context::getLanguageId());
                })
                ->first();

            if ($item)
                $this->calculateTax($item);

            return $item;
        }


        private function productQuery($language_id)
        {

            /*
            $sql="SELECT DISTINCT *,
                   pd.name AS name,
                   p.image,
                   m.name AS manufacturer,
                (SELECT price
                 FROM   products_discount pd2
                 WHERE  pd2.product_id = p.id
                        AND pd2.customer_group_id = '1'
                        AND pd2.quantity = '1'
                        AND ( ( pd2.date_start = '0000-00-00'
                                 OR pd2.date_start < Now() )
                              AND ( pd2.date_end = '0000-00-00'
                                     OR pd2.date_end > Now() ) )
                 ORDER  BY pd2.priority ASC,
                           pd2.price ASC
                 LIMIT  1) AS discount,

                (SELECT price
                 FROM   products_special ps
                 WHERE  ps.product_id = p.id
                        AND ps.customer_group_id = '1'
                        AND ( ( ps.date_start = '0000-00-00'
                                 OR ps.date_start < Now() )
                              AND ( ps.date_end = '0000-00-00'
                                     OR ps.date_end > Now() ) )
                 ORDER  BY ps.priority ASC,
                           ps.price ASC
                 LIMIT  1) AS special,

                (SELECT points
                 FROM   products_reward pr
                 WHERE  pr.product_id = p.id
                        AND customer_group_id = '1') AS reward,

                (SELECT ss.name
                 FROM   oc_stock_status ss
                 WHERE  ss.stock_status_id = p.stock_status_id
                        AND ss.language_id = '1')    AS stock_status,

                (SELECT wcd.unit
                 FROM   oc_weight_class_description wcd
                 WHERE  p.weight_class_id = wcd.weight_class_id
                        AND wcd.language_id = '1')   AS weight_class,

                (SELECT lcd.unit
                 FROM   oc_length_class_description lcd
                 WHERE  p.length_class_id = lcd.length_class_id
                        AND lcd.language_id = '1')   AS length_class,

                (SELECT Avg(rating) AS total
                 FROM   oc_review r1
                 WHERE  r1.product_id = p.id
                        AND r1.status = '1'
                 GROUP  BY r1.product_id) AS rating,

                (SELECT Count(*) AS total
                 FROM   oc_review r2
                 WHERE  r2.product_id = p.id
                        AND r2.status = '1'
                 GROUP  BY r2.product_id) AS reviews

                FROM   products p
                       LEFT JOIN products_description pd
                              ON ( p.id = pd.product_id )
                       LEFT JOIN products_to_store p2s
                              ON ( p.id = p2s.product_id )
                       LEFT JOIN oc_manufacturer m
                              ON ( p.manufacturer_id = m.manufacturer_id)

                WHERE  p.id = ?
                       AND pd.language_id = ?
                       AND p.status = '1'
                       AND p.date_available <= Now()
                       AND p2s.store_id = '0'";

            $items=DB::select($sql,[$product_id,$this->language_id]);

            return $item;
            */
            $query =
                DB::table('products as p')
                    ->select(
                        'p.id',
                        'p.model',
                        'p.price',

                        'p.tax_class_id',
                        'tc.name AS tax_class_name',

                        'p.weight_class_id',
                        'wcd.name AS weight_class_name',
                        'wcd.unit AS weight_class_unit',

                        'p.length_class_id',
                        'lcd.name AS length_class_name',
                        'lcd.unit AS length_class_unit',

                        'p.price',
                        'p.image',
                        'pd.name AS name',
                        'pd.description AS description',
                        'm.id AS manufacturer_id',
                        'm.name AS manufacturer_name',
                        'ss.name AS stock_status',
                        DB::Raw('(SELECT points FROM products_rewards pr WHERE  pr.product_id = p.id AND customer_group_id = 1) AS reward_points'),
                        DB::Raw('(SELECT Avg(rating) FROM products_reviews pr WHERE pr.product_id = p.id AND pr.approved = 1 GROUP  BY pr.product_id) AS rating'),
                        DB::Raw('(SELECT Count(*) FROM products_reviews pr WHERE  pr.product_id = p.id AND pr.approved = 1) AS reviews_count'),
                        DB::Raw('(SELECT Count(*) FROM products_to_attributes pa WHERE  pa.product_id = p.id) AS attributes_count'))
                    ->leftJoin('products_descriptions as pd', 'p.id', '=', 'pd.product_id')
                    ->leftJoin('manufacturers AS m', 'm.id', '=', 'p.manufacturer_id')
                    ->leftJoin('tax_classes AS tc', 'tc.id', '=', 'p.tax_class_id')
                    ->leftJoin('weight_classes_descriptions AS wcd', function ($join) use ($language_id) {
                        $join->on('wcd.weight_class_id', '=', 'p.weight_class_id');
                        $join->where('wcd.language_id', '=', Context::getLanguageId());
                    })
                    ->leftJoin('length_classes_descriptions AS lcd', function ($join) use ($language_id) {
                        $join->on('lcd.length_class_id', '=', 'p.length_class_id');
                        $join->where('lcd.language_id', '=', Context::getLanguageId());
                    })
                    ->leftJoin('stock_statuses AS ss', function ($join) use ($language_id) {
                        $join->on('ss.stock_status_id', '=', 'p.stock_status_id');
                        $join->where('ss.language_id', '=', Context::getLanguageId());
                    })
                    ->where('pd.language_id', Context::getLanguageId());

            return $query;
        }

        public function getProduct($product_id, $language_id, $update_views)
        {
            $query = $this->productQuery($language_id);
            $item = $query->where('p.id', $product_id)->first();

            if ($item == null)
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException();

            //update views
            if ($update_views)
                DB::statement('UPDATE products SET views=views+1 WHERE id=:product_id', array('product_id' => $product_id));

            //images
            $images = DB::table('products_images')
                ->select('id', 'image')
                ->orderBy('sort_order')
                ->where('product_id', $product_id)->get();

            $this->calculateTax($item);
            $item->rating = floatval($item->rating);
            $item->images = $images;

            return $item;
        }

        /*
        public function getProductReviews($product_id, $params)
        {
            $page_index=null;
            $page_size=null;
            Paginator::setCurrentPage($page_index);

            return ProductReview::where("product_id", $product_id)
                ->where("approved", 1)
                ->orderBy("id", 'desc')
                ->paginate($page_size);
        }
        */

        private function productAttributesQuery()
        {
            $query = DB::table('attributes AS a')
                ->select('ag.id AS group_id',
                    'agd.name AS group_name',
                    'a.id AS attr_id',
                    'ad.name AS attr_name',
                    'pa.product_id AS product_id',
                    'pa.value AS attr_value')
                ->leftJoin('attributes_descriptions AS ad', 'a.id', '=', 'ad.attribute_id')
                ->leftJoin('products_to_attributes AS pa', 'a.id', '=', 'pa.attribute_id')
                ->leftJoin('attributes_groups AS ag', 'ag.id', '=', 'a.attribute_group_id')
                ->leftJoin('attributes_groups_descriptions AS agd', 'ag.id', '=', 'agd.attribute_group_id')
                ->where('ad.language_id', Context::getLanguageId())
                ->where('agd.language_id', Context::getLanguageId())
                ->where('pa.language_id', Context::getLanguageId())
                ->orderBy('ag.sort_order')
                ->orderBy('agd.name')
                ->orderBy('a.sort_order')
                ->orderBy('ad.name')
                ->distinct();

            return $query;
        }

        private function categoryAttributesQuery()
        {
            $query = DB::table('attributes AS a')
                ->select('ag.id AS group_id',
                    'agd.name AS group_name',
                    'a.id AS attr_id',
                    'ad.name AS attr_name',
                    'a.data_type AS data_type',
                    'pa.value AS attr_value')
                ->leftJoin('attributes_descriptions AS ad', 'a.id', '=', 'ad.attribute_id')
                ->leftJoin('products_to_attributes AS pa', 'a.id', '=', 'pa.attribute_id')
                ->leftJoin('products_to_categories AS pc', 'pa.product_id', '=', 'pc.product_id')
                ->leftJoin('attributes_groups AS ag', 'ag.id', '=', 'a.attribute_group_id')
                ->leftJoin('attributes_groups_descriptions AS agd', 'ag.id', '=', 'agd.attribute_group_id')
                ->where('ad.language_id', Context::getLanguageId())
                ->where('agd.language_id', Context::getLanguageId())
                ->where('pa.language_id', Context::getLanguageId())
                ->where('a.is_filterable', true)
                ->orderBy('ag.sort_order')
                ->orderBy('agd.name')
                ->orderBy('a.sort_order')
                ->orderBy('ad.name')
                ->distinct();

            return $query;
        }

        public function getProductAttributes($product_id)
        {
            $query = $this->productAttributesQuery();
            $items = $query->where('pa.product_id', $product_id)
                ->get();

            $items = ArrayHelper::convertToArray($items);
            $model = [
                'key' => 'group_id',
                'group_id' => 'id',
                'group_name' => 'name',
                'children' => [
                    'attributes' => [
                        'key' => 'attr_id',
                        'attr_id' => 'id',
                        'attr_name' => 'name',
                        'attr_value' => 'value'
                    ]
                ]
            ];

            $grouped = ArrayHelper::groupArray($items, $model);
            return $grouped;
        }

        public function getCategoryAttributes($category_id)
        {
            $query = $this->categoryAttributesQuery();
            $items = $query->where('pc.category_id', $category_id)
                ->get();

            $items = ArrayHelper::convertToArray($items);
            $model = [
                'key' => 'group_id',
                'group_id' => 'id',
                'group_name' => 'name',
                'children' => [
                    'attributes' => [
                        'key' => 'attr_id',
                        'attr_id' => 'id',
                        'data_type' => 'dataType',
                        'attr_name' => 'name',
                        'children' => [
                            'values' => [
                                'key' => 'attr_value',
                                'attr_value' => 'value'
                            ]
                        ]
                    ]
                ]
            ];

            $grouped = ArrayHelper::groupArray($items, $model);
            return $grouped;
        }

        public function getCommonAttributes($product_ids)
        {
            $query = $this->productAttributesQuery();
            $items = $query->whereIn('pa.product_id', $product_ids)
                ->get();

            $items = ArrayHelper::convertToArray($items);
            $model = [
                'key' => 'group_id',
                'group_id' => 'id',
                'group_name' => 'name',
                'children' => [
                    'attributes' => [
                        'key' => 'attr_id',
                        'attr_id' => 'id',
                        'attr_name' => 'name',
                        'children' => [
                            'products' => [
                                'key' => 'product_id',
                                'product_id' => 'id',
                                'attr_value' => 'value']
                        ]
                    ]
                ]
            ];

            $grouped = ArrayHelper::groupArray($items, $model);
            return $grouped;
        }

        public function compareProducts($product_ids, $language_id)
        {
            $query = $this->productQuery($language_id);
            $items = $query->whereIn('p.id', $product_ids)->get();
            $attributes = $this->getCommonAttributes($product_ids);

            foreach ($items as $item) {
                $this->calculateTax($item);
                $item->rating = floatval($item->rating);
                $item->attributes = $this->getProductAttributes($item->id);
            }

            return array('products' => $items, 'groups' => $attributes);
        }

        public function getProducts($category_id, $language_id, $params)
        {
            $paging = array_get($params, 'paging', []);
            $page_index = 1;
            $page_size = 10;

            if (count($paging) > 0) {
                $page_index = count($paging) == 2 ? $paging[0] : 1;
                $page_size = count($paging) == 2 ? $paging[1] : $paging[0];
            }


            // force current page to 5
            //Paginator::setCurrentPage($page_index);
            Paginator::currentPageResolver(function() use ($page_index) {
                return $page_index;
            });



            $query = Product::select(
                'id',
                'price',
                'tax_class_id',
                'price',
                'image',
                'views',
                'pd.name as name',
                'pd.description as description')
                ->join('products_to_categories as pc', function ($join) use ($category_id) {
                    $join->on('products.id', '=', 'pc.product_id');
                    $join->where('pc.category_id', '=', $category_id);
                })
                ->leftJoin('products_descriptions AS pd', function ($join) use ($language_id) {
                    $join->on('products.id', '=', 'pd.product_id');
                    $join->where('pd.language_id', '=', Context::getLanguageId());
                });


            $sorting = array_get($params, 'sorting', []);
            if (count($sorting) > 0) {
                $tokens = explode(":", $sorting[0]);
                $sort_column = $tokens[0];
                $sort_direction = count($tokens) > 1 ? $tokens[1] : 'asc';
                switch ($sort_column) {
                    case 'price':
                        $query->orderBy('price', $sort_direction);
                        break;
                    case 'popular':
                        $query->orderBy('views', $sort_direction);
                        break;
                    case 'newest':
                        $query->orderBy('created_at', $sort_direction);
                        break;

                };
            }
            $items = $query->paginate($page_size);

            foreach ($items as $item)
                $this->calculateTax($item);

            return $items;
        }


        public function calculateTax($item)
        {
            $item->taxes = TaxService::calculateTaxes($item->price, Context::getZoneId(), $item->tax_class_id);
            $item->tax = TaxService::calculateSummarizedTax($item->taxes);
            $item->price_including_tax = $item->price + $item->tax;
        }
    }