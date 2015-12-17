<?php
  namespace CodeTrim\Models;

  use CodeTrim\Models\BaseModel;

  class Category extends BaseModel {
    protected $table = "categories";
    protected $primaryKey = 'id';
    public $timestamps=true;

    public function scopei18n($query, $language_id) {
      return $query->leftJoin('categories_i18n as i18n', function ($join) use ($language_id) {
        $join->on('categories.id', '=', 'i18n.category_id');
        $join->where('i18n.language_id', '=', $language_id);
      });
    }


    public function products()
    {
      return $this->belongsToMany('CodeTrim\Models\Products','products_to_categories','category_id');
    }
  }