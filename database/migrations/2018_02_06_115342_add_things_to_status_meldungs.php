<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThingsToStatusMeldungs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_meldungs', function (Blueprint $table) {
            $table->string('external_id');
            $table->string('parent_id')->nullable();
            $table->string('permalink');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_meldungs', function (Blueprint $table) {
            $table->dropColumn('external_id');
            $table->dropColumn('parent_id');
            $table->dropColumn('permalink');
        });
    }
}
