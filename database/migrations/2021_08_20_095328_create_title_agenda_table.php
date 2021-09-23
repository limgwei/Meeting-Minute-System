<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitleAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('title_agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('meeting_id');
            $table->timestamps();
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->renameColumn('meeting_id','title_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('title_agenda');
    }
}
