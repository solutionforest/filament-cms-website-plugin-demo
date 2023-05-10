<?php

namespace App\CmsPages\Templates\DataType;

use Filament\Forms;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Templates\DataTypeTemplate as BaseTemplate;
use Filament\Forms\Components\TextInput;

class Link extends BaseTemplate implements CmsPageTemplate
{
    public static function schema(): array
    {
        return [
        Forms\Components\TextInput::make('url')->label("url"),
        Forms\Components\TextInput::make('description')->label("description"),
        ];
    }

    public static function title(): string
    {
        return 'Link';
    }
}
