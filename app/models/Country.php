<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Country extends BaseModel
    {
        protected $table = 'countries';
        protected $primaryKey = 'id';

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'required|between:3,32',
            'last_name' => 'required|between:3,32'
        );

        public function zones()
        {
            return $this->hasMany('CodeTrim\Models\Zone', 'country_id');
        }
    }
