<?php

namespace App\Filament\Resources\DataType\LinkResource\Pages;

use Filament\Resources\Pages\EditRecord;
use SolutionForest\FilamentCms\Concern;
use App\Filament\Resources\DataType\LinkResource;

class EditLink extends EditRecord
{
    use EditRecord\Concerns\Translatable {
        EditRecord\Concerns\Translatable::getActions as protected translatableActions;
    }
    use Concern\CanPublishPage;

    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return static::getResource()::mutateFormDataBeforeFill($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return static::getResource()::mutateFormDataBeforeSave($data);
    }

    public function getActions(): array
    {
        return array_merge(
            [$this->getActiveFormLocaleSelectAction()],
        );
    }
}
