<?php

namespace App\CmsPages\Templates\ContentType;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Templates\IndexContentTypeTemplate as BaseTemplate;

class BlogIndex extends BaseTemplate implements CmsPageTemplate
{
    public static function schema(): array
    {
        return [
            Section::make()
                ->schema([
                TextInput::make('title')
                        ->label('Title'),
                    TextInput::make('content')
                        ->label(__('filament-cms::filament-cms.fields.cms_page.block-template.content'))
                ]),
        ];
    }

    public static function title(): string
    {
        return 'BlogIndex';
    }

    public static function getIndexPageKey()
    {
        return '10';
    }
}
