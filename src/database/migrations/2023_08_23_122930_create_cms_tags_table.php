<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Support\Utils;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_tag_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('title');
            $table->timestamps();
        });
        Schema::create('cms_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug');
            $table->bigInteger('category_id')->unsigned()->index();
            $table->timestamps();

            $table->unique(['slug', 'category_id']);
        });
        Schema::create('cms_taggables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cms_tag_id')->unsigned()->index();
            $table->morphs('taggable');
            $table->timestamps();
        });
        $defaultCategories = [
            'category',
            'tag',
        ];
        collect($defaultCategories)->each(function ($name) {
            Utils::getCmsTagCategoryModel()::query()->firstOrCreate([
                'name' => $name,
            ], [
                'title' => ucfirst($name),
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_taggables');
        Schema::dropIfExists('cms_tags');
        Schema::dropIfExists('cms_tag_categories');
    }
};
