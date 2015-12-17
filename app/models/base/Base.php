<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class Base extends Ardent
    {
        protected $table = 'shipping_methods_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'shipping_method_id',
            'language_id',
            'name');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'language' => array('belongsTo', 'Language', 'foreignKey' => 'language_id'),
            '' => array('belongsTo', '', 'foreignKey' => 'shipping_method_id')
        );


    }