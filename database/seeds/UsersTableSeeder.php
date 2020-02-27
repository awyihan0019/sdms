<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Aw Yi Han',
            'email' => 'faster960128@gmail.com',
            'password' => '$2y$10$nEDV2y72W6uOLffErYlX4.3okQTKc2vq.VcE8tgrZL.Vsre3Vxdam',
        ]);

        DB::table('users')->insert([
            'name' => 'Vincent',
            'email' => 'faster960128@hotmail.com',
            'password' => '$2y$10$2HBNSEZJUa8H3lD84bX7T.Qnje/NcJq6qwz.72VKi5WVy7gGeCOyi',
        ]);
    }
}
