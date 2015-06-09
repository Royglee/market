<?php
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UsersTableSeeder extends Seeder {
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 10) as $index)
        {
            User::create([
                'name' => $faker->userName.$index,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
            ]);
        }
        User::create([
            'name' => 'Admin',
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}