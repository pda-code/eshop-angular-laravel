<?php
    use CodeTrim\Meta\Entity;
    use CodeTrim\Meta\Attribute;
    use CodeTrim\Meta\Relation;

    Class Metadata
    {
        public $entities = [];
        public $relations = [];

        public function fillMetadata()
        {
            //Tables
            $tables = DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE table_schema=DATABASE()");
            $this->entities = [];
            foreach ($tables as $table) {
                $entity = new Entity();
                $entity->table = $table->TABLE_NAME;
                $entity->name = $table->TABLE_COMMENT;
                $entity->plurar_name = str_replace("_", "", $table->TABLE_NAME);
                $entity->attributes = $this->getAttributes($entity->table);

                $this->entities[$entity->table] = $entity;
            }

            //relations
            $relations = DB::select("SELECT
                                          `TABLE_SCHEMA`,                          -- Foreign key schema
                                          `TABLE_NAME`,                            -- Foreign key table
                                          `COLUMN_NAME`,                           -- Foreign key column
                                          `REFERENCED_TABLE_SCHEMA`,               -- Origin key schema
                                          `REFERENCED_TABLE_NAME`,                 -- Origin key table
                                          `REFERENCED_COLUMN_NAME`                 -- Origin key column
                                        FROM
                                          `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE`  -- Will fail if user don't have privilege
                                        WHERE
                                          `TABLE_SCHEMA` = SCHEMA()                -- Detect current schema in USE
                                          AND `REFERENCED_TABLE_NAME` IS NOT NULL; -- Only tables with foreign keys");

            foreach ($relations as $rel) {
                $relation = new Relation();
                $relation->table = $rel->TABLE_NAME;
                $relation->entity = $this->entities[$rel->TABLE_NAME];
                $relation->column = $rel->COLUMN_NAME;

                $relation->referenced_table = $rel->REFERENCED_TABLE_NAME;
                $relation->referenced_entity = $this->entities[$rel->REFERENCED_TABLE_NAME];
                $relation->referenced_column = $rel->REFERENCED_COLUMN_NAME;

                //assing relations to entity
                $this->entities[$relation->table]->relations[] = $relation;
                $this->entities[$relation->referenced_table]->relations[] = $relation;

                $this->relations[] = $relation;
            }
        }

        private function getAttributes($table_name)
        {
            $columns = DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema=DATABASE() AND table_name='" . $table_name . "'");
            $attributes = [];

            foreach ($columns as $column) {
                $attribute = new Attribute();
                $attribute->column = $column->COLUMN_NAME;
                $attribute->name = $column->COLUMN_NAME;
                $attribute->type = $column->DATA_TYPE;
                $attribute->length = $column->CHARACTER_MAXIMUM_LENGTH;
                $attribute->nullable = ($column->IS_NULLABLE === 'YES');
                $attribute->isPrimaryKey = ($column->COLUMN_KEY === 'PRI');
                $attribute->isForeignKey = ($column->COLUMN_KEY === 'MUL');
                $attributes[] = $attribute;
            }

            return $attributes;
        }

        function generateModels()
        {
            foreach ($this->entities as $entity) {
                $model = View::make("generator.model", ['entity' => $entity,
                    'entity_name' => $entity->name . "Base",
                    'php_strart' => '<?php',
                    'brace_strart' => '{',
                    'brace_end' => '}'])->render();

                File::put(app_path() . "/models/base/" . $entity->name . "Base.php", $model);
            }
        }
    }