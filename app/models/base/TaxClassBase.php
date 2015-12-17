<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class TaxClassBase extends Ardent
    {
        protected $table = 'tax_classes';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'name',
            'description',
            'date_added',
            'date_modified');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:255',
            'description' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'products' => array('hasMany', 'Product', 'foreignKey' => 'tax_class_id')
        );


    }