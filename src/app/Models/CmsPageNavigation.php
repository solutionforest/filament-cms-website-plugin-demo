<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentCms\Models\CmsPageNavigation as BaseModel;
use Spatie\Translatable\HasTranslations;

class CmsPageNavigation extends BaseModel
{
    use HasTranslations;
    protected $translatable = [
        'title',
    ];
}
