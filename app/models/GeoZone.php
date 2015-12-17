<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class GeoZone extends BaseModel
    {

        protected $table = 'geo_zones';
        protected $primaryKey = 'id';

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'first_name' => 'required|between:3,32',
            'last_name' => 'required|between:3,32'
        );

        //public function zones()
        //{
        //    return $this->belongsToMany('CodeTrim\Models\Zone', 'zones_to_geo_zones', 'geo_zone_id', 'zone_id');
        //}

        // relations
        public static $relationsData = array(
            'zones' => array('belongsToMany', 'CodeTrim\Models\Zone', 'table' => 'zones_to_geo_zones', 'foreignKey' => 'geo_zone_id', 'otherKey' => 'zone_id')
        );
    }
