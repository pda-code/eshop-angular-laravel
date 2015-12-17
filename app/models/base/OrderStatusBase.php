<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class OrderStatusBase extends Ardent
    {
        protected $table = 'orders_statuses';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'language_id',
            'name');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'language_id' => 'required|integer',
            'name' => 'required|between:3,32'
        );

        // relations
        public static $relationsData = array(
            'orders' => array('hasMany', 'Order', 'foreignKey' => 'order_status_id'),
            'language' => array('belongsTo', 'Language', 'foreignKey' => 'language_id')
        );


    }