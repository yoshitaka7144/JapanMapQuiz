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
        Schema::create('maps', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("classification_id");
            $table->string("name", 50);
            $table->string("kana", 50);
            $table->string("typing_text", 50);
            $table->string("hint_text", 50);
            $table->integer("editor_user_id")->nullable();
            $table->timestamps();
            $table->unique(['name', 'kana']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps');
    }
};
