# Tweet Generator Prompt

## Metadata
- **Version**: 1.0
- **Erstellt**: 2025-11-03
- **Zweck**: Generierung von täglichen inspirierenden Tweets aus philosophischen Texten
- **Output**: JSON-Datei mit 365 Tweets
- **Verwendung**: Mit GitHub Copilot oder anderen AI-Assistenten

## Prompt

Du bist ein Experte für die Erstellung inspirierender täglicher Tweets basierend auf philosophischen Texten.

**SCHRITT 1: Jahr erfragen**
Frage mich zuerst: "Für welches Jahr sollen die Tweets erstellt werden?"

**AUFGABE:**
Erstelle aus der bereitgestellten Textdatei Tweets für jeden Tag des angegebenen Jahres. Die Tweets sollen an die Philosophie erinnern, motivieren, inspirieren und zum Handeln einladen.

**ANFORDERUNGEN:**
1. **Anzahl**: 365 Tweets (366 bei Schaltjahren) - einen für jeden Tag des Jahres
2. **Format**: JSON-Array mit Objekten containing "date" (YYYY-MM-DD) und "message" keys
3. **Reihenfolge**: Tweets sollen in ZUFÄLLIGER Reihenfolge basierend auf dem Textinhalt erstellt werden, NICHT in der Reihenfolge des ursprünglichen Textes
4. **Stil**:
   - Inspirierend und motivierend
   - Konkrete Handlungsaufforderungen oder Reflexionsfragen
   - Passende Emojis verwenden
   - Relevante Hashtags am Ende
   - Maximal 280 Zeichen pro Tweet
5. **Inhalt**:
   - Alle wichtigen Konzepte und Ideen aus dem Text abdecken
   - Verschiedene Aspekte der Philosophie gleichmäßig verteilen
   - Praktische Anwendungen und Lebensweisheiten einbauen
   - Sowohl tiefe philosophische Gedanken als auch alltägliche Umsetzungstipps

**VORGEHEN:**
1. Analysiere den gesamten Text und identifiziere alle wichtigen Konzepte, Prinzipien und Ideen
2. Erstelle 365 einzigartige Tweets, die verschiedene Aspekte abdecken
3. Mische die Tweets so, dass sie NICHT der ursprünglichen Textreihenfolge folgen
4. Weise jedem Tweet ein Datum im angegebenen Jahr zu (beginnend mit 1. Januar)
5. Formatiere als JSON-Array
6. Speichere die Datei als `[JAHR].json` im Verzeichnis `resources/daylies/`

**BEISPIEL-OUTPUT:**
```json
[
  {
    "date": "2026-01-01",
    "message": "🎯 [Inspirierender Tweet mit Handlungsaufforderung] #Hashtag1 #Hashtag2"
  },
  {
    "date": "2026-01-02",
    "message": "💪 [Weiterer motivierender Tweet] #Hashtag3 #Hashtag4"
  }
  // ... fortsetzung für alle 365 Tage
]
```

## Verwendung

1. Kopiere diesen Prompt
2. Füge ihn in eine neue Conversation mit GitHub Copilot ein
3. Antworte auf die Jahresfrage
4. Füge den Quelltext (z.B. aus `play.md`) hinzu
5. Die AI erstellt automatisch die JSON-Datei mit 365 zufällig angeordneten Tweets

## Beispiele für Quelltexte

- `resources/markdown/eudaimonica/play.md` - Individuelle Lebensphilosophie
- `resources/markdown/eudaimonica/worldbuilding.md` - Gesellschaftsphilosophie
- `resources/markdown/eudaimonica/philosophy.md` - Grundlagen der Philosophie
- Kombinationen mehrerer Dateien für umfassendere Tweet-Sammlungen

## Qualitätssicherung

Nach der Generierung prüfen:
- [ ] Genau 365 Tweets (366 bei Schaltjahren)
- [ ] Alle Daten im korrekten Format (YYYY-MM-DD)
- [ ] Tweets sind thematisch durchmischt (nicht chronologisch zum Quelltext)
- [ ] Verschiedene Aspekte der Philosophie sind abgedeckt
- [ ] JSON-Syntax ist korrekt
- [ ] Datei ist im richtigen Verzeichnis gespeichert