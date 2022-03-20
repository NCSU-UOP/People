<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'academic_staff';
    private $userTable = 'users';
    private $departmentTable = 'departments';
    private $facultyTable = 'faculties';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('faculty_id');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->timestamps();

            $table->foreign('id')->references('id')->on($this->userTable)->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on($this->departmentTable);
            $table->foreign('faculty_id')->references('id')->on($this->facultyTable);
        });
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
