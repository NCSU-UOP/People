<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    private $tableName = 'users';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->string('username', env("USERS_USERNAME_MAX", 20))->unique();
                $table->string('email', env("USERS_EMAIL_MAX", 100))->unique()->nullable();
                $table->string('password', env("USERS_PASSWORD_HASH_MAX", 120))->default(Hash::make(env('DEFAULT_PASSWORD')));
                $table->integer('usertype');
                $table->timestamp('email_verified_at')->nullable();
                $table->integer('imported_excel_id')->nullable();
                $table->boolean('password_set')->default(false);
                $table->rememberToken()->default(Str::random(10));
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
        Schema::dropIfExists($this->tableName);
    }
};
