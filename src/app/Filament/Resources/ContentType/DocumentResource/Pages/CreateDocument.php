<?php

namespace App\Filament\Resources\ContentType\DocumentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use SolutionForest\FilamentCms\Concern;
use App\Filament\Resources\ContentType\DocumentResource;
use Filament\Actions\LocaleSwitcher;

class CreateDocument extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    use Concern\CanPublishPage;

    protected static string $resource = DocumentResource::class;

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
