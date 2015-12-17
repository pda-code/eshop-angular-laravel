<?php

    namespace CodeTrim\Services;

    use CodeTrim\Models\Zone;
    use CodeTrim\Models\EloquentRepository;

    class BaseService
    {
        protected $repo;

        public function __construct($model)
        {
            $this->repo = new EloquentRepository($model);
        }

        public function getAll($params = array())
        {
            return $this->repo->getAll($params);
        }

        public function getById($id, $includes = array())
        {
            return $this->repo->getById($id);
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