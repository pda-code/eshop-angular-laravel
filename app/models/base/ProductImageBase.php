<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductImageBase extends Ardent
    {
        protected $table = 'products_images';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'image',
            'sort_order');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'product_id' => 'integer',
            'image' => 'max:255',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array();


    }