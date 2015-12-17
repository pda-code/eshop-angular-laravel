<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CurrencyBase extends Ardent
    {
        protected $table = 'currencies';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'title',
            'code',
            'symbol',
            'decimal_place',
            'value',
            'status');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'title' => 'max:32',
            'code' => 'max:3',
            'symbol' => 'max:12'
        );

        // relations
        public static $relationsData = array(
            'orders' => array('hasMany', 'Order', 'foreignKey' => 'currency_id')
        );


    }