<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOpinionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->integer('stars');
            $table->text('opinion_text')->nullable();
            $table->boolean('approved');
            $table->timestamps();
        });

        // Add a check constraint for the stars column using raw SQL
        DB::statement('ALTER TABLE opinions ADD CONSTRAINT chk_stars CHECK (stars > 0 AND stars < 6)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opinions', function (Blueprint $table) {
            // Drop the check constraint using raw SQL before dropping the table
            DB::statement('ALTER TABLE opinions DROP CONSTRAINT IF EXISTS chk_stars');
        });

        Schema::dropIfExists('opinions');
    }
}
