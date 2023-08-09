<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolutionForest\FilamentCms\Support\Utils;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cms_tags', function (Blueprint $table) {
            $table->text('title')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('cms_tags', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
