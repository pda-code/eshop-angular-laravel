<?php
    use CodeTrim\Services\OrderService;

    class OrderService_Test extends TestCase
    {
        public function setUp()
        {
            parent::SetUp();
            $this->faker = Faker\Factory::create();
            $this->service = new OrderService();
        }

        public function test_getById()
        {

        }


        public function test_checkout()
        {
            $data = [
                'billing_address_first_name' => 'panagiotis',
                'billing_address_last_name' => 'antonopoylos',
                'billing_address_company' => 'ASOEE1',
                'billing_address_address_1' => 'Eptanisoy 61',
                'billing_address_address_2' => 'Address 21',
                'billing_address_city' => 'Athens1',
                'billing_address_postal_code' => '164511',
                'billing_address_country_id' => 80,
                'billing_address_zone_id' => 723,
                'shipping_address_same_as_billing_address' => true,
                'shipping_address_first_name' => 'panagiotis',
                'shipping_address_last_name' => 'antonopoylos',
                'shipping_address_company' => 'ASOEE1',
                'shipping_address_address_1' => 'Eptanisoy 61',
                'shipping_address_address_2' => 'Address 21',
                'shipping_address_city' => 'Athens1',
                'shipping_address_postal_code' => '164511',
                'shipping_address_country_id' => 80,
                'shipping_address_zone_id' => 723,
                'customer_id' => 1,
                'customer_first_name' => 'first_name',
                'customer_last_name' => 'last_name',
                'customer_phone' => '8203123',
                'customer_email' => $this->faker->email,
                'line_items' => [
                    ['product_id' => 1, 'name' => 'name', 'model' => 'model', 'quantity' => 2, 'tax' => 10, 'total' => 20, 'total_including_tax' => 30, 'reward' => 0],
                    ['product_id' => 1, 'name' => 'name', 'model' => 'model', 'quantity' => 2, 'tax' => 10, 'total' => 20, 'total_including_tax' => 30, 'reward' => 0]],
                'totals' => [
                    ['code' => 'sub_total', 'title' => 'Sub Total', 'value' => 100, 'sort_order' => 1],
                    ['code' => 'FPA_23%', 'title' => 'FPA 23%', 'value' => 23, 'sort_order' => 2],
                    ['code' => 'FPA_10%', 'title' => 'FPA 10%', 'value' => 10, 'sort_order' => 3],
                    ['code' => 'Shipping', 'title' => 'Shipping', 'value' => 100, 'sort_order' => 4],
                    ['code' => 'Grand_total', 'title' => 'Grand Total', 'value' => 600, 'sort_order' => 5]],
                'shipping_method' =>  'Flat Rate',
                'payment_method' => 'Cash On Delivery',
                'currency_id' => 3,
                'language_id' => 1,
                'total' => 3000
            ];

            $order = $this->service->checkout($data);
            $this->assertTrue($order->exists);
            print_r($order->validationErrors->toArray());
        }

        public function test_destroy()
        {
            $this->service->destroy(73);
        }
    }
