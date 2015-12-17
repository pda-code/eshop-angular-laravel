<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Zone extends BaseModel
    {
        protected $table = 'zones';
        protected $primaryKey = 'id';

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'required|between:2,32'
        );

        // relations
        public function country()
        {
            return $this->belongsTo('CodeTrim\Models\Country','country_id');
        }

        public function geoZones()
        {
            return $this->belongsTo('CodeTrim\Models\GeoZone','zones_geo_zones','zone_id','geo_zone_id');
        }

        public function isinGeoZone($geo_zone_id)
        {
            return $this->geoZones->find($geo_zone_id) != null;
        }
    }
