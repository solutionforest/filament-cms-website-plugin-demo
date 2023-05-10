<?php

namespace App\Filament\Resources\ContentType\BlogResource\Pages;

use Filament\Resources\Pages\EditRecord;
use SolutionForest\FilamentCms\Concern;
use App\Filament\Resources\ContentType\BlogResource;

class EditBlog extends EditRecord
{
    // use EditRecord\Concerns\Translatable {
    //     EditRecord\Concerns\Translatable::getActions as protected translatableActions;
    // }
    use Concern\CanPublishPage;    
    use Concern\CanPreviewPage {
        Concern\CanPreviewPage::getActions as protected previewPageActions;
    }

    protected static string $resource = BlogResource::class;

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
            $this->previewPageActions(),
        );
    }
}
