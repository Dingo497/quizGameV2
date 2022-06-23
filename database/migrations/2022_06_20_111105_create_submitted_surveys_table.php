<?php

use App\Models\User;
use App\Models\Survey;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(Survey::class, 'survey_id');
            $table->foreignIdFor(User::class, 'author_user_id');
            $table->integer('achieved_score', false, true);
            $table->integer('total_score', false, true);
            $table->string('achieved_score_in_percent', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submitted_surveys');
    }
};
