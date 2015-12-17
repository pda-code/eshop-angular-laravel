<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class ShippingMethod extends BaseModel
    {
        protected $table = 'shipping_methods';
        protected $primaryKey = 'id';
        public $timestamps = false;

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array(
            'descriptions' => array('hasMany', 'CodeTrim\Models\ShippingMethodDescription', 'foreignKey' => 'shipping_method_id'),
        );

        public function scopeLanguage($query, $language_id)
        {
            $query->leftJoin('shipping_methods_descriptions', function ($join) use ($language_id) {
                $join->on('shipping_methods.id', '=', 'shipping_methods_descriptions.shipping_method_id')
                    ->where('shipping_methods_descriptions.language_id', '=', $language_id);
            });
        }
    }
