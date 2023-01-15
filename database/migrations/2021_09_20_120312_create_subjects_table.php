<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classses')->onDelete('cascade');
            $table->integer('code');
            $table->string('name');
            $table->string('image')->nullable();
            $table->enum('type', ['theory', 'practical'])->default('theory');
            $table->boolean('is_optional')->default(false);
            $table->integer('total_marks')->default(100);
            $table->integer('pass_marks')->default(40);
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
        Schema::dropIfExists('subjects');
    }
}
