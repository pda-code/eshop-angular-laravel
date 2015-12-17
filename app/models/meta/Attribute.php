<?php
    namespace CodeTrim\Meta;

    Class Attribute
    {
        public $column;
        public $name;

        public $type;
        public $length;
        public $nullable;
        public $isPrimaryKey;
        public $isForeignKey;

        public $referenced_table;
        public $referenced_column;

        public function getRule()
        {
            if ($this->isPrimaryKey) return '';

            $rule = [];
            if (!$this->nullable) $rule[] = "required";
            switch ($this->type) {
                case 'varchar':
                    if (!$this->nullable)
                        $rule[] = "between:3," . $this->length;
                    else
                        $rule[] = "max:" . $this->length;
                    break;
                case 'int':
                    $rule[] = "integer";
                    break;

            }

            return implode("|", $rule);
        }
    }