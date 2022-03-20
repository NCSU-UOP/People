<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'non_academic_staff';
    private $userTable = 'users';
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
                $table->string('employee_id', env("NON_ACADEMIC_STAFF_EMPLOYEE_ID_MAX", 20))->unique();
                $table->string('fname', env("NON_ACADEMIC_STAFF_FNAME_MAX", 20));
                $table->string('lname', env("NON_ACADEMIC_STAFF_LNAME_MAX", 20));
                $table->string('initial', env("NON_ACADEMIC_STAFF_INITIAL_MAX", 30));
                $table->string('fullname', env("NON_ACADEMIC_STAFF_FULLNAME_MAX", 100));
                $table->string('city', env("NON_ACADEMIC_STAFF_CITY_MAX", 50));
                $table->string('address', env("NON_ACADEMIC_STAFF_ADDRESS_MAX", 200));            
                $table->string('image', env("NON_ACADEMIC_STAFF_IMAGE_PATH_MAX", 200));
                // $table->string('image', env("NON_ACADEMIC_STAFF_IMAGE_PATH_MAX", 200))->unique();          
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
