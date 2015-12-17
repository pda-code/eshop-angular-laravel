<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class AddressBase extends Ardent
    {
        protected $table = 'addresses';
        protected $primaryKey = 'id';
        public $timestamps = TRUE;

        // fillable
        protected $fillable = array(
            'customer_id',
            'first_name',
            'last_name',
            'company',
            'address_1',
            'address_2',
            'city',
            'postal_code',
            'country_id',
            'zone_id',
            'custom_field'
        );

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'customer_id' => 'integer',
            'first_name' => 'max:32',
            'last_name' => 'max:32',
            'company' => 'max:40',
            'address_1' => 'max:128',
            'address_2' => 'max:128',
            'city' => 'max:128',
            'postal_code' => 'max:10',
            'country_id' => 'integer',
            'zone_id' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'country' => array('belongsTo', 'Country', 'foreignKey' => 'country_id'),
            'customer' => array(
                'belongsTo',
                'Customer',
                'foreignKey' => 'customer_id'
            ),
            'zone' => array('belongsTo', 'Zone', 'foreignKey' => 'zone_id'),
            'customers' => array('hasMany', 'Customer', 'foreignKey' => 'address_id')
        );


    }