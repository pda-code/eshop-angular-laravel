<?php

    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Order extends BaseModel
    {
        protected $table = 'orders';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            //'invoice_no',
            //'invoice_prefix',
            //'store_id',
            //'store_name',
            //'store_url',
            'customer_id',
            //'customer_group_id',
            'customer_first_name',
            'customer_last_name',
            'customer_email',
            'customer_phone',
            //'custom_field',
            'billing_address_first_name',
            'billing_address_last_name',
            'billing_address_company',
            'billing_address_address_1',
            'billing_address_address_2',
            'billing_address_city',
            'billing_address_postal_code',
            'billing_address_country_id',
            'billing_address_zone_id',

            'shipping_address_first_name',
            'shipping_address_last_name',
            'shipping_address_company',
            'shipping_address_address_1',
            'shipping_address_address_2',
            'shipping_address_city',
            'shipping_address_postal_code',
            'shipping_address_country_id',
            'shipping_address_zone_id',

            'payment_method',
            //'payment_code',
            'shipping_method',
            //'shipping_code',
            'comment',
            'total',
            //'order_status_id',
            //'affiliate_id',
            //'commission',
            //'marketing_id',
            //'tracking',
            'language_id',
            'currency_id',
            //'currency_code',
            //'currency_value',
            //'ip',
            //'forwarded_ip',
            //'user_agent',
            //'accept_language'
        );

        // guarded
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            //'invoice_no' => 'integer',
            //'invoice_prefix' => 'max:26',
            //'store_id' => 'required|integer',
            //'store_name' => 'max:64',
            //'store_url' => 'max:255',
            'customer_id' => 'integer',
            'customer_first_name' => 'required|between:3,32',
            'customer_last_name' => 'required|between:3,32',
            'customer_email' => 'required|email',

            //'customer_group_id' => 'integer',
            'billing_address_first_name' => 'required|between:3,32',
            'billing_address_last_name' => 'required|between:3,32',
            'billing_address_address_1' => 'required|between:3,128',
            'billing_address_city' => 'required|between:3,128',
            'billing_address_country_id' => 'required|integer',
            'billing_address_zone_id' => 'required|integer',

            'shipping_address_first_name' => 'required|between:3,32',
            'shipping_address_last_name' => 'required|between:3,32',
            'shipping_address_address_1' => 'required|between:3,128',
            'shipping_address_city' => 'required|between:3,128',
            'shipping_address_country_id' => 'required|integer',
            'shipping_address_zone_id' => 'required|integer',

            'payment_method' => 'required|max:128',
            //'payment_code' => 'max:128',
            'shipping_method' => 'required|max:128',
            //'shipping_code' => 'max:128',
            'total' => 'required|numeric',
            //'order_status_id' => 'required|integer',
            //'affiliate_id' => 'integer',
            //'marketing_id' => 'integer',
            //'tracking' => 'max:64',
            'language_id' => 'required|integer',
            'currency_id' => 'required|integer',
            //'currency_code' => 'max:3',
            //'currency_value' => 'required',
            //'ip' => 'max:40',
            //'forwarded_ip' => 'max:40',
            //'user_agent' => 'max:255',
            //'accept_language' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'currency' => array('belongsTo', 'CodeTrim\Models\Currency', 'foreignKey' => 'currency_id'),
            'customer' => array('belongsTo', 'CodeTrim\Models\Customer', 'foreignKey' => 'customer_id'),
            'language' => array('belongsTo', 'CodeTrim\Models\Language', 'foreignKey' => 'language_id'),
            'lineItems' => array('hasMany', 'CodeTrim\Models\LineItem', 'foreignKey' => 'order_id'),
            'totals' => array('hasMany', 'CodeTrim\Models\OrderTotal', 'foreignKey' => 'order_id')
        );


    }