<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class TaxRateToCustomerGroupBase extends Ardent
    {
        protected $table = 'tax_rates_to_customers_groups';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'tax_rate_id',
            'customer_group_id');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array();


    }