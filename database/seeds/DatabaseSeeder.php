<?php

use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        Eloquent::unguard();
        // Truncate all tables, except migrations & sliders
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            if ($table->Tables_in_skripsibackend == 'migrations') {
                continue;
            }
            
            DB::table($table->Tables_in_skripsibackend)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
        // End Truncate Functions
        $this->call(OauthClientSeeder::class);
        $this->call(QuestionnaireQuestionSeeder::class);
        $this->call(QuestionnaireAvailableAnswerSeeder::class);
        $this->call(FeedbackTableSeeder::class);
        $this->call(UserAndQuestionnaireResponseAndWorkingExperienceSeeder::class);
    }
}
