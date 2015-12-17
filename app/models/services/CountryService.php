<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\Country;

    class CountryService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Country);
        }
    }