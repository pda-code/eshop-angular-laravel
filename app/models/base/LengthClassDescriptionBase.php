<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class LengthClassDescriptionBase extends Ardent
    {
        protected $table = 'length_classes_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'length_class_id',
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