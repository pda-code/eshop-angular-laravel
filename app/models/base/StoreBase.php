<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class StoreBase extends Ardent
    {
        protected $table = 'stores';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'name',
            'url',
            'ssl');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:64',
            'url' => 'max:255',
            'ssl' => 'max:255'
        );

        // relations
        public static $relationsData = array();


    }