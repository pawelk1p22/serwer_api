<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutoringSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('tutoring_sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tutor_id')->unsigned()->nullable();
            $table->bigInteger('subject_id')->unsigned()->nullable();
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->bigInteger('topic_id')->unsigned()->nullable();
            $table->string('about', 255)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tutor_id')->references('id')->on('users')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')
                  ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')
                  ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutoring_sessions');
    }
}
