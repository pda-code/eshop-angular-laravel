<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class AttributeBase extends Ardent
    {
        protected $table = 'attributes';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'attribute_group_id',
            'data_type',
            'is_filterable',
            'is_variant',
            'sort_order');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'attribute_group_id' => 'integer',
            'data_type' => 'max:50',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'attributeGroup' => array('belongsTo', 'AttributeGroup', 'foreignKey' => 'attribute_group_id'),
            'attributesdescriptions' => array('hasMany', 'AttributeDescription', 'foreignKey' => 'attribute_id'),
            'attributesoptions' => array('hasMany', 'AttributeOption', 'foreignKey' => 'attribute_id'),
            'productstoattributes' => array('hasMany', 'ProductToAttribute', 'foreignKey' => 'attribute_id')
        );


    }