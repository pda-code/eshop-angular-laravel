<?php
    namespace CodeTrim\Meta;
    Class Entity
    {
        public $table;
        public $name;
        public $plurar_name;
        public $attributes = [];
        public $relations = [];

        public function getRules()
        {
            $rules = [];
            foreach ($this->attributes as $attribute) {
                $rule = $attribute->getRule();
                if ($rule === '') continue;
                $rules[] = "'" . $attribute->name . "' => '" . $rule . "'";
            }

            return implode(",\n", $rules);
        }

        public function getFillable()
        {
            $fillable = [];
            foreach ($this->attributes as $attribute) {
                if ($attribute->name == 'id' || $attribute->name == "created_at" || $attribute->name == "updated_at") continue;
                $fillable[] = "'" . $attribute->name . "'";
            }

            return implode(",\n", $fillable);
        }

        public function getRelations()
        {
            $relations = [];
            foreach ($this->relations as $relation) {
                if ($relation->table == $this->table)
                    $relations[] = sprintf("'%s' => array('belongsTo', '%s', 'foreignKey' => '%s')", camel_case($relation->referenced_entity->name), $relation->referenced_entity->name, $relation->column);
                else
                    $relations[] = sprintf("'%s' => array('hasMany', '%s', 'foreignKey' => '%s')", camel_case($relation->entity->plurar_name), $relation->entity->name, $relation->column);
            }

            return implode(",\n", $relations);
        }
    }