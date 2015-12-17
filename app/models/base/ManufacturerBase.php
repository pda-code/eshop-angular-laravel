<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ManufacturerBase extends Ardent
    {
        protected $table = 'manufacturers';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'name',
            'image',
            'sort_order');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:64',
            'image' => 'max:255',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'products' => array('hasMany', 'Product', 'foreignKey' => 'manufacturer_id')
        );


    }