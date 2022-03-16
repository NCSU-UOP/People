<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'students';
    private $userTable = 'users';
    private $batchTable = 'batches';
    private $departmentTable = 'departments';
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
                $table->string('regNo', env("STUDENTS_REGNO_MAX", 10))->unique();
                $table->string('fname', env("STUDENTS_FNAME_MAX", 20));
                $table->string('lname', env("STUDENTS_LNAME_MAX", 20));
                $table->string('initial', env("STUDENTS_INITIAL_MAX", 30));
                $table->string('fullname', env("STUDENTS_FULLNAME_MAX", 100));
                $table->string('city', env("STUDENTS_CITY_MAX", 50));
                $table->string('address', env("STUDENTS_ADDRESS_MAX", 200));            
                $table->string('image', env("STUDENTS_IMAGE_PATH_MAX", 200))->unique();          
                $table->integer('batch_id');
                $table->unsignedBigInteger('department_id');
                $table->unsignedBigInteger('faculty_id');
                $table->boolean('is_rejected')->default(false);
                $table->timestamps();

                $table->foreign('id')->references('id')->on($this->userTable);
                $table->foreign('batch_id')->references('id')->on($this->batchTable);
                $table->foreign('department_id')->references('id')->on($this->departmentTable);
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
