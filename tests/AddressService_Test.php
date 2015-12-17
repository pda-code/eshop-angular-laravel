<?php
    use CodeTrim\Services\AddressService;

    class AddressService_Test extends TestCase
    {
        public function setUp()
        {
            parent::SetUp();
            $this->faker = Faker\Factory::create();
            $this->service = new AddressService();
        }

        public function test_getById()
        {

        }

        public function test_create()
        {
            $data = [
                "id" => null,
                "customer_id" => null,
                "first_name" => "panagiotis",
                "last_name" => "antonopoylos",
                "company" => "ASOEE1",
                "address_1" => "Eptanisoy 61",
                "address_2" => "Address 21",
                "city" => "Athens1",
                "postal_code" => "164511",
                "country_id" => 80,
                "zone_id" => 723];

            $address = $this->service->create($data);
            $this->assertTrue($address->exists);
        }

        public function test_destroy()
        {
            $this->service->destroy(73);
        }
    }
