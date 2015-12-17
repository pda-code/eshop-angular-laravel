<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Currency extends BaseModel
    {
        protected $table = "currencies";
        protected $primaryKey = 'id';

        /**
         * @param $price
         * @return string
         */
        public function format($price)
        {
            return number_format(round($price, (int)$this->decimal_place), (int)$this->decimal_place, $this->decimal_point, $this->thousand_point);
        }
    }