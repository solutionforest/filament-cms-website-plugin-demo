<?php

namespace App\Filament\Resources\DataType\LinkResource\Pages;

use SolutionForest\FilamentCms\Concern\CanPublishPage;
use Filament\Resources\Pages\CreateRecord;
use SolutionForest\FilamentCms\Concern;
use App\Filament\Resources\DataType\LinkResource;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateLink extends CreateRecord
{
    use Translatable;
    use CanPublishPage;

    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return static::getResource()::mutateFormDataBeforeCreate($data);
    }

    public function getActions(): array
    {
        return array_merge(
            // [$this->getActiveFormLocaleSelectAction()],
            // parent::getActions() ?? [],
        );
    }

    protected static function canUnpublishPage(): bool
    {
        return false;
    }
}
