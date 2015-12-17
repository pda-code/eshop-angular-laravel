<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Address extends BaseModel
    {
        protected $table = 'addresses';
        protected $primaryKey = 'id';

        // fillable
        protected $fillable = array(
            'customer_id',
            'first_name',
            'last_name',
            'company',
            'address_1',
            'address_2',
            'city',
            'postal_code',
            'country_id',
            'zone_id',
            'custom_field');

        // guarded
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'customer_id' => 'integer',
            'first_name' => 'required|between:3,32',
            'last_name' => 'required|between:3,32',
            'address_1' => 'required|between:3,128',
            'city' => 'required|between:3,128',
            'country_id' => 'required|integer',
            'zone_id' => 'required|integer'
        );

        // relations
        public function customer()
        {
            return $this->belongsTo('CodeTrim\Models\Customer', 'customer_id');
        }

        public function country()
        {
            return $this->belongsTo('CodeTrim\Models\Country', 'country_id');
        }

        public function zone()
        {
            return $this->belongsTo('CodeTrim\Models\zone', 'zone_id');
        }
    }
