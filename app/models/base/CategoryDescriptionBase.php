<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class CategoryDescriptionBase extends Ardent
    {
        protected $table = 'categories_descriptions';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'category_id',
            'language_id',
            'name',
            'description',
            'meta_title',
            'meta_description',
            'meta_keyword');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'name' => 'max:255',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keyword' => 'max:255'
        );

        // relations
        public static $relationsData = array();


    }