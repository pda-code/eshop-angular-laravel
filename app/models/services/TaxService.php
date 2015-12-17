<?php
    namespace CodeTrim\Services;

    use CodeTrim\Models\AppliedTax;
    use CodeTrim\Services\TaxClassService;
    use CodeTrim\Services\TaxRuleService;
    use CodeTrim\Services\TaxRateService;
    use CodeTrim\Services\ZoneService;

    class TaxService
    {
        private $tax_class_service;
        private $tax_rate_service;

        private $tax_classes;
        private $tax_rules;
        private $tax_rates;

        public function __construct()
        {
            $this->tax_class_service = new TaxClassService();
            $this->tax_classes = $this->tax_class_service->getAll(['includes' => 'taxRules']);

            $this->tax_rules_service = new TaxRuleService();
            $this->tax_rules = $this->tax_class_service->getAll();

            $this->tax_rate_service = new TaxRateService();
            $this->tax_rates = $this->tax_rate_service->getAll();
        }

        public function calculateTaxes($price, $zone_id, $tax_class_id)
        {
            $taxes = [];

            //find tax class
            $tax_class = $this->tax_classes->find($tax_class_id);
            if ($tax_class == null) return $taxes;

            $zone_service = new ZoneService();
            $zone = $zone_service->getById($zone_id, ['geoZones']);
            if ($zone == null) return $taxes;

            foreach ($this->tax_classes as $tax_class)
                foreach ($tax_class->taxRules as $tax_rule) {
                    $tax_rate = $this->tax_rates->find($tax_rule->tax_rate_id);
                    if ($tax_rate == null) continue;

                    if (!$zone->isinGeoZone($tax_rate->geo_zone_id)) continue;

                    if (!array_key_exists($tax_rule->tax_rate_id, $taxes)) {

                        $tax = new AppliedTax();
                        $tax->id = $tax_rate->id;
                        $tax->name = $tax_rate->name;
                        $tax->amount = $tax_rate->calculateTax($price);

                        $taxes[$tax_rule->tax_rate_id] = $tax;
                    } else {
                        $tax = $taxes[$tax_rule->tax_rate_id];
                        $tax->amount += $tax_rate->calculateTax($price);
                    }
                }

            return array_values($taxes);
        }

        public function calculateSummarizedTax($taxes)
        {
            $total_tax = 0.0;
            foreach ($taxes as $tax)
                $total_tax += $tax->amount;

            return $total_tax;
        }

        /*
        public function calculateSummarizedTax($price,$zone_id, $tax_class_id)
        {
            $taxes=$this->calculateAnalyticalTax($price,$zone_id, $tax_class_id);
            $tax=0.0;
            foreach($taxes as $tax_rate)
                $tax +=$tax_rate['tax'];

            return $tax;
        }
        */
    }