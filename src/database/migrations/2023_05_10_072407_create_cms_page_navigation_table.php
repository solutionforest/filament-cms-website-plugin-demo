<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Support\DbTable;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_page_navigation', function (Blueprint $table) {
            $table->id();

            $table->text('title');

            $table->bigInteger('parent_id')->index()->default(-1);
            $table->integer('order')->default(0);

            $table->bigInteger('category_id')->index();

            $table->bigInteger('page_id')->index()->nullable();
            $table->text('url')->nullable();
            $table->string('target')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_page_navigation');
    }
};
