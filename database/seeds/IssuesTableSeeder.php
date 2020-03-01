<?php

use Illuminate\Database\Seeder;
use App\Issue;

class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // factory(App\Issue::class, 50)->create()->each(function($i) {
        //     $i->project()->save(factory(App\Project::class)->make());
        // });
        factory(Issue::class, 50)->create();
    }
}
