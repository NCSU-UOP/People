<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'users';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('username', env("USERS_USERNAME_MAX", 20))->unique();
                $table->string('email', env("USERS_EMAIL_MAX", 100))->unique();
                $table->string('password', env("USERS_PASSWORD_MAX", 120));
                $table->integer('usertype');
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($tableName);
    }
};
