<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class OrderHistoryBase extends Ardent
    {
        protected $table = 'orders_history';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'order_id',
            'order_status_id',
            'notify',
            'comment');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'order_id' => 'integer',
            'order_status_id' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'order' => array('belongsTo', 'Order', 'foreignKey' => 'order_id'),
            'order' => array('belongsTo', 'Order', 'foreignKey' => 'order_status_id')
        );


    }