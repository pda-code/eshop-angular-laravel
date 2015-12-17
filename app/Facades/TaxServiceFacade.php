<?php
    namespace CodeTrim\Facades;

    use Illuminate\Support\Facades\Facade;

    Class TaxServiceFacade extends Facade {

      protected static function getFacadeAccessor() {
        return 'taxService';
      }
    }