<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class TaxRuleBase extends Ardent
    {
        protected $table = 'tax_rules';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'tax_class_id',
            'tax_rate_id',
            'based',
            'priority');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'tax_class_id' => 'integer',
            'tax_rate_id' => 'integer',
            'based' => 'max:10',
            'priority' => 'integer'
        );

        // relations
        public static $relationsData = array(
            'taxRate' => array('belongsTo', 'TaxRate', 'foreignKey' => 'tax_rate_id')
        );


    }