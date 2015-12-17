<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class OrderBase extends Ardent
    {
        protected $table = 'orders';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'invoice_no',
            'invoice_prefix',
            'store_id',
            'store_name',
            'store_url',
            'customer_id',
            'customer_group_id',
            'customer_first_name',
            'customer_last_name',
            'customer_email',
            'customer_phone',
            'custom_field',
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
            'payment_code',
            'shipping_method',
            'shipping_code',
            'comment',
            'total',
            'order_status_id',
            'affiliate_id',
            'commission',
            'marketing_id',
            'tracking',
            'language_id',
            'currency_id',
            'currency_code',
            'currency_value',
            'ip',
            'forwarded_ip',
            'user_agent',
            'accept_language');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'invoice_no' => 'integer',
            'invoice_prefix' => 'max:26',
            'store_id' => 'integer',
            'store_name' => 'max:64',
            'store_url' => 'max:255',
            'customer_id' => 'integer',
            'customer_group_id' => 'integer',
            'customer_first_name' => 'max:32',
            'customer_last_name' => 'max:32',
            'customer_email' => 'max:255',
            'customer_phone' => 'max:32',
            'billing_address_first_name' => 'max:32',
            'billing_address_last_name' => 'max:32',
            'billing_address_company' => 'max:40',
            'billing_address_address_1' => 'max:128',
            'billing_address_address_2' => 'max:128',
            'billing_address_city' => 'max:128',
            'billing_address_postal_code' => 'max:10',
            'billing_address_country_id' => 'integer',
            'billing_address_zone_id' => 'integer',
            'shipping_address_first_name' => 'max:32',
            'shipping_address_last_name' => 'max:32',
            'shipping_address_company' => 'max:40',
            'shipping_address_address_1' => 'max:128',
            'shipping_address_address_2' => 'max:128',
            'shipping_address_city' => 'max:128',
            'shipping_address_postal_code' => 'max:10',
            'shipping_address_country_id' => 'integer',
            'shipping_address_zone_id' => 'integer',
            'payment_method' => 'max:128',
            'payment_code' => 'max:128',
            'shipping_method' => 'max:128',
            'shipping_code' => 'max:128',
            'order_status_id' => 'integer',
            'affiliate_id' => 'integer',
            'marketing_id' => 'integer',
            'tracking' => 'max:64',
            'language_id' => 'integer',
            'currency_id' => 'integer',
            'currency_code' => 'max:3',
            'ip' => 'max:40',
            'forwarded_ip' => 'max:40',
            'user_agent' => 'max:255',
            'accept_language' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'currency' => array('belongsTo', 'Currency', 'foreignKey' => 'currency_id'),
            'customer' => array('belongsTo', 'Customer', 'foreignKey' => 'customer_id'),
            'language' => array('belongsTo', 'Language', 'foreignKey' => 'language_id'),
            'orderStatus' => array('belongsTo', 'OrderStatus', 'foreignKey' => 'order_status_id'),
            'ordershistory' => array('hasMany', 'OrderHistory', 'foreignKey' => 'order_id'),
            'ordershistory' => array('hasMany', 'OrderHistory', 'foreignKey' => 'order_status_id'),
            'orderslineitems' => array('hasMany', '', 'foreignKey' => 'order_id'),
            'orderstotals' => array('hasMany', 'OrderTotal', 'foreignKey' => 'order_id')
        );


    }