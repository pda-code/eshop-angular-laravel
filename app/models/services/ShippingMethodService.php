<?php
    namespace CodeTrim\Services;

    use CodeTrim\Models\ShippingMethod;
    use CodeTrim\Models\EloquentRepository;

    class ShippingMethodService
    {
        protected $repo;

        public function __construct()
        {
            $this->repo = new EloquentRepository(new ShippingMethod);
        }

        public function getAll($params = array(), $language_id)
        {
            //$columns = isset($params['columns']) ? $params['columns'] : array('*');
            //$sort_column = isset($params['sort_column']) ? $params['sort_column'] : null;
            $sort_direction = isset($params['sort_direction']) ? $params['sort_direction'] : 'asc';
            $page_index = isset($params['page_index']) ? $params['page_index'] : null;
            $page_size = isset($params['page_size']) ? $params['page_size'] : null;
            //$includes = isset($params['includes']) ? $params['includes'] : array();
            //$criteria = isset($params['criteria']) ? $params['criteria'] : array();

            $columns = ['shipping_methods.*', 'shipping_methods_descriptions.name'];
            $sort_column = "sort_order";

            //basic query
            $query = ShippingMethod::leftJoin("shipping_methods_descriptions", function ($join) use ($language_id) {
                $join->on('shipping_methods.id', '=', 'shipping_methods_descriptions.shipping_method_id');
                $join->where('shipping_methods_descriptions.language_id', '=', $language_id);
            })->orderBy($sort_column, $sort_direction);

            //pagination
            if (isset($page_index) || isset($page_size)) {
                Paginator::setCurrentPage($page_index);
                $items = $query->select($columns)->paginate($page_size);
            } else
                $items = $query->select($columns)->get();

            return $items;
        }


        public function getById($id, $includes = array())
        {
            return $this->repo->getById($id, $includes);
        }

        public function create($attributes)
        {
            return $this->repo->create($attributes);
        }

        public function update($id, $attributes)
        {
            return $this->repo->update($id, $attributes);
        }

        public function destroy($id)
        {
            return $this->repo->destroy($id);
        }
    }