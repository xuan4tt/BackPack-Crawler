<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->bigInteger('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('class_rom')->onDelete('cascade');
            
            $table->bigInteger('url_exam_question_id')->unsigned();
            $table->foreign('url_exam_question_id')->references('id')->on('url_exam_questions')->onDelete('cascade');

            $table->text('link');
            
            $table->text('content');
            $table->text('correct_answer');
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
        Schema::dropIfExists('questions');
    }
}
