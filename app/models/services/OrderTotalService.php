<?php

    namespace CodeTrim\Services;

    use CodeTrim\Models\OrderTotal;
    use CodeTrim\Services\BaseService;

    class OrderTotalService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new OrderTotal());
        }
    }