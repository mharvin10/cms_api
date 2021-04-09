<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->text('content')->nullable();
            $table->boolean('featured')->default(0);
            $table->string('thumb_image')->nullable();
            $table->string('photo_album', 15)->nullable();
            $table->boolean('hidden')->default(0);
            $table->string('created_by');
            $table->softDeletes();
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
