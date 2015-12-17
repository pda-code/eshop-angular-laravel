<?php
    namespace CodeTrim\Models;

    Class StoreConfiguration
    {
        public $name;
        public $owner;
        public $country = null;
        public $zone = null;

        //Taxes
        const TAX_ON_STORE_ADDRESS = "store";
        const TAX_ON_BILLING_ADDRESS = "billing";
        const TAX_ON_SHIPPING_ADDRESS = "shipping";

        public $displayTaxes = true;
        public $taxBasedOn = self::TAX_ON_SHIPPING_ADDRESS;

        public function __construct($model = null)
        {
            $this->name = "pda eShop";
            $this->owner = "pda";

            $this->country = Country::whereName("Greece")->first();
            if ($this->country != null)
                $this->zone = Zone::where('country_id', $this->country->id)->where('name', 'Attica')->first();
        }
    }