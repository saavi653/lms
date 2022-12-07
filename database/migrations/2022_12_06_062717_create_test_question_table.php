<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained();
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('test_questions')->cascadeOnDelete(); 
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
        Schema::dropIfExists('test_question');
    }
};
