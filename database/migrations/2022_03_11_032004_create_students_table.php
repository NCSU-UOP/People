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
                $table->string('regNo', env("STUDENTS_REGNO_MAX", 10));
                $table->string('preferedname', env("STUDENTS_PREFEREDNAME_MAX", 60))->nullable();
                $table->string('initial', env("STUDENTS_INITIAL_MAX", 30));
                $table->string('fullname', env("STUDENTS_FULLNAME_MAX", 100));
                $table->string('city', env("STUDENTS_CITY_MAX", 50))->nullable();
                $table->string('province', env("STUDENTS_PROVINCE_MAX", 50))->nullable();
                $table->string('address', env("STUDENTS_ADDRESS_MAX", 200));            
                $table->string('image', env("STUDENTS_IMAGE_PATH_MAX", 200))->nullable();
                $table->string('bio', env("STUDENTS_BIO_MAX", 200))->nullable();
                $table->string('telephone', env("STUDENTS_TELEPHONE_MAX", 12))->nullable();
                $table->integer('batch_id');
                $table->unsignedBigInteger('department_id')->nullable();
                $table->unsignedBigInteger('faculty_id');
                $table->boolean('is_verified')->default(false);
                $table->boolean('is_rejected')->default(false);
                $table->boolean('is_activated')->default(false);
                $table->boolean('is_visible')->default(true);
                $table->timestamps();

                $table->foreign('id')->references('id')->on($this->userTable)->onDelete('cascade');
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
