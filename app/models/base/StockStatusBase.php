<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class StockStatusBase extends Ardent
    {
        protected $table = 'stock_statuses';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'stock_status_id',
            'language_id',
            'name');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'products' => array('hasMany', 'Product', 'foreignKey' => 'stock_status_id')
        );


    }