<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title',150);
            $table->timestamps();
        });
        Schema::create('taggables', function (Blueprint $table) {
        // Schema::create('post_tag', function (Blueprint $table) {// relacional
            $table->id();
            $table->morphs('taggable'); // Morfica taggagle_id y taggagle_type
        //     $table->foreignId('post_id') // relacional
        //         ->constrained()
        //         ->onDelete('cascade');
            $table->foreignId('tag_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });

        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('post_tag');
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
};
