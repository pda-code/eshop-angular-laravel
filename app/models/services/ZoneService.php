<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\Zone;

    class ZoneService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Zone);
        }
    }