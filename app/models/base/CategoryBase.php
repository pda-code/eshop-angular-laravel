<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CategoryBase extends Ardent
    {
        protected $table = 'categories';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'image',
            'parent_id',
            'top',
            'column',
            'sort_order',
            'status',
            'date_added',
            'date_modified');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'image' => 'max:255',
            'parent_id' => 'integer',
            'column' => 'integer',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array();


    }