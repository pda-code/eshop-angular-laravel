<?php

    use CodeTrim\Models\Customer;

    class Authentication_Test extends TestCase {

        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testBasicExample()
        {
            $credentiasInInvalid = array('email'=>'pda.clms@gmail.com', 'password'=>'admin1');
            $result=Auth::attempt($credentiasInInvalid);
            $token = JWTAuth::attempt($credentiasInInvalid);
            $this->assertFalse($token);

            $credentiasValid = array('email'=>'pda.clms@gmail.com', 'password'=>'admin');
            $result=Auth::attempt($credentiasValid);
            $customer=Auth::user();
            $id = Auth::id();
            $token = JWTAuth::attempt($credentiasValid);
            $customer=Auth::user();
            $this->assertNotEmpty($token);

            $customer=Customer::whereEmail('pda.clms@gmail.com')->first();
            $tokenCustomer = JWTAuth::fromUser($customer);
            $this->assertNotEmpty($tokenCustomer);
            $this->assertEquals($token,$tokenCustomer);

            $subject=JWTAuth::getSubject($tokenCustomer); // SOS! returns Customer->id === 1
        }

        public function testToken()
        {
            $app=app();
            $config=$app->config;

            $user=Config::get("jwt::user");
            $identifier=Config::get("jwt::identifier");

            $customer=Customer::whereEmail('pda.clms@gmail.com')->first();
            $token = JWTAuth::fromUser($customer);
            $subject=JWTAuth::getSubject($token); // SOS! returns Customer->id === 1

            $this->assertEquals($customer->id,$subject);

            $claims=new  stdClass();
            $claims->currency_id=3;
            $claims->language_id=1;

            $token = JWTAuth::encode(1,array('currency_id'=>3,'language_id'=>1));

            $decoded=JWTAuth::decode($token->get());
            /********************** Prints ****************************/
            /*
             * Tymon\JWTAuth\Payload Object
                                        (
                                            [value:protected] => Array
                                                (
                                                    [currency_id] => 3
                                                    [language_id] => 1
                                                    [iss] => http://localhost
                                                    [sub] => 1
                                                    [iat] => 1417101103
                                                    [exp] => 1417187503
                                                )

                                        )
             */
        }

        public function testRoute()
        {
            $customer=Customer::whereEmail('pda.clms@gmail.com')->first();
            $token1 = JWTAuth::attempt(["email"=>'pda.clms@gmail.com', "password"=>"admin"]);
            $token2 = JWTAuth::fromUser($customer);

            $access_token=$token1;

            $response = $this->call('GET', '/testtoken',[],[],array('HTTP_authorization' => 'bearer ' . $access_token, "HTTP_custom"=>"custom header"));
            $this->assertTrue($response->isOk());
        }
    }
