<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToDevice extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->enum('type',['internal','developer','user'])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('type');
        });
    }
}
