<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgageApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortgage_applications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 32);
            $table->string('last_name', 64);
            $table->string('email', 64);
            $table->string('phone_number', 16);
            $table->double('net_income', null, 2);
            $table->double('requested_amount',null, 2);
            $table->foreignId('mortgage_expert_id')->index()->nullable()->constrained()->references('id')->on('mortgage_experts');
            $table->dateTime('assignment_date',2)->nullable();
            $table->integer('start_time_slot');
            $table->integer('end_time_slot');
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
        Schema::dropIfExists('mortgage_applications');
    }
}
