<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class ZoneBase extends Ardent
    {
        protected $table = 'zones';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'country_id',
            'name',
            'code',
            'status');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'country_id' => 'required|integer',
            'name' => 'max:128',
            'code' => 'max:32',
            'status' => 'required'
        );

        // relations
        public static $relationsData = array(
            'addresses' => array('hasMany', 'Address', 'foreignKey' => 'zone_id'),
            'country' => array('belongsTo', 'Country', 'foreignKey' => 'country_id'),
            'zonestogeozones' => array('hasMany', 'ZoneToGeoZone', 'foreignKey' => 'zone_id')
        );


    }