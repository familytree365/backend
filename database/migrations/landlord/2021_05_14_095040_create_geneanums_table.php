<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneanumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geneanums', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('remote_id')->index();
            $table->string('date')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('sex')->nullable();
            $table->string('father_first_name')->nullable();
            $table->string('father_is_dead')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_first_name')->nullable();
            $table->string('mother_is_dead')->nullable();
            $table->text('observation1')->nullable();
            $table->text('observation2')->nullable();
            $table->text('observation3')->nullable();
            $table->text('observation4')->nullable();
            $table->string('officer')->nullable();
            $table->string('parish')->nullable();
            $table->string('source')->nullable();
            $table->string('update')->nullable();
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
        Schema::dropIfExists('geneanums');
    }
}
