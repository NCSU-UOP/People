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
        if (! Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->string('employee_id', env("NON_ACADEMIC_STAFF_EMPLOYEE_ID_MAX", 20))->unique();
                $table->string('fname', env("NON_ACADEMIC_STAFF_FNAME_MAX", 20));
                $table->string('lname', env("NON_ACADEMIC_STAFF_LNAME_MAX", 20));
                $table->string('initial', env("NON_ACADEMIC_STAFF_INITIAL_MAX", 30));
                $table->string('fullname', env("NON_ACADEMIC_STAFF_FULLNAME_MAX", 100));
                $table->string('city', env("NON_ACADEMIC_STAFF_CITY_MAX", 50));
                $table->string('address', env("NON_ACADEMIC_STAFF_ADDRESS_MAX", 200));            
                $table->string('image', env("NON_ACADEMIC_STAFF_IMAGE_PATH_MAX", 200))->unique();          
                $table->integer('department_id');
                $table->integer('faculty_id');
                $table->boolean('is_rejected')->default(false);
                $table->timestamps();

                $table->foreign('id')->references('id')->on($userTable);
                $table->foreign('department_id')->references('id')->on($departmentTable);
                $table->foreign('faculty_id')->references('id')->on($facultyTable);


                $table->id();
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
