<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingAttendancesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_attendances_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id');
            $table->integer('is_present');
            $table->integer('user_id');
            $table->string('position');
            $table->timestamps();
        });

        Schema::table('group_members', function (Blueprint $table) {
            $table->string('position')->nullable()->after('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_attendances_tables');
    }
}
