<?php

use App\Models\QuestionnaireAvailableAnswer;
use Illuminate\Database\Seeder;

class QuestionnaireAvailableAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // built in answer
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 997,
        	'answer' => 'Bekerja'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 997,
        	'answer' => 'Membuka Usaha'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 997,
        	'answer' => 'Belum Bekerja'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 998,
        	'answer' => 'Sangat Tidak Relevan'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 998,
        	'answer' => 'Tidak Relevan'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 998,
        	'answer' => 'Tidak Tahu'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 998,
        	'answer' => 'Relevan'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 998,
        	'answer' => 'Sangat Relevan'
        ]);
        // Non Built In Answer
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 1,
        	'answer' => 'Pemerintah (Pusat/Departemen)'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 1,
        	'answer' => 'Pemerintah (Daerah)'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 1,
        	'answer' => 'Pemerintah (BUMN, BHMN)'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 1,
        	'answer' => 'Swasta (Jasa)'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 1,
        	'answer' => 'Swasta (Manufaktur)'
        ]);
        QuestionnaireAvailableAnswer::create([
        	'questionnaire_question_id' => 1,
        	'answer' => 'Wiraswasta'
        ]);
    }
}
