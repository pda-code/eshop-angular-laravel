<?php
    namespace CodeTrim\Helpers;

    use \Illuminate\Support\Facades\Input;

    class ParameterHelper
    {
        public static function getPagerParams()
        {
            //Defaults
            $params = [
                'columns' => Input::get('columns', ['*']),
                'sort_column' => Input::get('sort_column', null),
                'sort_direction' => Input::get('sort_direction', 'asc'),
                'page_index' => Input::get('page_index', null),
                'page_size' => Input::get('page_size', null),
                'includes' => Input::get('includes', []),
                'criteria' => Input::get('criteria', []),
            ];

            return json_decode(json_encode($params));
        }
    }