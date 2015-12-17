<?php

    namespace CodeTrim\Services;

    use CodeTrim\Models\LineItem;
    use CodeTrim\Services\BaseService;

    class LineItemService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new LineItem());
        }
    }