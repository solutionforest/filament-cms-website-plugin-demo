<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentCms\Models\CmsTag as BaseModel;
use Spatie\Translatable\HasTranslations;

class CmsTag extends BaseModel
{
    use HasTranslations;
    protected $translatable = [
        'title',
    ];
}
