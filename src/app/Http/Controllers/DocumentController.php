<?php

namespace App\Http\Controllers;

use Throwable;
use GuzzleHttp\Client;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use Illuminate\View\View;
use Illuminate\Http\Request;
use SolutionForest\FilamentCms\SEO\Support\SEOData;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     *
     * @return View
     */
    public function index()
    {
        $data = $this->getDefaultViewData();
        $data['layout']['data']['seo'] = $this->buildSeo();
        return view('documents.index', [
            ...$data,
            'breadcrumbs' => $this->getBreadcrumbs(),
            'childs' => collect($this->getAvailabelPlugins())->mapWithKeys(fn ($key) => [
                $key => [
                    'title' => $this->getPageTitle($key),
                    'url' => route('docs.show', ['document' => $key]),
                ]
            ])->all(),
        ]);
    }

    /**
     * Display the specified document.
     */
    public function show($document, $version = null)
    {
        try {
            $versions = $this->getVersionSelection($document);
            
            // Get latest version if no version is specified
            if (empty($version)) {
                $version = collect($versions)->keys()->sortDesc()->first();
            }

            $data = $this->getDefaultViewData();
            $data['layout']['data']['seo'] = $this->buildSeo($document, $version);
            return view('documents.show', [
                ... $data,
                'breadcrumbs' => $this->getBreadcrumbs($document),
                'document' => $document,
                'version' => $version,
                'versions' => $versions,
            ]);
        } catch (Throwable $th) {
            abort(404);
        }
    }

    public function getMarkdown(Request $request)
    {
        $document = $request->input('document');
        $version = $request->input('version', 'latest');

        $markdownContent = null;
        $skipGithub = $request->input('skip_github', false) || $document === 'filament-cms-website-plugin';

        try {
            // Getting from github repository
            $client = new Client();
            $response = $client->get("https://raw.githubusercontent.com/solutionforest/{$document}/{$version}/README.md");
            if ($response->getStatusCode() === 200) {
                $markdownContent = $response->getBody()->getContents();
                return response()->json(['content' => $this->renderMarkdownToHtml($markdownContent)]);
            } 
        } catch (Throwable $th) {
            //
        }

        try {
            // Searching from local filesystem
            if (is_null($markdownContent)) {
                $markdownFile = resource_path("docs/{$document}/{$version}/README.md");
                if (!file_exists($markdownFile)) {
                    return response()->json(['error' => 'Document not found'], 404);
                }
                $markdownContent = file_get_contents($markdownFile);
                if ($markdownContent === false) {
                    return response()->json(['error' => 'Failed to read document'], 500);
                }
                return response()->json(['content' => $this->renderMarkdownToHtml($markdownContent)]);
            }   
        } catch (Throwable $th) {
            dd($th);
            return response()->json(['error' => 'An error occurred'], 500);
        }
        return response()->json(['error' => 'Document not found'], 404);
    }

    protected function generateViewNameFromCms($view)
    {
        return "cms.theme.{$this->getCmsTheme()}.components.templates.content_type.{$view}";
    }

    protected function getCmsTheme()
    {
        return config('filament-cms.theme', 'default');
    }

    protected function getCmsLayout()
    {
        return config('filament-cms.default_layout', 'app');
    }

    protected function getDefaultViewData()
    {
        return [];
    }

    protected function buildSeo(?string $slug = null, $version = null)
    {
        $pageTitle = $this->getPageTitle($slug);
        if (filled($version)) {
            $pageTitle .= " - {$version}";
        }
        if (filled($slug)) {
            $pageTitle .= " - Documentation";
        }
        return new SEOData(
            title: $pageTitle,
            description: empty($slug) ? 'A list of documents available on the site.' : "A document for {$slug}.",
            url: empty($slug) ?  route('docs.index') : route('docs.show', ['document' => $slug]),
            type: 'website',
            site_name: config('app.name'),
            locale: app()->getLocale(),
        );
    }

    protected function getBreadcrumbs(?string $slug = null)
    {
        $result = [
            [
                'label' => 'Documents',
                'url' => route('docs.index'),
            ],
        ];
        if ($slug) {
            $result[] = [
                'label' => $this->getPageTitle($slug),
                'url' => route('docs.show', ['document' => $slug]),
            ];
        }
        return $result;
    }

    protected function getPageTitle(?string $slug = null)
    {
        if (empty($slug)) {
            return 'Documentation';
        }

        return match ($slug) {
            'filament-cms-website-plugin' => 'Filament CMS',
            'filament-tree' => 'Filament Tree',
            default => "Document: {$slug}",
        };
    }

    protected function getVersionSelection($document)
    {
        $versions = match ($document) {
            'filament-cms-website-plugin' => ['2.x', '3.x'],
            'filament-tree' => ['2.x', '3.x'],
            default => [],
        };
        return collect($versions)->mapWithKeys(fn ($version) => [
            $version => [
                'title' => $version,
                'url' => route('docs.show', ['document' => $document, 'version' => $version]),
            ]
        ])->all();
    }

    protected function getAvailabelPlugins()
    {
        return [
            'filament-cms-website-plugin',
            'filament-tree',
        ];
    }

    protected function renderMarkdownToHtml(string $markdownContent)
    {
        $config = [
            // // TableOfContentsExtension
            // 'table_of_contents' => [
            //     'html_class' => 'table-of-contents',
            //     'position' => 'top',
            //     'style' => 'bullet',
            //     'min_heading_level' => 1,
            //     'max_heading_level' => 5,
            // ],
            // // TableExtension
            // 'table' => [
            //     'wrap' => [
            //         'enabled' => true,
            //         'tag' => 'div',
            //     ],
            // ],
            
            // 'heading_permalink' => [
            //     'html_class' => 'heading-permalink',
            //     'id_prefix' => 'content',
            //     'fragment_prefix' => 'content',
            //     'insert' => 'before',
            //     'min_heading_level' => 1,
            //     'max_heading_level' => 6,
            //     'title' => 'Permalink',
            //     'symbol' => '#', // HeadingPermalinkRenderer::DEFAULT_SYMBOL,
            //     'aria_hidden' => true,
            // ],
        ];

        $extensions = [
            
            // new AttributesExtension(),
            // new DefaultAttributesExtension(),
            // new AutolinkExtension(),
            // new DisallowedRawHtmlExtension(),
            // new StrikethroughExtension(),
            // new TableExtension(),
            // new TaskListExtension(),
            // new HeadingPermalinkExtension(),
            // new TableOfContentsExtension(),
        ];

        $converted = str($markdownContent)->markdown($config, $extensions);//->toHtmlString();

        return (string) $converted->toHtmlString();
    }
}
