<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key', 90)->primary()->nullable(false);
            $table->string('value', 600)->nullable()->default(0);
            $table->integer('private')->nullable()->default(0);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('settings')->insert(['key' => 'nas_default_username']);
        \Illuminate\Support\Facades\DB::table('settings')->insert(['key' => 'nas_default_password']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
