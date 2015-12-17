<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductReviewBase extends Ardent
    {
        protected $table = 'products_reviews';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'customer_id',
            'author',
            'title',
            'text',
            'rating',
            'approved');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'product_id' => 'integer',
            'customer_id' => 'integer',
            'author' => 'max:64',
            'title' => 'max:255'
        );

        // relations
        public static $relationsData = array();


    }