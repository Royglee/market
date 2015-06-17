<?php
use App\Account;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AccountsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        $userIds = User::lists('id')->all();

        foreach(range(1, 100) as $index)
        {
            $countq = $faker->boolean(10);
            if($countq){
                $count = $faker->numberBetween(2,20);
            }
            else {
                $count = null;
            }
            Account::create([
                'countq' => $countq,
                'count' => $count,
                'first_owner' => $faker->boolean(70),
                'has_email' => $faker->boolean(70),
                'duration' => $faker->randomElement([7,14,30]),
                'delivery' => $faker->randomFloat(2,0,72),
                'title' => $faker->sentence(5),
                'price'=> $faker->randomFloat(1,4,250),
                'server'=>$faker->randomElement(['NA', 'EUNE', 'EUW', 'OCE', 'BR', 'LA', 'RU', 'TR', 'KR']),
                'league'=>$faker->randomElement(['Unranked','Bronze','Silver','Gold','Platinum','Diamond','Master','Challenger']),
                'division'=>$faker->numberBetween(1,5),
                'champions'=>$faker->numberBetween(20,160),
                'skins'=>$faker->numberBetween(0,200),
                'body'=>$faker->text,
                'view_count'=>$faker->numberBetween(0,200),
                'user_id'=> $faker->randomElement($userIds),
            ]);
        }
    }
}