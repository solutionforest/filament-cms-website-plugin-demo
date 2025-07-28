<?php

namespace App\Filament\Resources\ContentType\BlogResource\Pages;

use SolutionForest\FilamentCms\Concern\CanPublishPage;
use SolutionForest\FilamentCms\Concern\CanPreviewPage;
use App\Filament\Resources\ContentType\BlogResource;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use SolutionForest\FilamentCms\Concern;

class EditBlog extends EditRecord
{
    use Translatable {
        // Translatable::getActions as protected translatableActions;
    }
    use CanPublishPage;    
    use CanPreviewPage {
        CanPreviewPage::getActions as protected previewPageActions;
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
            [LocaleSwitcher::make()],      
            $this->previewPageActions(),
        );
    }
}
