<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Store extends BaseModel
    {

        protected $table = 'stores';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');
        protected $fillable = array('name', 'url', 'ssl');

        // rules
        public static $rules = array(
            'name' => 'required|between:3,32',
            'url' => 'required'
        );

        // relations
        public static $relationsData = array(
            'customers' => array('hasMany', 'Customer'),
        );
    }
