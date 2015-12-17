<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class LengthClassBase extends Ardent
    {
        protected $table = 'length_classes';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'value');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'value' => 'required'
        );

        // relations
        public static $relationsData = array(
            'products' => array('hasMany', 'Product', 'foreignKey' => 'length_class_id')
        );


    }