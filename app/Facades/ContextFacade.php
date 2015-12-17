<?php
    namespace CodeTrim\Facades;

    use Illuminate\Support\Facades\Facade;

    Class ContextFacade extends Facade {

      protected static function getFacadeAccessor() {
        return 'context';
      }
    }