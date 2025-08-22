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

    public static string $docLink = 'https://solutionforest.github.io/plugins-doc-site';

    public function getPluginInfos(): array
    {
        $data = array_map(fn ($arr) => array_merge($arr, ['version' => $this->getPluginInstallVersion($arr['packageName'])]), [
            [
                'name' => 'Filament CMS Website Plugin',
                'packageName' => 'solution-forest/filament-cms-website-plugin',
                'url' => static::getFilamentPluginUrl('solution-forest-cms-website'),
            ],
            [
                'name' => 'Tree',
                'packageName' => 'solution-forest/filament-tree',
                'url' => static::getFilamentPluginUrl('solution-forest-tree'),
            ],
            [
                'name' => 'Simple Lightbox',
                'packageName' => 'solution-forest/filament-simplelightbox',
                'url' => static::getFilamentPluginUrl('solution-forest-simplelightbox'),
            ],
            [
                'name' => 'Filament Tab Plugin',
                'packageName' => 'solution-forest/tab-layout-plugin',
                'url' => static::getFilamentPluginUrl('solution-forest-tab-layout-plugin'),
            ],
            [
                'name' => 'Simple Contact Form Plugin',
                'packageName' => 'solution-forest/simple-contact-form',
                'url' => static::getFilamentPluginUrl('solution-forest-simple-contact-form'),
            ]
        ]);

        if ($this->limit != null) {
            $data = array_values( array_filter($data, fn ($arr) => in_array(str($arr['packageName'])->afterLast('/'), $this->limit)) );
        }

        return ($data);
    }

    public function getDocLink()
    {
        return static::$docLink;
    }

    public function getDemoGithubLink()
    {
        return "https://github.com/solutionforest/filament-cms-website-plugin-demo";
    }

    public function getPluginInstallVersion($packageName)
    {
        return InstalledVersions::getPrettyVersion($packageName);
    }

    private static function getFilamentPluginUrl($slug)
    {
        return "https://filamentphp.com/plugins/{$slug}";
    }
}
