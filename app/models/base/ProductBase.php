<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductBase extends Ardent
    {
        protected $table = 'products';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'model',
            'sku',
            'upc',
            'ean',
            'jan',
            'isbn',
            'mpn',
            'location',
            'quantity',
            'stock_status_id',
            'image',
            'manufacturer_id',
            'shipping',
            'price',
            'points',
            'tax_class_id',
            'date_available',
            'weight',
            'weight_class_id',
            'length',
            'width',
            'height',
            'length_class_id',
            'subtract',
            'minimum',
            'sort_order',
            'status',
            'views');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'model' => 'max:64',
            'sku' => 'max:64',
            'upc' => 'max:12',
            'ean' => 'max:14',
            'jan' => 'max:13',
            'isbn' => 'max:17',
            'mpn' => 'max:64',
            'location' => 'max:128',
            'quantity' => 'integer',
            'stock_status_id' => 'integer',
            'image' => 'max:255',
            'manufacturer_id' => 'integer',
            'points' => 'integer',
            'tax_class_id' => 'integer',
            'weight_class_id' => 'integer',
            'length_class_id' => 'integer',
            'minimum' => 'integer',
            'sort_order' => 'integer',
            'views' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'orderslineitems' => array('hasMany', '', 'foreignKey' => 'product_id'),
            'lengthClass' => array('belongsTo', 'LengthClass', 'foreignKey' => 'length_class_id'),
            'manufacturer' => array('belongsTo', 'Manufacturer', 'foreignKey' => 'manufacturer_id'),
            'stockStatus' => array('belongsTo', 'StockStatus', 'foreignKey' => 'stock_status_id'),
            'taxClass' => array('belongsTo', 'TaxClass', 'foreignKey' => 'tax_class_id'),
            'weightClass' => array('belongsTo', 'WeightClass', 'foreignKey' => 'weight_class_id'),
            'productstoattributes' => array('hasMany', 'ProductToAttribute', 'foreignKey' => 'product_id')
        );


    }