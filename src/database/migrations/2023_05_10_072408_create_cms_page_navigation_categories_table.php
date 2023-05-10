<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Support\DbTable;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_page_navigation_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('title');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_page_navigation_categories');
    }
};
