<?php

namespace App\Filament\Resources\ContentType\BlogResource\Pages;

use SolutionForest\FilamentCms\Concern\CanPublishPage;
use App\Filament\Resources\ContentType\BlogResource;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use SolutionForest\FilamentCms\Concern;

class CreateBlog extends CreateRecord
{
    use Translatable;
    use CanPublishPage;

    protected static string $resource = BlogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return static::getResource()::mutateFormDataBeforeCreate($data);
    }

    public function getActions(): array
    {
        return array_merge(
            [LocaleSwitcher::make()],
            parent::getActions() ?? [],
        );
    }

    protected static function canUnpublishPage(): bool
    {
        return false;
    }
}
