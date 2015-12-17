<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductDiscountBase extends Ardent
    {
        protected $table = 'products_discounts';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'customer_group_id',
            'quantity',
            'priority',
            'price',
            'date_start',
            'date_end');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'product_id' => 'integer',
            'customer_group_id' => 'integer',
            'quantity' => 'integer',
            'priority' => 'integer'
        );

        // relations
        public static $relationsData = array();


    }