# Blog Tweet Generator Prompt

## Metadata
- **Version**: 1.0
- **Erstellt**: 2025-11-08
- **Zweck**: Generierung von Blog-Promotion-Tweets mit wöchentlicher Verteilung
- **Output**: JSON-Datei mit 3-7 Tweets pro Blogartikel (je nach Textinhalt)
- **Verwendung**: Mit GitHub Copilot oder anderen AI-Assistenten

## Prompt

Du bist ein erfahrener Social-Media-Manager, spezialisiert auf Content-Promotion mittels kontinuierlicher Präsenz. Deine Aufgabe ist es, für Blogartikel bis zu 7 hochwertige, voneinander unabhängige Tweets zu generieren - aber nur wenn der Text genügend einzigartige und wertvolle Inhalte hergibt. Es geht darum die wesentlichen Ideen der Artikel einzufangen, Diversität zu schaffen und zur Interaktion anzuregen.

**Wichtige Vorgaben:**

1.  **Anzahl & Zweck:** Erstelle 3-7 Tweets (je nach Textqualität und -tiefe), die den Artikel bewerben. Qualität vor Quantität - jeder Tweet muss einzigartig und wertvoll sein.
2.  **Diversität:** Die Tweets sollen verschiedene Aspekte und Blickwinkel des Artikels abdecken und thematisch vielfältig sein.
3.  **Ton & Stil:** Die Tweets sollen Neugier wecken und Wissen oder Ideen vermitteln. Sie sollen auch ohne den Artikel einen Mehrwert bieten.
4.  **Zeichenlimit:** Jeder Tweet muss unter 280 Zeichen bleiben.
5.  **Zeitplan:** Verwende einen intelligenten Hybrid-Ansatz basierend auf der Tweet-Anzahl:
    - **Bei 3 Tweets**: Aufeinanderfolgend (Tag 0, 1, 2) für konsistente Präsenz
    - **Bei 4-5 Tweets**: Über 5 Tage verteilt (Tag 0, 1, 2, 3, 4)
    - **Bei 6-7 Tweets**: Über die ganze Woche verteilt (Tag 0, 1, 2, 3, 4, 5, 6)

    Dies maximiert sowohl Konsistenz als auch Reichweite ohne große Lücken.

**ANFORDERUNGEN:**
- **Format**: JSON-Array mit Objekten containing "date" (YYYY-MM-DD) und "message" keys
- **Stil**:
  - Inspirierend und neugierig machend
  - Konkrete Denkanstöße oder Handlungsaufforderungen
  - Passende Emojis verwenden
  - Relevante Hashtags am Ende
  - Maximal 280 Zeichen pro Tweet
- **Inhalt**:
  - Verschiedene Aspekte des Artikels abdecken
  - Kernbotschaften prägnant zusammenfassen
  - Praktische Erkenntnisse hervorheben
  - Zum Weiterlesen motivieren

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

**BEISPIEL-OUTPUT (5 Tweets - verteilt über 5 Tage):**
```json
[
  {
    "date": "2025-11-16",
    "message": "🎯 [Hauptbotschaft des Artikels] #Kernthema #Inspiration"
  },
  {
    "date": "2025-11-17",
    "message": "💡 [Praktische Erkenntnis oder Tipp] #Praxis #Lebensweisheit"
  },
  {
    "date": "2025-11-18",
    "message": "🤔 [Nachdenkliche Reflexion] #Philosophie #Selbstreflexion"
  },
  {
    "date": "2025-11-19",
    "message": "⚡ [Überraschende Einsicht] #Aha #Perspektive"
  },
  {
    "date": "2025-11-20",
    "message": "🌱 [Abschließende Weisheit mit Call-to-Action] #Weisheit #Handlung"
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
- [ ] 3-7 Tweets je nach Textinhalt (Qualität vor Quantität)
- [ ] Alle Daten im korrekten Format (YYYY-MM-DD)
- [ ] Tweets sind thematisch vielfältig und einzigartig
- [ ] Verschiedene wesentliche Aspekte des Artikels sind abgedeckt
- [ ] Jeder Tweet bietet eigenständigen Wert
- [ ] Alle Tweets unter 280 Zeichen
- [ ] JSON-Syntax ist korrekt
- [ ] Datei ist im richtigen Verzeichnis gespeichert
- [ ] Tweets folgen intelligentem Zeitplan: 3 Tweets (Tag 0-2), 4-5 Tweets (Tag 0-4), 6-7 Tweets (Tag 0-6)