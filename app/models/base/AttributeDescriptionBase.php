<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class AttributeDescriptionBase extends Ardent
    {
        protected $table = 'attributes_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'attribute_id',
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
            'attribute' => array('belongsTo', 'Attribute', 'foreignKey' => 'attribute_id'),
            'language' => array('belongsTo', 'Language', 'foreignKey' => 'language_id')
        );


    }