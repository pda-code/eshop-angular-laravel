<?php

    namespace CodeTrim\Models;

    use CodeTrim\Models\OrderTotal;

    class Cart implements \JsonSerializable
    {
        const SHOPPING_CART = "SHOPPING";
        const WISHLIST_CART = "WISHLIST";
        const COMPARE_CART = "COMPARE";

        public function __construct($type)
        {
            $this->items = array();
            $this->type = $type;
        }

        public function add($quantity, $product)
        {
            $cart_item = new CartItem($quantity, $product);

            if (array_key_exists($product->id, $this->items)) {
                $cart_item = $this->items[$product->id];
                if ($this->type === Cart::SHOPPING_CART)
                    $cart_item->quantity += $quantity;
            } else
                $this->items[$product->id] = $cart_item;

            return $cart_item;
        }

        public function update($id, $quantity)
        {
            if ($this->type !== Cart::SHOPPING_CART) return;

            if (array_key_exists($id, $this->items)) {
                $cart_item = $this->items[$id];
                $cart_item->quantity = $quantity;

                if ($cart_item->quantity === 0) $this->remove($id);
            }
        }

        public function remove($id)
        {
            if (array_key_exists($id, $this->items)) {
                $cart_item = $this->items[$id];
                unset($this->items[$id]);
            }
        }


        public function getTaxes()
        {
            $taxes = array();
            foreach ($this->items as $item)
                foreach ($item->product->taxes as $tax)
                    if (!array_key_exists($tax->id, $taxes)) {
                        $tax = new AppliedTax();
                        $tax->id = $tax->id;
                        $tax->name = $tax->name;
                        $tax->amount = $item->quantity * $tax->amount;
                    } else {
                        $tax = $taxes[$tax->id];
                        $tax->amount += ($item->quantity * $tax->amount);
                    }

            return array_values($taxes);
        }

        public function getTax()
        {
            $tax = 0;
            foreach ($this->items as $item)
                $tax += $item->getTax();

            return $tax;
        }

        public function getTotal()
        {
            $total = 0;
            foreach ($this->items as $item)
                $total += $item->getTotal();

            return $total;
        }

        public function getTotalIncludingTax()
        {
            return $this->getTax() + $this->getTotal();
        }


        public function getTotals()
        {
            $totals = array();

            //Sub Total
            $orderTotal = new OrderTotal();
            $orderTotal->title = "Sub Total";
            $orderTotal->value = $this->getTotal();
            $totals[] = $orderTotal;

            //Taxes
            $taxes = $this->getTaxes();
            foreach ($taxes as $tax) {
                $orderTotal = new OrderTotal();
                $orderTotal->title = $tax['name'];
                $orderTotal->value = $tax['tax'];
                $totals[] = $orderTotal;
            }

            //Total
            $orderTotal = new OrderTotal();
            $orderTotal->title = 'Total';
            $orderTotal->value = $this->getTotalIncludingTax();
            $totals[] = $orderTotal;


            return $totals;
        }

        public function jsonSerialize()
        {
            return array(
                'items' => array_values($this->items),
                'totals' => $this->getTotals(),
                'tax' => $this->getTax(),
                'total' => $this->getTotal(),
                'total_including_tax' => $this->getTotalIncludingTax()
            );
        }


        public function fromJson()
        {
            return json_decode($this);
        }


        public function import($otherCart)
        {
            foreach ($otherCart->items as $item) {
                if (array_key_exists($item->product->product_id, $this->items)) continue;
                $this->add($item->quantity, $item->product);
            }
        }
    }