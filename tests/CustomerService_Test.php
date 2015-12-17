<?php
    use CodeTrim\Services\CustomerService;
    use CodeTrim\Models\Customer;
    use \LaravelBook\Ardent\Ardent;
class CustomerService_Test extends TestCase {

    public function setUp()
    {
        parent::SetUp();
        $this->faker=Faker\Factory::create();
        $this->service = new CustomerService();
    }

	public function test_getById()
    {
        //$this->faker->addProvider(new Faker\Provider\Internet($this->faker));
        //$p=$this->faker->password;
        return;
        $customer=$this->service->getById(1);
        $this->assertNotNull($customer);

        $customer->load('defaultAddress.country','defaultAddress.zone','addresses.country','addresses.zone');

        $sql=$customer->addresses()->toSql();
        $sql=$customer->defaultAddress()->toSql();

        $this->assertEquals(1,$customer->addresses->count());
        $this->assertNotNull($customer->defaultAddress);

        $address=Address::find($customer->defaultAddress->id);

        $sql=$address->customer()->toSql();
        $this->assertNotNull($address->customer);
    }

    public function test_create()
    {
        $data=[
               'is_unregistered'=>false,
               'first_name' => 'first_name',
               'last_name' => 'last_name',
               'email' => 'pda.clms@gmail.com1',
               'password' => 'password',
               'password_confirmation' => 'password',
               'newsletter' => 1];

        $customer = $this->service->create($data);
        //$tr=$customer->email_registered;
        print_r($customer->validationErrors->toArray());
        $this->assertTrue($customer->exists);
        //$this->assertNotNull($customer->defaultAddress);
        //this->assertNotNull($customer->defaultAddress->customer);
    }

    public function test_destroy()
    {
        $this->service->destroy(73);
    }
}
