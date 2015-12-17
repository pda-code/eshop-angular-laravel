<?php

    /**
     * Created by PhpStorm.
     * User: pda
     * Date: 3/11/2014
     * Time: 1:14 μμ
     */
    class UsersTableSeeder extends Seeder
    {
        public function run()
        {
            DB::table('users')->delete();

            User::create(array(
                'email' => 'pda.clms@gmail.com',
                'password' => Hash::make('admin')
            ));
        }
    }