<?php

namespace App\Console\Commands\Books;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SplitCommand extends Command
{
    protected $signature = 'books:split
        {book : Der Buch-Slug, z.B. play, multiplayer, worldbuilding}';

    protected $description = 'Split eine Markdown-Buchdatei in Kapitel-Dateien anhand von ## Überschriften.';

    public function handle(): int
    {
        $book = $this->argument('book');

        // Standardpfade (kannst du nach Bedarf anpassen)
        $sourcePath = base_path('resources/markdown/eudaimonica/' . $book . '.md');

        $targetDir = resource_path('markdown/eudaimonica/' . $book);

        if (!File::exists($sourcePath)) {
            $this->error('Source-Datei nicht gefunden: ' . $sourcePath);
            return Command::FAILURE;
        }

        $this->info('Lese Buch: ' . $sourcePath);
        $raw = File::get($sourcePath);

        // Optional: Frontmatter am Anfang herausziehen (--- ... ---)
        [$frontmatter, $content] = $this->extractFrontmatter($raw);

        // Erste Zeile '# Titel' ignorieren, falls vorhanden
        $lines = preg_split("/\\r\\n|\\r|\\n/", $content);
        if (isset($lines[0]) && preg_match('/^#\\s+.+$/', $lines[0])) {
            $lines = array_slice($lines, 1);
        }
        $working = implode("\n", $lines);

        // Kapitel anhand von "## " finden
        $chapters = $this->splitIntoChapters($working);

        if (empty($chapters)) {
            $this->error('Keine Kapitel gefunden. Nutzt du "## Überschrift" für Kapitel?');
            return Command::FAILURE;
        }

        // Zielverzeichnis vorbereiten
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        // Alte .md-Dateien im Ziel löschen
        foreach (File::files($targetDir) as $file) {
            if ($file->getExtension() === 'md') {
                File::delete($file->getPathname());
            }
        }

        // Kapitel schreiben
        foreach ($chapters as $chapterNumber => $chapter) {
            $title = $chapter['title'];
            $body = trim($chapter['content'] ?? '');
            $slug = Str::slug($title);
            $dirPath = $targetDir . DIRECTORY_SEPARATOR . sprintf('%02d-%s', $chapterNumber + 1, $slug);

            File::ensureDirectoryExists($dirPath);

            $this->line('Kapitel geschrieben: ' . $title);

            $sections = $this->splitChapterIntoSections($body);

            foreach ($sections as $sectionNumber => $section) {
                $sectionTitle = $section['title'];
                $sectionContent = trim($section['content'] ?? '');
                $sectionSlug = Str::slug($sectionTitle);
                $sectionFilename = sprintf('%02d-%s.md', $sectionNumber + 1, $sectionSlug);
                $sectionFilePath = $dirPath . DIRECTORY_SEPARATOR . $sectionFilename;

                $sectionFront = "---\n";
                $sectionFront .= "title: {$sectionTitle}\n";
                $sectionFront .= "---\n\n";

                $sectionFinal = $sectionFront
                    . "### {$sectionTitle}\n\n"
                    . $sectionContent . "\n";

                File::put($sectionFilePath, $sectionFinal);

                $this->line("\t" . '  Abschnitt geschrieben: ' . $sectionFilename);
            }
        }

        $this->info('Fertig. ' . count($chapters) . ' Kapitel erzeugt in ' . $targetDir);

        return Command::SUCCESS;
    }

    private function extractFrontmatter(string $raw): array
    {
        $raw = ltrim($raw);
        if (!str_starts_with($raw, '---')) {
            return ['', $raw];
        }

        // Suche das zweite '---'
        $pattern = "/^---\\s*\\n(.*?)\\n---\\s*\\n/s";
        if (preg_match($pattern, $raw, $matches)) {
            $frontmatter = $matches[0]; // inkl. --- Blöcke
            $content = substr($raw, strlen($frontmatter));
            return [$frontmatter, ltrim($content)];
        }

        return ['', $raw];
    }

    private function splitIntoChapters(string $text): array
    {
        $chapters = [];

        // Multiline-Regex, m-Flag wichtig
        $pattern = '/^##\\s+(.+?)\\s*$/m';
        if (!preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE)) {
            return [];
        }

        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $fullMatch = $matches[0][$i][0]; // "## Überschrift"
            $startPos = $matches[0][$i][1];  // Position im Text

            $title = trim($matches[1][$i][0]);

            // Start des Kapitelinhalts = Ende der Überschriftszeile
            $lineEndPos = strpos($text, "\n", $startPos);
            if ($lineEndPos === false) {
                $lineEndPos = strlen($text);
            }
            $contentStart = $lineEndPos + 1;

            // Ende = Start der nächsten Überschrift oder Textende
            if ($i + 1 < $count) {
                $nextStartPos = $matches[0][$i + 1][1];
                $content = substr($text, $contentStart, $nextStartPos - $contentStart);
            } else {
                $content = substr($text, $contentStart);
            }

            $chapters[] = [
                'title'   => $title,
                'content' => rtrim($content),
            ];
        }

        return $chapters;
    }

    private function splitChapterIntoSections(string $chapter): array
    {
        $sections = [];

        $pattern = '/^###\\s+(.+?)\\s*$/m';
        if (!preg_match_all($pattern, $chapter, $matches, PREG_OFFSET_CAPTURE)) {
            return [];
        }

        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $fullMatch = $matches[0][$i][0]; // "## Überschrift"
            $startPos = $matches[0][$i][1];  // Position im Text

            $title = trim($matches[1][$i][0]);

            // Start des Kapitelinhalts = Ende der Überschriftszeile
            $lineEndPos = strpos($chapter, "\n", $startPos);
            if ($lineEndPos === false) {
                $lineEndPos = strlen($chapter);
            }
            $contentStart = $lineEndPos + 1;

            // Ende = Start der nächsten Überschrift oder Textende
            if ($i + 1 < $count) {
                $nextStartPos = $matches[0][$i + 1][1];
                $content = substr($chapter, $contentStart, $nextStartPos - $contentStart);
            } else {
                $content = substr($chapter, $contentStart);
            }

            $sections[] = [
                'title'   => $title,
                'content' => rtrim($content),
            ];
        }

        return $sections;
    }
}