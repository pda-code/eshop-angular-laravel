<?php

    namespace CodeTrim\Models\Base;

    use \LaravelBook\Ardent\Ardent;

    class UserBase extends Ardent
    {
        protected $table = 'users';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // fillable
        protected $fillable = array(
            'email',
            'password');

        // guared
        protected $guarded = array('id', 'created_at', 'updated_at');

        // rules
        public static $rules = array(
            'email' => 'required|between:3,255',
            'password' => 'required|between:3,255',
            'created_at' => 'required',
            'updated_at' => 'required'
        );

        // relations
        public static $relationsData = array();


    }