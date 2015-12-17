<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class AttributeGroupDescriptionBase extends Ardent
    {
        protected $table = 'attributes_groups_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'attribute_group_id',
            'language_id',
            'name');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'required|between:3,64'
        );

        // relations
        public static $relationsData = array(
            'attributeGroup' => array('belongsTo', 'AttributeGroup', 'foreignKey' => 'attribute_group_id'),
            'language' => array('belongsTo', 'Language', 'foreignKey' => 'language_id')
        );


    }