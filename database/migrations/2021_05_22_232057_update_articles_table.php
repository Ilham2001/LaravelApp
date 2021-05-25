<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('summary')->nullable()->change();
            $table->string('environment')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('error_message')->nullable()->change();
            $table->integer('ticket_number')->nullable()->change();
            $table->text('cause')->nullable()->change();
            $table->text('resolution')->nullable()->change();
            $table->string('keywords')->nullable()->change();
            $table->string('workaround')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
