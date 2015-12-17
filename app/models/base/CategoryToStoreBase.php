<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CategoryToStoreBase extends Ardent
    {
        protected $table = 'categories_to_stores';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'category_id',
            'store_id');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array();


    }