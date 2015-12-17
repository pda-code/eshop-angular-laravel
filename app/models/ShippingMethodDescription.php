<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class ShippingMethodDescription extends  BaseModel
    {
        protected $table = 'shipping_methods_descriptions';
        protected $primaryKey = 'id';

        public function shippingMethod()
        {
            return $this->belongsTo('CodeTrim\Models\ShippingMethod', 'shipping_method_id');
        }

        public function language()
        {
            return $this->belongsTo('CodeTrim\Models\ShippingMethod', 'language_id');
        }

    }