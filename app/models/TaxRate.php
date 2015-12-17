<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class TaxRate extends BaseModel
    {

        protected $table = 'tax_rates';
        protected $primaryKey = 'id';

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'required|between:3,255',
            'rate' => 'required|numeric'
        );

        // relations
        public static $relationsData = array(
            'geoZone' => array('belongsTo', 'CodeTrim\Models\GeoZone', 'foreignKey' => 'geo_zone_id'),
        );

        public function calculateTax($price)
        {
            return $price * ($this->rate / 100);
        }
    }