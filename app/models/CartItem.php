<?php

    namespace CodeTrim\Models;

    class CartItem implements \JsonSerializable
    {
        public function __construct($quantity, $product)
        {
            $this->quantity = $quantity;
            $this->product = $product;
        }

        public function getTax()
        {
            return $this->quantity * $this->product->tax;
        }

        public function getTotal()
        {
            return $this->quantity * $this->product->price;
        }

        public function getTotalIncludingTax()
        {
            return $this->getTax() + $this->getTotal();
        }


        public function jsonSerialize()
        {
            return array(
                'quantity' => $this->quantity,
                'product' => $this->product,
                'tax' => $this->getTax(),
                'total' => $this->getTotal(),
                'total_including_tax' => $this->getTotalIncludingTax(),
            );
        }
    }