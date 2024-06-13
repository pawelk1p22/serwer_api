<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTutorsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the view
        DB::statement('CREATE VIEW tutors AS SELECT * FROM users WHERE is_tutor = true');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the view
        DB::statement('DROP VIEW IF EXISTS tutors');
    }
}
