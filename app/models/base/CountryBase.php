<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CountryBase extends Ardent
    {
        protected $table = 'countries';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'name',
            'iso_code_2',
            'iso_code_3',
            'address_format',
            'postalcode_required',
            'status');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:128',
            'iso_code_2' => 'max:2',
            'iso_code_3' => 'max:3'
        );

        // relations
        public static $relationsData = array(
            'addresses' => array('hasMany', 'Address', 'foreignKey' => 'country_id'),
            'zones' => array('hasMany', 'Zone', 'foreignKey' => 'country_id'),
            'zonestogeozones' => array('hasMany', 'ZoneToGeoZone', 'foreignKey' => 'country_id')
        );


    }