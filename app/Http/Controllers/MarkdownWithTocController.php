<?php

namespace App\Http\Controllers;

use League\CommonMark\Node\Query;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Renderer\HtmlRenderer;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;

class MarkdownWithTocController extends Controller
{
    protected $markdown_path = '';

    public function index()
    {
        $markdown = file_get_contents(resource_path($this->markdown_path));
        $first_line = preg_split('#\r?\n#', $markdown, 0)[0];
        $title = trim(str_replace('# ', '', $first_line));
        $markdown_without_title = trim(substr($markdown, strpos($markdown, "\n") + 1));

        $environment = $this->getEnvironment();

        $converter = new MarkdownConverter($environment);

        $converted = $converter->convert($markdown_without_title);

        $document = $converted->getDocument();

        $toc = (new Query())
            ->where(Query::type(TableOfContents::class))
            ->findOne($document);

        $toc->detach();

        $renderer = new HtmlRenderer($environment);
        $content = $renderer->renderDocument($document);
        $toc = $renderer->renderNodes([$toc]);

        return view('markdown-with-toc.index')
            ->with('title', $title)
            ->with('content', $content)
            ->with('toc', $toc);
    }

    public function show(string $section)
    {
        $markdown_path = 'markdown/eudaimonica/' . $section . '.md';

        abort_if(!file_exists(resource_path($markdown_path)), 404);

        $markdown = file_get_contents(resource_path($markdown_path));
        $first_line = preg_split('#\r?\n#', $markdown, 0)[0];
        $title = trim(str_replace('# ', '', $first_line));
        $markdown_without_title = trim(substr($markdown, strpos($markdown, "\n") + 1));

        $environment = $this->getEnvironment();

        $converter = new MarkdownConverter($environment);

        $converted = $converter->convert($markdown_without_title);

        $document = $converted->getDocument();

        $toc = (new Query())
            ->where(Query::type(TableOfContents::class))
            ->findOne($document);

        $toc->detach();

        $renderer = new HtmlRenderer($environment);
        $content = $renderer->renderDocument($document);
        $toc = $renderer->renderNodes([$toc]);

        return view('markdown-with-toc.index')
            ->with('title', $title)
            ->with('content', $content)
            ->with('toc', $toc);
    }

    private function getEnvironment(): Environment
    {
        $config = [
            'allow_unsafe_links' => false,
            'table_of_contents' => [
                'html_class' => 'table-of-contents',
                'position' => 'top',
                'style' => 'bullet',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'normalize' => 'relative',
                'placeholder' => null,
            ],
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'apply_id_to_heading' => false,
                'heading_class' => '',
                'fragment_prefix' => 'content',
                'insert' => 'after',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => HeadingPermalinkRenderer::DEFAULT_SYMBOL,
                'aria_hidden' => true,
            ],
        ];

        $environment = new Environment($config);

        $environment->addExtension(new CommonMarkCoreExtension());

        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new DisallowedRawHtmlExtension());
        $environment->addExtension(new StrikethroughExtension());
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new TaskListExtension());

        // Version > 1.4 needed
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());
        $environment->addExtension(new MentionExtension());
        $environment->addExtension(new FootnoteExtension());

        return $environment;
    }
}
