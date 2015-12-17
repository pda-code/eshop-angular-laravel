<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Product extends BaseModel
    {
        protected $table = 'products';
        protected $primaryKey = 'id';

        // fillable
        protected $fillable = array();

        // guarded
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array(
            'productDescriptions' => array('hasMany', 'CodeTrim\Models\ProductDescription', 'foreignKey' => 'product_id'),
        );
    }
