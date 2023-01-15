<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('section_id');
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('room_id')->references('id')->on('class_rooms');
            $table->foreign('class_id')->references('id')->on('classses');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_schedules');
    }
}
