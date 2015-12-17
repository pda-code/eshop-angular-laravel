<?php
    namespace CodeTrim\Services;

    use CodeTrim\Models\LineItem;
    use CodeTrim\Models\OrderTotal;
    use CodeTrim\Services\BaseService;
    use CodeTrim\Services\AddressService;
    use CodeTrim\Services\CustomerService;
    use CodeTrim\Services\LineItemService;
    use CodeTrim\Services\OrderTotalService;
    use Illuminate\Support\Facades\DB;

    use CodeTrim\Models\Order;

    class OrderService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Order);
        }

        public function checkout($attributes)
        {
            return DB::transaction(function ($attributes) use ($attributes) {
                $shipping_address_same_as_billing_address = array_get($attributes, 'shipping_address_same_as_billing_address', false);

                if ($shipping_address_same_as_billing_address) {
                    array_set($attributes, 'shipping_address_first_name', array_get($attributes, 'billing_address_first_name'));
                    array_set($attributes, 'shipping_address_last_name', array_get($attributes, 'billing_address_last_name'));
                    array_set($attributes, 'shipping_address_company', array_get($attributes, 'billing_address_company'));
                    array_set($attributes, 'shipping_address_address_1', array_get($attributes, 'billing_address_address_1'));
                    array_set($attributes, 'shipping_address_address_2', array_get($attributes, 'billing_address_address_2'));
                    array_set($attributes, 'shipping_address_city', array_get($attributes, 'billing_address_city'));
                    array_set($attributes, 'shipping_address_postal_code', array_get($attributes, 'billing_address_postal_code'));
                    array_set($attributes, 'shipping_address_country_id', array_get($attributes, 'billing_address_country_id'));
                    array_set($attributes, 'shipping_address_zone_id', array_get($attributes, 'billing_address_zone_id'));
                }

                $order = $this->create($attributes);

                //add line items
                $line_items = [];
                foreach (array_get($attributes, 'line_items', []) as $line_item) {
                    $line_items[] = new LineItem($line_item);
                }
                $order->lineItems()->saveMany($line_items);

                //add totals
                $totals = [];
                foreach (array_get($attributes, 'totals', []) as $total) {
                    $totals[] = new OrderTotal($total);
                }
                $order->totals()->saveMany($totals);

                return $order;
            });
        }
    }