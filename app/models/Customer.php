<?php
    namespace CodeTrim\Models;

    use Illuminate\Auth\UserTrait;
    use Illuminate\Auth\UserInterface;
    use CodeTrim\Models\BaseMode;

    class Customer extends BaseModel
    {
        //tables
        protected $table = 'customers';
        protected $primaryKey = 'id';
        public $timestamps = true;

        // Auto hash passwords
        public static $passwordAttributes = array('password');
        public $autoHashPasswordAttributes = true;
        public $autoPurgeRedundantAttributes = true;

        // fillable
        protected $fillable = array(
            'customer_group_id',
            'first_name',
            'last_name',
            'email',
            'password',
            'password_confirmation',
            'phone',
            'newsletter',
            'address_id',
            'status',
            'approved',
            'ip',
            'custom_field',
        );

        //quared, hidden, fillable
        protected $guarded = array('id', 'created_at', 'updated_at');
        protected $hidden = array('cart', 'wishlist', 'salt', 'status', 'approved', 'password');

        // rules
        public static $rules = array(
            'first_name' => 'required|between:3,32',
            'last_name' => 'required|between:3,32',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|same:password'
        );

        // relations
        public static $relationsData = array(
            'defaultAddress' => array('belongsTo', 'CodeTrim\Models\Address', 'foreignKey' => 'address_id'),
            'addresses' => array('hasMany', 'CodeTrim\Models\Address', 'foreignKey' => 'customer_id'),
            'store' => array('belongsTo', 'CodeTrim\Models\Store', 'foreignKey' => 'store_id')
        );

        public function beforeValidate()
        {
            // create
            if ($this->exists) {
                self::$rules['email'] = '';
                self::$rules['password'] = '';
                self::$rules['password_confirmation'] = '';
            }
        }


        /*
        public function beforeSave() {
            // if there's a new password, hash it
            if($this->isDirty('password')) {
                $this->password = Hash::make($this->password);
            }

            return true;
            //or don't return nothing, since only a boolean false will halt the operation
        }
        */
    }
