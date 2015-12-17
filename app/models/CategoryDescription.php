<?php
    namespace CodeTrim\Models;

    use CodeTrim\Models\BaseModel;

    class CategoryDescription extends BaseModel
    {
        protected $table = "categories_description";

        public function category()
        {
            return $this->belongsTo('Category');
        }

        public function scopeTree($query)
        {
            return $query->whereName(NULL);
        }
    }