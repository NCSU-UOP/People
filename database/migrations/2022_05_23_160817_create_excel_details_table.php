<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'excel_details'; # table name

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->integer('usertype');
            $table->string('excel_filename', env("EXCEL_FILENAME_MAX", 20))->unique();
            $table->unsignedBigInteger('faculty_id');
            $table->integer('batch_id')->nullable();
            $table->boolean('is_imported')->default(false);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excel_details');
    }
};