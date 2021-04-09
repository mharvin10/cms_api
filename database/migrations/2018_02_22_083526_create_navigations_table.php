<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->smallIncrements('id')->unssigned();
            $table->char('type', 50)->default('link');
            $table->string('page_node_id', 15)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('url')->nullable();
            $table->integer('disposition')->nullable();
            $table->boolean('hidden')->default(0);
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
        Schema::dropIfExists('navigations');
    }
}
