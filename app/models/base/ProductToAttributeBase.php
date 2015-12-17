<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ProductToAttributeBase extends Ardent
    {
        protected $table = 'products_to_attributes';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'attribute_id',
            'language_id',
            'value');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'product_id' => 'required|integer',
            'attribute_id' => 'required|integer',
            'language_id' => 'required|integer'
        );

        // relations
        public static $relationsData = array(
            'attribute' => array('belongsTo', 'Attribute', 'foreignKey' => 'attribute_id'),
            'language' => array('belongsTo', 'Language', 'foreignKey' => 'language_id'),
            'product' => array('belongsTo', 'Product', 'foreignKey' => 'product_id')
        );


    }