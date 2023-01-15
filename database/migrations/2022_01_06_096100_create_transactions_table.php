<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no');
            $table->foreignId('session_id')->nullable()->references('id')->on('sessions')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->references('id')->on('students')->onDelete('cascade');
            $table->string('income_type')->nullable();
            $table->string('expense_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('amount');
            $table->enum('type', ['income', 'expense']);
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
        Schema::dropIfExists('transactions');
    }
}
