<?php

namespace App\Console\Commands\Books;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SplitBookCommand extends Command
{
    protected $signature = 'book:split
        {book : Der Buch-Slug, z.B. play, multiplayer, worldbuilding}
        {--source= : Pfad zur Source-Markdown-Datei}
        {--target= : Zielverzeichnis für die Kapiteldateien}';

    protected $description = 'Split eine Markdown-Buchdatei in Kapitel-Dateien anhand von ## Überschriften.';

    public function handle(): int
    {
        $book = $this->argument('book');

        // Standardpfade (kannst du nach Bedarf anpassen)
        $sourcePath = $this->option('source')
            ?: base_path("books/{$book}.md");

        $targetDir = $this->option('target')
            ?: resource_path("markdown/{$book}");

        if (!File::exists($sourcePath)) {
            $this->error("Source-Datei nicht gefunden: {$sourcePath}");
            return Command::FAILURE;
        }

        $this->info("Lese Buch: {$sourcePath}");
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
        foreach ($chapters as $index => $chapter) {
            $title = $chapter['title'];
            $body = trim($chapter['content'] ?? '');

            $slug = Str::slug($title);
            $filename = sprintf('%02d-%s.md', $index + 1, $slug);
            $filePath = $targetDir . DIRECTORY_SEPARATOR . $filename;

            $front = "---\n";
            $front .= "title: {$title}\n";
            $front .= "---\n\n";

            $final = $front
                . "## {$title}\n\n"
                . $body . "\n";

            File::put($filePath, $final);

            $this->info("✅ Kapitel geschrieben: {$filename}");
        }

        $this->info("Fertig. " . count($chapters) . " Kapitel erzeugt in {$targetDir}");

        return Command::SUCCESS;
    }

    /**
     * Frontmatter (--- ... ---) extrahieren, falls vorhanden.
     *
     * @return array{0:string,1:string} [frontmatter, contentOhneFrontmatter]
     */
    protected function extractFrontmatter(string $raw): array
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

    /**
     * Splittet den Inhalt anhand von "## Überschriften" in Kapitel.
     *
     * @return array<int,array{title:string,content:string}>
     */
    protected function splitIntoChapters(string $text): array
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
}