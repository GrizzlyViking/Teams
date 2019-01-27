<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create();

        App\Role::insert([
            ['id' => 1, 'title' => 'developer'],
            ['id' => 2, 'title' => 'junior developer'],
            ['id' => 3, 'title' => 'quality assurance'],
            ['id' => 4, 'title' => 'project manager'],
            ['id' => 5, 'title' => 'team leader']
        ]);
    }
}
