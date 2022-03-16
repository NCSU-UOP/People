<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'admins';
    private $userTable = 'users';
    private $facultyTable = 'faculties';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('id')->primary();
                $table->unsignedBigInteger('faculty_id');
                $table->string('name', env("ADMINS_NAME_MAX", 100));
                $table->string('remark', env("ADMINS_REMARK_MAX", 100))->nullable();
                $table->boolean('active')->default(false);
                $table->boolean('is_admin')->default(false);
                $table->string('last_online', env("ADMINS_LAST_ONLINE_MAX", 20))->nullable();
                $table->timestamps();
                
                $table->foreign('id')->references('id')->on($this->userTable);
                $table->foreign('faculty_id')->references('id')->on($this->facultyTable);
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
