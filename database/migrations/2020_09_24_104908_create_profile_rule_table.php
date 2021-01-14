<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_rule', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->integer('profile_id')->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->tinyInteger('active')->nullable()->default(0);
            $table->tinyInteger('cisco_active')->nullable()->default(0);
            $table->string('cisco_policy_map', 100)->nullable();
            $table->string('cisco_class', 100)->nullable();
            $table->integer('cisco_rate')->nullable();
            $table->integer('cisco_burst')->nullable();
            $table->tinyInteger('mikrotik_active')->nullable()->default(0);
            $table->string('mikrotik_type', 100)->nullable();
            $table->integer('mikrotik_rate')->nullable();
            $table->integer('mikrotik_burst_rate')->nullable();
            $table->integer('mikrotik_burst_threshold')->nullable();
            $table->time('mikrotik_burst_time')->nullable();
            $table->integer('mikrotik_classifier')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_rule');
    }
}
