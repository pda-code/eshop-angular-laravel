<?php

    namespace CodeTrim\Services;

    use CodeTrim\Models\Customer;
    use CodeTrim\Models\Address;
    use CodeTrim\Services\BaseService;
    use CodeTrim\Services\AddressService;
    use Illuminate\Support\Facades\DB;


    class CustomerService extends BaseService
    {
        public function __construct()
        {
            parent::__construct(new Customer());
        }

        public function login($credentials)
        {
            $customer = Customer::where('email', $credentials['email'])->
            where('password', Hash::make($credentials['password']))->first();

            if ($customer != null)
                return $customer;
            else
                return false;
        }

        public function register($attributes)
        {
            return DB::transaction(function ($attributes) use ($attributes) {
                //create customer
                $customer = $this->create($attributes);
                /*
                if (!$customer->exists) return $customer;

                //create default address
                $address_service = new AddressService();
                $address = $address_service->create([
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'customer_id' => $customer->id
                ]);

                $customer->defaultAddress()->associate($address);
                $customer->save();
                */
                return $customer;
            });
        }

        public function destroy($id)
        {
            return DB::transaction(function ($id) use ($id) {

                $customer = Customer::find($id);
                if (!$customer) return;

                $customer->address_id = null;
                $customer->save();

                $customer->addresses()->delete();
                $customer->delete();
            });
        }
    }