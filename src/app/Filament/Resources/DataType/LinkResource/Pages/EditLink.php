<?php

namespace App\Filament\Resources\DataType\LinkResource\Pages;

use SolutionForest\FilamentCms\Concern\CanPublishPage;
use App\Filament\Resources\DataType\LinkResource;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use SolutionForest\FilamentCms\Concern;

class EditLink extends EditRecord
{
    use Translatable {
    //     Translatable::getActions as protected translatableActions;
    }
    use CanPublishPage;

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
            // [$this->getActiveFormLocaleSelectAction()],
        );
    }
}
