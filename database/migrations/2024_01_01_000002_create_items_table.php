<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->enum('size', ['xs', 's', 'm', 'l', 'xl', 'xxl']);
            $table->enum('condition', ['new', 'excellent', 'good', 'fair']);
            $table->enum('type', ['tops', 'bottoms', 'dresses', 'outerwear', 'shoes', 'accessories']);
            $table->json('tags')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_available')->default(true);
            $table->integer('point_value')->default(50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
