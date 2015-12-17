<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class LineItem extends BaseNodel
    {
        protected $table = 'orders_line_items';
        protected $primaryKey = 'id';
        public $timestamps = false;

        // fillable
        protected $fillable = array(
            'order_id',
            'product_id',
            'name',
            'model',
            'quantity',
            'tax',
            'total',
            'total_including_tax',
            'reward'
        );

        // guarded
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'name' => 'required|between:3,255',
            'model' => 'required|between:3,64',
            'quantity' => 'required|integer',
            'tax' => 'numeric',
            'total' => 'numeric',
            'total_including_tax' => 'numeric',
            'reward' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'order' => array('belongsTo', 'CodeTrim\Models\Order', 'foreignKey' => 'order_id'),
            'product' => array('belongsTo', 'CodeTrim\Models\Product', 'foreignKey' => 'product_id'),
        );
    }
