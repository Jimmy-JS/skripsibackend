<?php

use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\WorkingExperience;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserAndQuestionnaireResponseAndWorkingExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $faker->addProvider(new Faker\Provider\Base($faker));
    	$count41 = 0;
    	$count42 = 0;
    	$count51 = 0;
    	$count52 = 0;
    	$count10 = 0;

        // create random 25 general users
        for ($i = 0; $i < 100; $i++) {
        	$digits = 16;
            $email = strtolower($faker->email);
            $year = ['2011','2012', '2013'];
            $studyProgramId = [1,2,3];
            $religion = ['Kristen Protestan', 'Kristen Katholik', 'Islam', 'Buddha'];
            $region = ['Jakarta', 'Aceh', 'Papua Barat', 'Pontianak', 'Medan', 'Manado', 'Palu'];
            $twoDigitNim = ['41','42','51'];
            $generatedtgn = $faker->randomElement($twoDigitNim);
            $count = 0;
            if($generatedtgn == '41') {
            	$count41 ++;
            	$count = $count41;
            } else if($generatedtgn == '42') {
            	$count42 ++;
            	$count = $count42;
            } else if($generatedtgn == '51') {
            	$count51 ++;
            	$count = $count51;
            }
            $generatedYear = $faker->randomElement($year);
            $createdAt = $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d h:i:s');
            $firstName = $faker->firstName(($i % 2 == 0) ? 'male' : 'female');
            $lastName = $faker->lastName;
            $createdUser = User::create([
                'nim' => $generatedtgn.$generatedYear.str_pad($count, 3, '0', STR_PAD_LEFT),
                'study_program_id' => $faker->randomElement($studyProgramId),
                'password' => bcrypt('123456'),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'gender' => ($i % 2 == 0) ? 'male' : 'female',
                'id_number' => rand(1000000, 1999999),
                'class' => $generatedYear,
                'phone' => $faker->phoneNumber,
                'email' => $firstName . '_' . $lastName . $count . '@' . $faker->randomElement(['gmail', 'outlook', 'live', 'hotmail']) .'.com',
                'birth_date' => $faker->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
                'birth_place' => $faker->randomElement($region),
                'religion' => $faker->randomElement($religion),
                'address' => $faker->address,
                'is_admin' => 0,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);

            if (($i + 1) % 4 != 0) {
                $qQuestion = QuestionnaireQuestion::all();
                for ($j = 0; $j<count($qQuestion); $j++) {
                    if ($qQuestion[$j]->type == 'Text' || $qQuestion[$j]->type == 'Textarea') {
                        $respond = $faker->randomElement(['Pengantar Management', 'Kepemimpinan', 'Pemograman', 'Algoritma', 'Java', 'Pengantar Psikologi']);
                    } else if ($qQuestion[$j]->type == 'Checkbox') {
                        $respond = $faker->randomElement(['9,11', '9,12', '9,13', '9,14', '10,12']);
                    } else if ($qQuestion[$j]->type == 'Radio') {
                        if($qQuestion[$j]->id == 997)
                            $respond = $faker->randomElement([1, 2, 3]);
                        else if($qQuestion[$j]->id == 998)
                            $respond = $faker->randomElement([4, 5, 6, 7, 8]);
                    } else if ($qQuestion[$j]->type == 'Yes or No') {
                        $respond = $faker->randomElement(['Yes', 'No']);
                    }
                    QuestionnaireResponse::create([
                        'user_id' => $createdUser->id,
                        'questionnaire_question_id' => $qQuestion[$j]->id,
                        'response' => $respond,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt
                    ]);
                }

                $position = ['Customer Service', 'IT Support', 'Backend Developer', 'Private Teacher', 'Secretary', 'CEO'];
                $location = ['Bandung', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan', 'Tanggerang', 'Bogor'];
                $company = ['Company XYZ', 'PT. ABC', 'PT. Kalbe', 'PT. Accenture', 'PT. K2ost'];
                for ($w = 0; $w < rand(1,5); $w++) {
                    $cDate = Carbon::create(rand(2007, 2015), rand(1, 12), rand(1, 28), 0);
                    $startDate = $cDate->format('Y-m-d');
                    $endDate = $cDate->addMonths(rand(3, 12));
                    $country = ['Afghanistan','Angola','Albania','United Arab Emirates','Argentina','Armenia','French Southern and Antarctic Lands','Australia','Austria','Azerbaijan','Burundi','Belgium','Benin','Burkina Faso','Bangladesh','Bulgaria','The Bahamas','Bosnia and Herzegovina','Belarus','Belize','Bermuda','Bolivia','Brazil','Brunei','Bhutan','Botswana','Central African Republic','Canada','Switzerland','Chile','China','Ivory Coast','Cameroon','Democratic Republic of the Congo','Republic of the Congo','Colombia','Costa Rica','Cuba','Northern Cyprus','Cyprus','Czech Republic','Germany','Djibouti','Denmark','Dominican Republic','Algeria','Ecuador','Egypt','Eritrea','Spain','Estonia','Ethiopia','Finland','Fiji','Falkland Islands','France','Gabon','United Kingdom','Georgia','Ghana','Guinea','Gambia','Guinea Bissau','Equatorial Guinea','Greece','Greenland','Guatemala','French Guiana','Guyana','Honduras','Croatia','Haiti','Hungary','Indonesia','India','Ireland','Iran','Iraq','Iceland','Israel','Italy','Jamaica','Jordan','Japan','Kazakhstan','Kenya','Kyrgyzstan','Cambodia','South Korea','Kosovo','Kuwait','Laos','Lebanon','Liberia','Libya','Sri Lanka','Lesotho','Lithuania','Luxembourg','Latvia','Morocco','Moldova','Madagascar','Mexico','Macedonia','Mali','Myanmar','Montenegro','Mongolia','Mozambique','Mauritania','Malawi','Malaysia','Namibia','New Caledonia','Niger','Nigeria','Nicaragua','Netherlands','Norway','Nepal','New Zealand','Oman','Pakistan','Panama','Peru','Philippines','Papua New Guinea','Poland','Puerto Rico','North Korea','Portugal','Paraguay','Qatar','Romania','Russia','Rwanda','Western Sahara','Saudi Arabia','Sudan','South Sudan','Senegal','Solomon Islands','Sierra Leone','El Salvador','Somaliland','Somalia','Republic of Serbia','Suriname','Slovakia','Slovenia','Sweden','Swaziland','Syria','Chad','Togo','Thailand','Tajikistan','Turkmenistan','East Timor','Trinidad and Tobago','Tunisia','Turkey','United Republic of Tanzania','Uganda','Ukraine','Uruguay','United States of America','Uzbekistan','Venezuela','Vietnam','Vanuatu','West Bank','Yemen','South Africa','Zambia','Zimbabwe'];
                    if ($w == 0) {
                        $country = ['Indonesia'];
                    }
                    WorkingExperience::create([
                        'user_id' => $createdUser->id,
                        'position' => $faker->randomElement($position),
                        'company' => $faker->randomElement($company),
                        'location' => $faker->randomElement($location),
                        'country' => $faker->randomElement($country),
                        'start_date' => $startDate,
                        'end_date' => $endDate
                    ]);
                }
            }
        }

        User::create([
            'nim' => time(),
            'password' => bcrypt('123456'),
            'first_name' => 'admin',
            'email' => 'admin@admin.com',
            'is_admin' => 1
        ]);

        User::create([
            'nim' => time() + 1,
            'password' => bcrypt('123456'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super@admin.com',
            'is_admin' => 1,
            'is_super_admin' => 1
        ]);


        for ($w = 0; $w < rand(3,5); $w++) {
            $cDate = Carbon::create(rand(2007, 2015), rand(1, 12), rand(1, 28), 0);
            $startDate = $cDate->format('Y-m-d');
            $endDate = $cDate->addMonths(rand(3, 12));
            $position = ['Customer Service', 'IT Support', 'Backend Developer', 'Private Teacher', 'Secretary', 'CEO'];
            $location = ['Bandung', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan', 'Tanggerang', 'Bogor'];
            $company = ['Company XYZ', 'PT. ABC', 'PT. Kalbe', 'PT. Accentari', 'PT. Litelabs', 'PT. Virema', 'PT. Prominensa'];
            $country = ['Afghanistan','Angola','Albania','United Arab Emirates','Argentina','Armenia','French Southern and Antarctic Lands','Australia','Austria','Azerbaijan','Burundi','Belgium','Benin','Burkina Faso','Bangladesh','Bulgaria','The Bahamas','Bosnia and Herzegovina','Belarus','Belize','Bermuda','Bolivia','Brazil','Brunei','Bhutan','Botswana','Central African Republic','Canada','Switzerland','Chile','China','Ivory Coast','Cameroon','Democratic Republic of the Congo','Republic of the Congo','Colombia','Costa Rica','Cuba','Northern Cyprus','Cyprus','Czech Republic','Germany','Djibouti','Denmark','Dominican Republic','Algeria','Ecuador','Egypt','Eritrea','Spain','Estonia','Ethiopia','Finland','Fiji','Falkland Islands','France','Gabon','United Kingdom','Georgia','Ghana','Guinea','Gambia','Guinea Bissau','Equatorial Guinea','Greece','Greenland','Guatemala','French Guiana','Guyana','Honduras','Croatia','Haiti','Hungary','Indonesia','India','Ireland','Iran','Iraq','Iceland','Israel','Italy','Jamaica','Jordan','Japan','Kazakhstan','Kenya','Kyrgyzstan','Cambodia','South Korea','Kosovo','Kuwait','Laos','Lebanon','Liberia','Libya','Sri Lanka','Lesotho','Lithuania','Luxembourg','Latvia','Morocco','Moldova','Madagascar','Mexico','Macedonia','Mali','Myanmar','Montenegro','Mongolia','Mozambique','Mauritania','Malawi','Malaysia','Namibia','New Caledonia','Niger','Nigeria','Nicaragua','Netherlands','Norway','Nepal','New Zealand','Oman','Pakistan','Panama','Peru','Philippines','Papua New Guinea','Poland','Puerto Rico','North Korea','Portugal','Paraguay','Qatar','Romania','Russia','Rwanda','Western Sahara','Saudi Arabia','Sudan','South Sudan','Senegal','Solomon Islands','Sierra Leone','El Salvador','Somaliland','Somalia','Republic of Serbia','Suriname','Slovakia','Slovenia','Sweden','Swaziland','Syria','Chad','Togo','Thailand','Tajikistan','Turkmenistan','East Timor','Trinidad and Tobago','Tunisia','Turkey','United Republic of Tanzania','Uganda','Ukraine','Uruguay','United States of America','Uzbekistan','Venezuela','Vietnam','Vanuatu','West Bank','Yemen','South Africa','Zambia','Zimbabwe'];
            if ($w == 0) {
                $country = ['Indonesia'];
            }
            WorkingExperience::create([
                'user_id' => 102,
                'position' => $faker->randomElement($position),
                'company' => $faker->randomElement($company),
                'location' => $faker->randomElement($location),
                'country' => $faker->randomElement($country),
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
        }
    }
}
