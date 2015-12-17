<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class AttributeGroupBase extends Ardent
    {
        protected $table = 'attributes_groups';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'sort_order');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'attributes' => array('hasMany', 'Attribute', 'foreignKey' => 'attribute_group_id'),
            'attributesgroupsdescriptions' => array('hasMany', 'AttributeGroupDescription', 'foreignKey' => 'attribute_group_id')
        );


    }