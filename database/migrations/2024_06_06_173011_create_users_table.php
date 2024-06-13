<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique();
            $table->string('password', 64);
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('nick', 191)->nullable();
            $table->text('about')->nullable();
            $table->integer('class')->nullable();
            $table->boolean('is_tutor')->nullable();
            $table->timestamps();
        });

        // Add check constraint using raw SQL
        DB::statement('ALTER TABLE users ADD CONSTRAINT check_class CHECK (class > 0 AND class < 6)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the check constraint using raw SQL
            DB::statement('ALTER TABLE users DROP CONSTRAINT check_class');
        });

        Schema::dropIfExists('users');
    }
}
