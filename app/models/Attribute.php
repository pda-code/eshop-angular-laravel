<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class Attribute extends BaseModel
    {
        protected $table = "attributes";
        protected $primaryKey = 'id';
    }