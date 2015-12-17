<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductRewardBase extends Ardent
    {
        protected $table = 'products_rewards';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'customer_group_id',
            'points');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'product_id' => 'integer',
            'customer_group_id' => 'integer',
            'points' => 'integer'
        );

        // relations
        public static $relationsData = array();


    }