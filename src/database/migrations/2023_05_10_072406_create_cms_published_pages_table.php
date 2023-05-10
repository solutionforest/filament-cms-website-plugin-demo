<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Support\DbTable;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_published_pages', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('page_id')->index();
            $table->text('title');
            $table->longText('data')->nullable();
            $table->longText('template')->nullable();

            DbTable::hasAuthor($table);

            $table->timestamp('published_at');

            $table->boolean('is_visible')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_published_pages');
    }
};
