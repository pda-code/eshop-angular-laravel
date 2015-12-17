<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductSpecialBase extends Ardent
    {
        protected $table = 'products_specials';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'customer_group_id',
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
            'priority' => 'integer'
        );

        // relations
        public static $relationsData = array();


    }