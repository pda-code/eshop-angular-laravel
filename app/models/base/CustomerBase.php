<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CustomerBase extends Ardent
    {
        protected $table = 'customers';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'customer_group_id',
            'store_id',
            'first_name',
            'last_name',
            'is_registered',
            'email_registered',
            'email',
            'password',
            'salt',
            'phone',
            'cart',
            'wishlist',
            'newsletter',
            'address_id',
            'custom_field',
            'ip',
            'status',
            'approved',
            'safe',
            'token');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'customer_group_id' => 'integer',
            'store_id' => 'integer',
            'first_name' => 'max:32',
            'last_name' => 'max:32',
            'email_registered' => 'max:255',
            'email' => 'max:255',
            'password' => 'max:255',
            'salt' => 'max:9',
            'phone' => 'max:32',
            'address_id' => 'integer',
            'ip' => 'max:40',
            'token' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'addresses' => array('hasMany', 'Address', 'foreignKey' => 'customer_id'),
            'address' => array('belongsTo', 'Address', 'foreignKey' => 'address_id'),
            'orders' => array('hasMany', 'Order', 'foreignKey' => 'customer_id')
        );


    }