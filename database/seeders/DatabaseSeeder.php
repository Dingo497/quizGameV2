<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // nefunkcny seeder
    User::factory()->count(2)->create()->each(function($user){
      for($i = 0; $i < 3; $i++){
        $user->surveys()->save(Survey::factory()->create()->each(function($survey) {
          $survey->questions()->save(SurveyQuestion::factory()->count(3)->create());
        }));
      }
    });
  }
}
