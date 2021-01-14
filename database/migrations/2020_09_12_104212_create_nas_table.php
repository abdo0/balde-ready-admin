<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nas', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->string('nas_ip', 100)->nullable(false);
            $table->string('nas_username', 100)->nullable(false);
            $table->string('nas_password', 100)->nullable(false);
            $table->string('nas_ssh_port', 100)->nullable()->default(22);
            $table->integer('nas_device_type')->nullable()->default(0);
            $table->string('check_reach', 45)->nullable();
            $table->tinyInteger('active')->nullable()->default(0);
            $table->integer('zone_id')->default(0);
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
        Schema::dropIfExists('n_a_s');
    }
}
