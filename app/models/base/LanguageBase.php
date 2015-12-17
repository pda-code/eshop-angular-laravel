<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class LanguageBase extends Ardent
    {
        protected $table = 'languages';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'name',
            'code',
            'locale',
            'image',
            'directory',
            'filename',
            'sort_order',
            'status');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:32',
            'code' => 'max:5',
            'locale' => 'max:255',
            'image' => 'max:64',
            'directory' => 'max:32',
            'filename' => 'max:64',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'attributesdescriptions' => array('hasMany', 'AttributeDescription', 'foreignKey' => 'language_id'),
            'attributesgroupsdescriptions' => array('hasMany', 'AttributeGroupDescription', 'foreignKey' => 'language_id'),
            'attributesoptions' => array('hasMany', 'AttributeOption', 'foreignKey' => 'language_id'),
            'orders' => array('hasMany', 'Order', 'foreignKey' => 'language_id'),
            'ordersstatuses' => array('hasMany', 'OrderStatus', 'foreignKey' => 'language_id'),
            'paymentmethodsdescriptions' => array('hasMany', '', 'foreignKey' => 'language_id'),
            'productstoattributes' => array('hasMany', 'ProductToAttribute', 'foreignKey' => 'language_id'),
            'shippingmethodsdescriptions' => array('hasMany', '', 'foreignKey' => 'language_id')
        );


    }