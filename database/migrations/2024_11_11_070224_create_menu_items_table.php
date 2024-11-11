<?php

use App\Models\MenuGroup;
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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->string('route');
            $table->boolean('status')->default(true);
            $table->string('permission_name');
            // Perbaiki kolom foreign key
            $table->foreignId('menu_group_id')->constrained('menu_groups'); // Relasi dengan table 'menu_groups'
            $table->integer('posision');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
