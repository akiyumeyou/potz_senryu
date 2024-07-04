<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('groupname');
            $table->unsignedBigInteger('creator_user');
            $table->boolean('ai_flg')->default(false);
            $table->unsignedBigInteger('ai_userid')->nullable();
            $table->timestamps();

            $table->foreign('creator_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ai_userid')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
