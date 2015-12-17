<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class TaxClass extends BaseModel
    {
        protected $table = 'tax_classes';
        protected $primaryKey = 'id';

        // Auto purge
        public $autoPurgeRedundantAttributes = true;

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'required|between:3,255',
            'description' => 'required|between:3,255'
        );

        // relations
        //public static $relationsData = array(
        //    'taxRules' => array('hasMany', 'TaxRule', 'foreignKey' => 'tax_class_id')
        //);

        public function taxRules()
        {
            return $this->hasMany('CodeTrim\Models\TaxRule', 'tax_class_id', 'id')->orderBy('priority');
        }

    }
