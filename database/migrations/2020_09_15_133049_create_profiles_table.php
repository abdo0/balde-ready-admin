<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->tinyInteger('active')->nullable()->default(0);
            $table->tinyInteger('zone_active')->nullable()->default(0);
            $table->integer('zone_id')->nullable()->default(0);
            $table->tinyInteger('nas_active')->nullable()->default(0);
            $table->integer('nas_id')->nullable()->default(0);
            $table->tinyInteger('all_rule')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
