<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ZoneToGeoZoneBase extends Ardent
    {
        protected $table = 'zones_to_geo_zones';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'country_id',
            'zone_id',
            'geo_zone_id');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'country_id' => 'integer',
            'zone_id' => 'integer',
            'geo_zone_id' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'country' => array('belongsTo', 'Country', 'foreignKey' => 'country_id'),
            'geoZone' => array('belongsTo', 'GeoZone', 'foreignKey' => 'geo_zone_id'),
            'zone' => array('belongsTo', 'Zone', 'foreignKey' => 'zone_id')
        );


    }