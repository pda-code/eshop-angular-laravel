<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class TaxRateBase extends Ardent
    {
        protected $table = 'tax_rates';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'geo_zone_id',
            'name',
            'rate',
            'type');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'geo_zone_id' => 'integer',
            'name' => 'max:255',
            'rate' => 'required'
        );

        // relations
        public static $relationsData = array(
            'taxrules' => array('hasMany', 'TaxRule', 'foreignKey' => 'tax_rate_id')
        );


    }