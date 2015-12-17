<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class WeightClassDecriptionBase extends Ardent
    {
        protected $table = 'weight_classes_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'weight_class_id',
            'language_id',
            'name',
            'unit');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:32',
            'unit' => 'max:4'
        );

        // relations
        public static $relationsData = array();


    }