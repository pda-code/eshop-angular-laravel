<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class PaymentMethod extends BaseModel
    {
        protected $table = 'payment_methods';
        protected $primaryKey = 'id';
        public $timestamps = false;

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array();
    }
