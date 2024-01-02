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
        Schema::create('m_category_tabs', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedBigInteger('user_tabs_id');
            $table->char('title',50);
            $table->timestamps();
            $table->foreign('user_tabs_id')->on('user_tabs')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_category_tabs');
    }
};
