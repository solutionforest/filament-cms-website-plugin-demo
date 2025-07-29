<?php

namespace App\Filament\Widgets;

use Composer\InstalledVersions;
use Filament\Widgets\Widget;

class FilamentCmsInfo extends Widget
{
    protected string $view = 'filament.widgets.filament-cms-info';

    protected int | string | array $columnSpan = 'full';

    public ?array $limit = null;

    public bool $showDemoLink = true;

    public function getPluginInfos(): array
    {
        $data = array_map(fn ($arr) => array_merge($arr, ['version' => $this->getPluginInstallVersion($arr['packageName'])]), [
            [
                'name' => 'Filament CMS Website Plugin',
                'packageName' => $this->getFilamentCmsPackageName(),
                'url' => $this->getFilamentCmsPluginLink(),
            ],
            [
                'name' => 'Tree',
                'packageName' => $this->getFilamentTreePackageName(),
                'url' => $this->getFilamentTreePluginLink(),
            ],
            [
                'name' => 'Simple Lightbox',
                'packageName' => 'solution-forest/filament-simplelightbox',
                'url' => 'https://github.com/solutionforest/Filament-SimpleLightBox',
            ],
            [
                'name' => 'Filament Tab Plugin',
                'packageName' => 'solution-forest/tab-layout-plugin',
                'url' => 'https://github.com/solutionforest/filament-tab-plugin',
            ]
        ]);

        if ($this->limit != null) {
            $data = array_values( array_filter($data, fn ($arr) => in_array(str($arr['packageName'])->afterLast('/'), $this->limit)) );
        }

        return ($data);
    }

    public function getFilamentCmsPluginDocLink()
    {
        return route('filament-cms.web.page', [
            'slug' => 'docs',
        ]);
    }

    public function getDemoGithubLink()
    {
        return "https://github.com/solutionforest/filament-cms-website-plugin-demo";
    }

    public function getPluginInstallVersion($packageName)
    {
        return InstalledVersions::getPrettyVersion($packageName);
    }

    private function getFilamentCmsPluginLink()
    {
        return 'https://filamentphp.com/plugins/solution-forest-cms-website';
    }

    private function getFilamentTreePluginLink()
    {
        return 'https://filamentphp.com/plugins/solution-forest-tree';
    }

    private function getFilamentCmsPackageName(): string
    {
        return 'solution-forest/filament-cms-website-plugin';
    }

    private function getFilamentTreePackageName(): string
    {
        return 'solution-forest/filament-tree';
    }
}
