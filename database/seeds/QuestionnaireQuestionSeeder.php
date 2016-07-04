<?php

use App\Models\QuestionnaireQuestion;
use Illuminate\Database\Seeder;

class QuestionnaireQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Built In Question
        QuestionnaireQuestion::create([
        	'id' => 997,
        	'question' => 'Apakah kegiatan Anda setelah lulus sekarang ini ?',
        	'type' => 'Radio',
        	'required' => 1,
        	'built_in' => 1,
    	]);
        QuestionnaireQuestion::create([
        	'id' => 998,
        	'question' => 'Menurut Anda, bagaimana relevansi pekerjaan Anda atau pekerjaan yang Anda harapkan dengan Bidang Ilmu yang saudara tempuh saat kuliah?',
        	'type' => 'Radio',
        	'required' => 1,
        	'built_in' => 1,
    	]);

    	// Testing Question Non Built In
        QuestionnaireQuestion::create([
        	'id' => 1,
        	'question' => 'Pada saat baru lulus, sebenarnya di mana Anda ingin bekerja?',
        	'type' => 'Checkbox',
        	'position' => 1,
        	'required' => 1,
        	'built_in' => 0,
    	]);
        QuestionnaireQuestion::create([
        	'id' => 2,
        	'question' => 'Pada saat baru lulus, apakah Anda bersedia bekerja/ditempatkan di daerah?',
        	'type' => 'Yes or No',
        	'position' => 2,
        	'required' => 1,
        	'built_in' => 0,
    	]);
        QuestionnaireQuestion::create([
        	'id' => 3,
        	'question' => 'Pada saat baru lulus, apakah Anda mengetahui cara/prosedur melamar pekerjaan? ',
        	'type' => 'Yes or No',
        	'position' => 3,
        	'required' => 1,
        	'built_in' => 0,
    	]);
        QuestionnaireQuestion::create([
        	'id' => 4,
        	'question' => 'Menurut Anda, mata kuliah apa yang Anda dapatkan dari bangku kuliah yang paling relevan dengan pekerjaan Anda saat ini? (Catatan: jika menyebutkan lebih dari 1, pisahkan dengan koma)',
        	'type' => 'Text',
        	'position' => 4,
        	'required' => 1,
        	'built_in' => 0,
    	]);
    }
}
