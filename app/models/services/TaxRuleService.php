<?php

    namespace CodeTrim\Services;

    use CodeTrim\Models\TaxRule;

    class TaxRuleService
    {
        public function __construct()
        {

        }


        public function getAll($params = array())
        {
            $columns = isset($params['columns']) ? $params['columns'] : array('*');
            $sortColumn = isset($params['sort_column']) ? $params['sort_column'] : null;
            $sortDirection = isset($params['sort_direction']) ? $params['sort_direction'] : 'asc';
            $pageIndex = isset($params['page_index']) ? $params['page_index'] : 1;
            $pageSize = isset($params['page_size']) ? $params['page_size'] : 10;
            $includes = isset($params['includes']) ? $params['includes'] : array();
            $criteria = isset($params['criteria']) ? $params['criteria'] : array();

            $query = TaxRule::with($includes);

            if ($sortColumn)
                $query = $query->orderBy($sortColumn, $sortDirection);

            foreach ($criteria as $value) {
                $op = isset($value['op']) ? $value['op'] : '=';
                $query = $query->where($value['column'], $op, $value['value']);
            }

            if (isset($params['page_index']) || isset($params['page_size'])) {
                Paginator::setCurrentPage($pageIndex);
                $items = $query->select($columns)->paginate($pageSize);
            } else
                $items = $query->select($columns)->get();
            return $items;
        }

        public function getById($id)
        {
            return TaxRule::findOrFail($id);
        }

        public function create($attributes)
        {
            $address = TaxRule::create($attributes);
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
            return $address;
        }

        public function update($id, $attributes)
        {
            $item = TaxRule::findOrFail($id);
            $item->update($attributes);
        }

        public function destroy($id)
        {
            //$address = Address::findOrFail($id);
            //$address->delete();

            //delete
            TaxRule::destroy($id);
        }
    }