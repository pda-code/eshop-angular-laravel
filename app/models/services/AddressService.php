<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\Address;

    class AddressService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Address);
        }
    }