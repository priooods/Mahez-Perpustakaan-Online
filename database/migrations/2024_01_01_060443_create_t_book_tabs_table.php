<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_book_tabs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_tabs_id');
            $table->char('title', 120);
            $table->unsignedInteger('m_category_tabs_id');
            $table->text('description');
            $table->integer('count');
            $table->string('book_file');
            $table->string('book_cover');
            $table->timestamps();
            $table->foreign('user_tabs_id')->on('user_tabs')->references('id')->onDelete('cascade');
            $table->foreign('m_category_tabs_id')->on('m_category_tabs')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_book_tabs');
    }
};
