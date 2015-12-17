<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class ProductReview extends BaseModel
    {
        protected $table = "products_reviews";
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'product_id',
            'customer_id',
            'author',
            'title',
            'text',
            'rating',
            'approved');

        //quared, hidden, fillable
        protected $guarded = array('id', 'approved', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'product_id' => 'required|integer',
            'author' => 'required|between:3,64',
            'title' => 'required|between:3,255',
            'rating' => 'required|integer|between:1,5',
            'text' => 'required',
        );

        // relations
        public static $relationsData = array(
            'product' => array('belongsTo', 'Product', 'foreignKey' => 'product_id')
        );
    }