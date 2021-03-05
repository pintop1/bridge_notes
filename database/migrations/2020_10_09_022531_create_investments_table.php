<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('status')->default('pending');
            $table->string('tenor');
            $table->datetime('date_approved');
            $table->string('payout')->nullable();
            $table->string('note_number')->nullable();
            $table->datetime('maturity_date')->nullable();
            $table->string('witholding_tax')->nullable();
            $table->string('tenor_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('interest')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('investments');
    }
}
