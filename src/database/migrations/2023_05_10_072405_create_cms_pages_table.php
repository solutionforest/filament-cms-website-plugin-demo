<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Enums\PageType;
use SolutionForest\FilamentCms\Support\DbTable;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();

            $table->string('slug');
            $table->text('title');
            $table->longText('data')->nullable();
            $table->longText('template')->nullable();

            $table->string('page_type')->default(PageType::GENERAL);

            DbTable::hasAuthor($table);

            $table->bigInteger('parent_id')->nullable();

            $table->timestamps();

            $table->unique(['slug', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
