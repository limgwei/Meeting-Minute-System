<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvitationLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_links', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->integer('group_id');
            $table->integer('receiver_id');
            $table->integer('is_seen');
            $table->string('is_approve');
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
        //
    }
}
