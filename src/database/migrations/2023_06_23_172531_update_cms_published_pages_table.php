<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Support\DbTable;
use SolutionForest\FilamentCms\Support\Utils;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cms_published_pages', function (Blueprint $table) {

            $table->string('slug')->default('')->after('id');
            $table->bigInteger('parent_id')->nullable();
            $table->timestamp('publish_until')->nullable()->after('published_at');
        });

        Utils::getCmsPublishedPageModel()::all()->each(function ($cmsPublishedPage) {
            $draftPage = $cmsPublishedPage->draftPage;

            if ($draftPage) {

                $cmsPublishedPage->slug = $draftPage->slug;
                $cmsPublishedPage->save();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cms_published_pages', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('parent_id');
            $table->dropColumn('publish_until');
        });
    }
};
