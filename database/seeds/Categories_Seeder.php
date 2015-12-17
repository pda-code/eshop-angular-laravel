<?php
    class Categories_Seeder extends Seeder
    {

        private function insertCategory($parent_id, $element, &$categories)
        {
            $category_id = DB::table('categories')->insertGetId(array('parent_id' => $parent_id));

            DB::table('categories_description')->insert(
                array('category_id' => $category_id,
                    'language_id' => 1,
                    'name' => $element->getAttribute('title-el'))
            );

            DB::table('categories_description')->insert(
                array('category_id' => $category_id,
                    'language_id' => 2,
                    'name' => $element->getAttribute('title-el'))
            );

            $categories[] = $category_id;
            foreach ($element->childNodes as $element) {
                if ($element->nodeType == XML_ELEMENT_NODE)
                    $this->insertCategory($category_id, $element, $categories);
            }
        }

        public function trancate()
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

            //Delete All categories
            DB::table('categories')->truncate();
            DB::table('categories_description')->truncate();
            DB::table('categories_to_stores')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        public function run()
        {
            $this->trancate();

            //Insert Catagories
            $doc = new DOMDocument();
            $doc->load(app_path() . "/database/seed_data/categories.xml");
            $xpath = new DOMXPath($doc);

            $categories = array();
            foreach ($xpath->evaluate("/categories/category", $doc) as $element) {
                $this->insertCategory(null, $element, $categories);
            }
        }
    }