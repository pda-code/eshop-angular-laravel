<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class OrderTotal extends BaseModel
    {
        protected $table = 'orders_totals';
        protected $primaryKey = 'id';
        public $timestamps = false;

        // fillable
        protected $fillable = array(
            'order_id',
            'code',
            'title',
            'value',
            'sort_order');

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'order_id' => 'required|integer',
            'code' => 'required|between:3,32',
            'title' => 'required|between:3,255',
            'value' => 'required|numeric',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'order' => array('belongsTo', 'CodeTrim\Models\Order', 'foreignKey' => 'order_id'),
        );
    }
