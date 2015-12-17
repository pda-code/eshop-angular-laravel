<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\Product;

    class ProductService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Product);
        }
    }