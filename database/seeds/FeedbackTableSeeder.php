<?php

use App\Models\Feedback;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FeedbackTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        for ($i = 0; $i < 100; $i ++) {
	        $date = $faker->dateTimeBetween('-1 years', '-1 months')->format('Y-m-d h:i:s');
	        Feedback::create([
	        	'user_id' => $i + 1,
	        	'feedback' => $faker->text(400),
	        	'rating' => $faker->randomElement([1,2,3,4,5]),
	        	'created_at' => $date,
	        	'updated_at' => $date
	        ]);
	    }
    }
}
