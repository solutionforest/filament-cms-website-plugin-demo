<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentCms\Models\CmsPage as BaseModel;
use Spatie\Translatable\HasTranslations;

class CmsPage extends BaseModel
{
    use HasTranslations;
    protected $translatable = [
        'title',
        'data',
    ];

    public function isDocumentPage(): bool
    {
        if (is_null($this->parent_id)) {
            return $this->slug == 'docs';
        }
        return $this->parentPage?->isDocumentPage() ?? false;
    }
}
