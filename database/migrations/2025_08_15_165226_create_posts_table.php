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
      Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title', 50);
    $table->text('content')->nullable();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->enum('is_active', ['Yes', 'No'])->default('Yes');
    $table->timestamps();
});


    }
    
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }


};
