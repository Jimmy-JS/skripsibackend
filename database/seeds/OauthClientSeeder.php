<?php

use Illuminate\Database\Seeder;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
    		['id' => 'admin', 'secret' => 'admin123!', 'name'=>'Backend Admin', 'created_at' => date('y-m-d h:i:s'), 'updated_at' => date('y-m-d h:i:s')]
    	]);
    }
}
