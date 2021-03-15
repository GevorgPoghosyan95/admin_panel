<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePage2FolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_2_folder', function (Blueprint $table) {
            $table->id();
            $table->integer('page_id');
            $table->integer('folder_id');
            $table->unique(['page_id','folder_id']);
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
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
        Schema::dropIfExists('page_2_folder');
    }
}
