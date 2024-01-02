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
        Schema::create('user_tabs', function (Blueprint $table) {
            $table->id();
            $table->char('fullname', 50);
            $table->char('email', 50);
            $table->string('password');
            $table->unsignedTinyInteger('m_access_tabs_id')->default(2)->comment('1 = Admin');
            $table->timestamps();
            $table->foreign('m_access_tabs_id')->on('m_access_tabs')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tabs');
    }
};
