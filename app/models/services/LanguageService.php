<?php

    namespace CodeTrim\Services;

    use CodeTrim\Services\BaseService;
    use CodeTrim\Models\Language;

    class LanguageService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Language());
        }
    }