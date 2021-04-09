<?php

use Kalnoy\Nestedset\NestedSet;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_nodes', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->string('title');
            $table->string('short_title', 50)->nullable();
            // NestedSet::columns($table);
            $table->integer('_lft')->unsigned()->default(0);
            $table->integer('_rgt')->unsigned()->default(0);
            $table->string('parent_id', 15)->nullable();
            $table->boolean('hidden')->default(0);
            $table->string('created_by');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['_lft', '_rgt', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_nodes');
    }
}
