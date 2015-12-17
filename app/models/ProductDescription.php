<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class ProductDescription extends BaseModel
    {
        protected $table = 'products_descriptions';
        protected $primaryKey = 'id';

        // fillable
        protected $fillable = array();

        // guarded
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array(
            'product' => array('belongsTo', 'CodeTrim\Models\Product', 'foreignKey' => 'product_id'),
            'language' => array('belongsTo', 'CodeTrim\Models\Language', 'foreignKey' => 'language_id')
        );
    }