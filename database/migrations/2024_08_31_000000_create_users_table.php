<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->timestamps();
        });

        // Add a default user to the table
        DB::table('user')->insert([
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
            ]);

    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
}
