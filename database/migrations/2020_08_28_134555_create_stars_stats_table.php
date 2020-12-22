c<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarsStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stars_stats', function (Blueprint $table) {
            $table->id();
            $table->string('repo_id')->unique();
            $table->string('name', 100);
            $table->string('repo_url', 200);
            $table->text('description');
            $table->integer('stargazers_count');
            $table->dateTime('repo_created_at', 0);
            $table->dateTime('last_pushed_at', 0);

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
        Schema::dropIfExists('stars_stats');
    }
}
