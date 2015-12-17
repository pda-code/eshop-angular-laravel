<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class TaxRule extends BaseModel
    {

        protected $table = 'tax_rules';
        protected $primaryKey = 'id';

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array();

        // relations
        public static $relationsData = array(
            'taxClass' => array('belongsTo', 'CodeTrim\Models\TaxClass', 'foreignKey' => 'tax_class_id'),
            'taxRate' => array('belongsTo', 'CodeTrim\Models\TaxRate', 'foreignKey' => 'tax_rate_id')
        );
    }
