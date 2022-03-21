<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'departments';
    private $facultyTable = 'faculties';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('faculty_id');
                $table->string('name', env("DEPARTMENTS_NAME_MAX", 100));
                $table->timestamps();

                $table->unique(['faculty_id', 'name']);
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
