<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            $table->string('sidebar_bg')->default('#232e3c');
            $table->string('navbar_bg')->default('#fff');
            $table->string('sidebar_text_color')->default('#232e3c');
            $table->string('navbar_text_color')->default('#232e3c');
            $table->enum('layout', ['full-width', 'boxed'])->default('full-width');
            $table->enum('nav_position', ['top', 'left', 'right'])->default('left');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            $table->dropColumn('layout');
            $table->dropColumn('nav_position');
        });
    }
}
