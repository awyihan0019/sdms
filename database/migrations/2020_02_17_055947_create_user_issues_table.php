<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_issues', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();

            $table->integer('issue_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')

            ->onDelete('cascade');

            $table->foreign('issue_id')->references('id')->on('issues')

            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_issues');
    }
}
