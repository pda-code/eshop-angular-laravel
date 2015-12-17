<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class WeightClassBase extends Ardent
    {
        protected $table = 'weight_classes';
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
            'products' => array('hasMany', 'Product', 'foreignKey' => 'weight_class_id')
        );


    }