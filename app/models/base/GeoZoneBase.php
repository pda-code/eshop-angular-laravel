<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class GeoZoneBase extends Ardent
    {
        protected $table = 'geo_zones';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'name',
            'description');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:32',
            'description' => 'max:255'
        );

        // relations
        public static $relationsData = array(
            'zonestogeozones' => array('hasMany', 'ZoneToGeoZone', 'foreignKey' => 'geo_zone_id')
        );


    }