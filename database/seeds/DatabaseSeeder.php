<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    protected $tables = [
        'users',
        'accounts'
    ];

    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        Model::unguard();
        $this->cleanDatabase();

        $this->call('UsersTableSeeder');
        $this->call('AccountsTableSeeder');

        Model::reguard();
    }

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->tables as $table)
        {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}



