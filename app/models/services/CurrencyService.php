<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\Currency;

    class CurrencyService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Currency);
        }
    }