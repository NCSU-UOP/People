<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'batches';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->string('batch', env("DEPARTMENTS_NAME_MAX", 10))->unique();
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
