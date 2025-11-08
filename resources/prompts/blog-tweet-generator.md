# Blog Tweet Generator Prompt

## Metadata
- **Version**: 1.0
- **Erstellt**: 2025-11-08
- **Zweck**: Generierung diskussionsfreundlicher Blog-Tweets für Community-Building
- **Output**: JSON-Datei mit 3-7 interaktiven Tweets pro Blogartikel
- **Verwendung**: Mit GitHub Copilot oder anderen AI-Assistenten

## Prompt

Du erstellst Tweets, die Menschen zum Nachdenken, Diskutieren und Teilen ihrer eigenen Erfahrungen einladen. Deine Aufgabe ist es, aus Blogartikeln bis zu 7 hochwertige Tweets zu generieren, die subtil zu Gesprächen und Interaktionen anregen. Das Ziel ist es, echte Verbindungen zu schaffen und Feedback zu den präsentierten Ideen zu erhalten - ohne dies explizit zu verlangen.

**Wichtige Vorgaben:**

1.  **Interaktions-Fokus:** Erstelle 3-7 Tweets, die subtil zu Diskussionen einladen. Nutze offene Aussagen, persönliche Erkenntnisse und nachdenkliche Beobachtungen, die andere zum Teilen ihrer Perspektiven motivieren.
2.  **Authentische Vulnerabilität:** Zeige menschliche Seiten - Zweifel, Erkenntnisprozesse, Fragen. Menschen verbinden sich mit Ehrlichkeit, nicht mit Perfektion.
3.  **Diskussionsstarke Formulierungen:**
   - Verwende "Ich habe bemerkt..." statt "Man sollte..."
   - Stelle subtile Gedankenanstöße: "Mir fällt auf, dass..."
   - Teile persönliche Erkenntnisse: "Für mich hat sich gezeigt..."
   - Nutze nachdenkliche Beobachtungen: "Interessant ist..."
4.  **Zeichenlimit:** Jeder Tweet muss unter 280 Zeichen bleiben.
5.  **Zeitplan:** Verwende einen intelligenten Hybrid-Ansatz basierend auf der Tweet-Anzahl:
    - **Bei 3 Tweets**: Aufeinanderfolgend (Tag 0, 1, 2) für konsistente Präsenz
    - **Bei 4-5 Tweets**: Über 5 Tage verteilt (Tag 0, 1, 2, 3, 4)
    - **Bei 6-7 Tweets**: Über die ganze Woche verteilt (Tag 0, 1, 2, 3, 4, 5, 6)

    Dies maximiert sowohl Konsistenz als auch Reichweite ohne große Lücken.

**ANFORDERUNGEN:**
- **Format**: JSON-Array mit Objekten containing "date" (YYYY-MM-DD) und "message" keys
- **Interaktions-Design**:
  - Verwende persönliche Formulierungen ("Mir ist aufgefallen...", "Ich frage mich...")
  - Teile unvollständige Gedanken oder offene Fragen
  - Zeige Unsicherheiten oder Erkenntnisprozesse
  - Nutze nachdenkliche statt belehrende Töne
  - Sparsam Emojis verwenden (maximal 1-2 pro Tweet)
  - Relevante, aber nicht übertriebene Hashtags (2-3 maximum)
- **Inhalt-Strategie**:
  - Verschiedene Blickwinkel und Zweifel einbauen
  - Persönliche Erkenntnisse authentisch teilen
  - Raum für andere Meinungen und Erfahrungen lassen
  - Subtile Einladungen zum Nachdenken einbauen

**VORGEHEN:**
1. Analysiere den Blogartikel gründlich und identifiziere alle wesentlichen Ideen und Konzepte
2. Bewerte die Texttiefe: Reicht der Inhalt für 3, 4, 5, 6 oder 7 einzigartige Tweets?
3. Erstelle für jede wesentliche Idee einen eigenständigen, wertvollen Tweet
4. Sorge für thematische Diversität - verschiedene Blickwinkel und Aspekte abdecken
5. Wähle den passenden Zeitplan basierend auf der Tweet-Anzahl:
   - 3 Tweets: Tag 0, 1, 2
   - 4-5 Tweets: Tag 0, 1, 2, 3, 4
   - 6-7 Tweets: Tag 0, 1, 2, 3, 4, 5, 6
6. Formatiere als JSON-Array
7. Speichere die Datei als `[ARTIKELNAME].json` im Verzeichnis `resources/tweets/posts/`

**BEISPIEL-OUTPUT (5 diskussionsfreundliche Tweets):**
```json
[
  {
    "date": "2025-11-16",
    "message": "Mir ist aufgefallen, dass [persönliche Beobachtung aus dem Artikel]. Manchmal frage ich mich, ob andere das ähnlich erleben... #Gedanken #Reflexion"
  },
  {
    "date": "2025-11-17",
    "message": "Ich habe lange geglaubt [frühere Annahme], bis mir klar wurde [neue Erkenntnis]. Interessant, wie sich Perspektiven wandeln können. #Erkenntnisse"
  },
  {
    "date": "2025-11-18",
    "message": "Eine Sache beschäftigt mich: [nachdenkliche Beobachtung]. Vielleicht bin ich da zu kritisch, aber [authentischer Zweifel]... #Nachdenken"
  },
  {
    "date": "2025-11-19",
    "message": "Was mich überrascht hat: [überraschende Einsicht]. Hätte nicht gedacht, dass [ehrliche Verwunderung]. #Überraschung #Lernen"
  },
  {
    "date": "2025-11-20",
    "message": "Für mich hat sich gezeigt: [persönliche Erkenntnis]. Bin gespannt, ob das für andere auch zutrifft. #Erfahrung #Austausch"
  }
]
```

## Verwendung

1. Kopiere diesen Prompt
2. Füge ihn in eine neue Conversation mit GitHub Copilot ein
3. Füge den Blogartikel-Text hinzu
4. Die AI analysiert den Inhalt und erstellt automatisch 3-7 Tweets je nach Texttiefe

## Qualitätssicherung

Nach der Generierung prüfen:
- [ ] 3-7 diskussionsfreundliche Tweets (Qualität vor Quantität)
- [ ] Alle Daten im korrekten Format (YYYY-MM-DD)
- [ ] Tweets verwenden persönliche, authentische Formulierungen
- [ ] Verschiedene Grade von Vulnerabilität und Offenheit
- [ ] Jeder Tweet lädt subtil zu Gedankenaustausch ein
- [ ] Keine belehrenden oder verkündenden Töne
- [ ] Sparsame Emoji-Verwendung (max. 1-2 pro Tweet)
- [ ] Alle Tweets unter 280 Zeichen
- [ ] JSON-Syntax ist korrekt
- [ ] Datei ist im richtigen Verzeichnis gespeichert
- [ ] Tweets folgen intelligentem Zeitplan für maximale Interaktion