<?php

    namespace CodeTrim\Services;

    use CodeTrim\Models\PaymentMethod;
    use CodeTrim\Models\EloquentRepository;

    class PaymentMethodService
    {
        public function __construct()
        {
            $this->repo = new EloquentRepository(new PaymentMethod);
        }

        public function getAll($params = array(), $language_id)
        {
            //$columns = isset($params['columns']) ? $params['columns'] : array('*');
            //$sort_column = isset($params['sort_column']) ? $params['sort_column'] : null;
            $sort_direction = isset($params['sort_direction']) ? $params['sort_direction'] : 'asc';
            $page_index = isset($params['page_index']) ? $params['page_index'] : null;
            $page_size = isset($params['page_size']) ? $params['page_size'] : null;
            //$includes = isset($params['includes']) ? $params['includes'] : array();
            //$criteria = isset($params['criteria']) ? $params['criteria'] : array();

            $columns = ['payment_methods.*', 'payment_methods_descriptions.name'];
            $sort_column = "sort_order";

            //basic query
            $query = PaymentMethod::leftJoin("payment_methods_descriptions", function ($join) use ($language_id) {
                $join->on('payment_methods.id', '=', 'payment_methods_descriptions.payment_method_id');
                $join->where('payment_methods_descriptions.language_id', '=', $language_id);
            })->orderBy($sort_column, $sort_direction);

            //pagination
            if (isset($page_index) || isset($page_size)) {
                Paginator::setCurrentPage($page_index);
                $items = $query->select($columns)->paginate($page_size);
            } else
                $items = $query->select($columns)->get();
            return $items;
        }

        public function getById($id, $includes = array())
        {

            return Zone::with($includes)->where("id", $id)->first();
        }

        public function create($attributes)
        {
            $payment_method = PaymentMethod::create($attributes);
            /*
            $addressAttrs = ['customer_id' => $customer->id,
                            'firstname' => $customer->firstname,
                            'lastname' => $customer->lastname,
                            'company' => $customer->company,
                            'address_1' => $customer->company,
                            'address_2' => $customer->company,
                            'city' => $customer->company,
                            'postcode' => $customer->company,
                            'country_id' => $customer->company,
                            'zone_id' => $customer->company];

            $address = Address::create($addressAttrs);
            $customer->addresses()->save($address);
            $customer->address()->associate($address);
            $customer->save();
            */
            return $payment_method;
        }

        public function update($id, $attributes)
        {
            $payment_method = PaymentMethod::findOrFail($id);
            $payment_method->update($attributes);
        }

        public function destroy($id)
        {
            //$address = Address::findOrFail($id);
            //$address->delete();

            //delete
            PaymentMethod::destroy($id);
        }
    }