<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\ProductReview;

    class ProductReviewService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new ProductReview);
        }
    }