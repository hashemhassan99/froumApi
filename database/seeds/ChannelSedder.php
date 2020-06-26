<?php

use Illuminate\Database\Seeder;

class ChannelSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Channel::create([
            'title' => 'laravel 7 '
        ]);

        \App\Channel::create([
            'title' => 'vue.js '
        ]);

        \App\Channel::create([
            'title' => 'java'
        ]);
        \App\Channel::create([
            'title' => 'Asp'
        ]);
    }
}
