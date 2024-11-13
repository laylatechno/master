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
            $table->foreignId('menu_group_id')->constrained('menu_groups');
            $table->integer('position');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items'); // Relasi dengan item menu induk (parent)
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
