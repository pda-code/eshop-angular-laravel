<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class OrderTotalBase extends Ardent
    {
        protected $table = 'orders_totals';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'order_id',
            'code',
            'title',
            'value',
            'sort_order');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'order_id' => 'required|integer',
            'code' => 'required|between:3,32',
            'title' => 'required|between:3,255',
            'value' => 'required',
            'sort_order' => 'required|integer'
        );

        // relations
        public static $relationsData = array(
            'order' => array('belongsTo', 'Order', 'foreignKey' => 'order_id')
        );


    }