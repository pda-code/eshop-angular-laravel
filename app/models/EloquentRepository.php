<?php
    namespace CodeTrim\Models;
    use Illuminate\Pagination\Paginator;

    class EloquentRepository
    {
        protected $model;

        public function __construct($model)
        {
            $this->model = $model;
        }

        public function getAll($params = array())
        {
            $paging = array_get($params, 'paging', []);
            $page_index = null;
            $page_size = null;

            if (count($paging) > 0) {
                $page_index = count($paging) == 2 ? $paging[0] : 1;
                $page_size = count($paging) == 2 ? $paging[1] : $paging[0];
            }

            $query = $this->model->query();
            $this->extendQuery($query, $params);

            if ($page_index != null || $page_size != null) {
                Paginator::currentPageResolver(function() use ($page_index) {
                    return $page_index;
                });
                $items = $query->paginate($page_size);
            } else
                $items = $query->get();

            return $items;
        }

        private function extendQuery($query, $params)
        {
            $columns = array_get($params, 'columns', ['*']);

            $sorting = array_get($params, 'sorting', []);
            $sort_columns = [];
            foreach ($sorting as $column) {
                $tokens = explode(":", $column);
                $sort_columns[] = ['column' => $tokens[0], 'direction' => count($tokens) == 2 ? $tokens[1] : 'asc'];
            }

            $includes = array_get($params, 'includes', []);
            $criteria = array_get($params, 'criteria', []);

            foreach ($includes as $key => $include) {
                if (is_array($include))
                    $query->with([$key => function ($query2) use ($include) {
                        $this->extendQuery($query2, $include);
                    }]);
                else
                    $query->with([$include]);
            }

            foreach ($sort_columns as $sort_column)
                $query->orderBy($sort_column['column'], $sort_column['direction']);

            foreach ($criteria as $condition) {
                /*
                $tokens = explode("|", $condition);
                if (count($tokens) == 2) {
                    $column = $tokens[0];
                    $op = '=';
                    $value = $tokens[1];
                } else {
                    $column = $tokens[0];
                    $op = $tokens[1];
                    $value = $tokens[2];
                }
                $query->where($column, $op, $value);
                */
                $query->whereRaw($condition);
            }

            $query->select($columns);
        }

        public function getById($id, $includes = array())
        {
            return $this->model->with($includes)->where("id", $id)->first();
        }

        public function create($attributes)
        {
            return $this->model->create($attributes);
        }

        public function update($id, $attributes)
        {
            $item = $this->model->findOrFail($id);
            $item->update($attributes);
        }

        public function destroy($id)
        {
            //$address = Address::findOrFail($id);
            //$address->delete();
            //or
            //delete
            $this->model->destroy($id);
        }

    }