<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en')->nullable();
            $table->string('title_de')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->text('affected_de')->nullable();
            $table->text('affected_en')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('category')->nullable();
            $table->string('type');
            $table->string('permalink_de')->nullable();
            $table->string('permalink_en')->nullable();
            $table->string('external_id');
            $table->string('parent_id')->nullable();
            $table->timestamp('send_at')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
