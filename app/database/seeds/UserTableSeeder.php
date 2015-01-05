<?php
class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();

        User::create(array(
            'username' => 'wern',
            'email' => 'ancheta.wern@gmail.com',
            'password' => Hash::make('heyjude')
        ));
    }

}