<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CustomerGroupBase extends Ardent
    {
        protected $table = 'customers_groups';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'approval',
            'sort_order');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'approval' => 'integer',
            'sort_order' => 'integer'
        );

        // relations
        public static $relationsData = array();


    }