<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CustomerGroupDescriptionBase extends Ardent
    {
        protected $table = 'customers_groups_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'customer_group_id',
            'language_id',
            'name',
            'description');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'required|between:3,32',
            'description' => 'required'
        );

        // relations
        public static $relationsData = array();


    }