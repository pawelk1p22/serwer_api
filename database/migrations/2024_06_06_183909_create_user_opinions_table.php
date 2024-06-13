<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOpinionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_opinions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_reviewed_id');
            $table->unsignedBigInteger('user_giving_review_id');
            $table->unsignedBigInteger('opinion_id');
            $table->foreign('user_reviewed_id')->references('id')->on('users');
            $table->foreign('user_giving_review_id')->references('id')->on('users');
            $table->foreign('opinion_id')->references('id')->on('opinions');
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
        Schema::dropIfExists('user_opinions');
    }
}
