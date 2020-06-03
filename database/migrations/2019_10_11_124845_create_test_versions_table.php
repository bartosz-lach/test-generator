<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_versions', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('test_id');
            $table->foreign('test_id')
                ->references('id')->on('tests')
                ->onDelete('cascade');
            $table->string('name');
            $table->json('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_versions');
    }
}
