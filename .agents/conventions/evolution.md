# Evolution von d15r

## Grundsatz

D15r soll konsistent bleiben, ohne statisch zu werden. Jeder Arbeitszyklus kann
deshalb neben seinem Ergebnis auch Daten für die Weiterentwicklung von
Webseite, ICM und Arbeitsweise erzeugen.

```text
Variation → Erfahrung → Selektion → Weitergabe
```

Eine Änderung ist zunächst eine Variation. Nutzung, visuelle Prüfung, Tests und
Userfeedback erzeugen Erfahrung. Erst danach wird entschieden, was beibehalten,
angepasst oder verworfen und als dauerhaftes Wissen weitergegeben wird.

## Arten von Aussagen

Vor einer Aufnahme ins ICM wird unterschieden:

- **Beobachtung:** direkt feststellbare Daten oder ausdrückliches Feedback,
- **Interpretation:** eine begründete Einordnung der Beobachtung,
- **Hypothese:** eine noch zu prüfende erwartete Wirkung,
- **bestätigtes Wissen:** durch Auftrag, wiederholte Erfahrung oder eindeutige
  fachliche Klärung belastbar gewordene Aussage.

Eine einmalige Reaktion wird nicht vorschnell zur allgemeinen Regel. Explizite
Vorgaben des Users gelten dagegen unmittelbar als bestätigte Anforderungen.

## Ablauf nach einem Zyklus

Die aktive Rolle:

1. prüft zuerst die Wirkung eines bereits laufenden Experiments,
2. hält konkrete Beobachtungen des aktuellen Zyklus fest,
3. trennt Daten von Interpretation und Vermutung,
4. entscheidet, ob Konventionen oder Experimente beibehalten, angepasst oder
   verworfen werden,
5. entfernt Regeln, Hilfsmittel oder Kontext, wenn sie keinen erkennbaren
   Nutzen mehr haben,
6. formuliert bei Bedarf genau ein kleines neues Experiment mit erwarteter
   Wirkung,
7. verändert nur den eigenen Rollenprozess oder den global zuständigen
   Kontext,
8. hält nur eine relevante neue Erfahrung gegenstandsbezogen fest.

Es muss nicht nach jedem Zyklus eine Regel geändert, ein Experiment begonnen
oder eine Lerndatei angelegt werden. Ist nichts Relevantes neu, endet die
Auswertung ohne Dokumentation.

## Lerndateien

Erfahrungen werden nicht an ein fortlaufendes `lernen.md` angehängt. Für einen
Artikel oder anderen klar benannten Arbeitsgegenstand entsteht bei Bedarf im
Rollenverzeichnis genau eine Datei unter
`lernen/YYYY-MM-DD-<gegenstand>.md`. Mehrere Durchgänge am selben Gegenstand
aktualisieren diese Datei.

Die Datei enthält nur das gegenüber dem bereits bekannten ICM relevante Neue:

```markdown
# Gegenstand

## Neue Beobachtung

## Selektion

Beibehalten | Anpassen | Verwerfen

## Konsequenz

Keine | bestehendes Wissen präzisiert | neues Experiment
```

Rollenspezifische Erfahrung bleibt bei der Rolle. Rollenübergreifendes
technisches, gestalterisches oder fachliches Wissen wird stattdessen unter
`conventions/` beziehungsweise `domains/` konsolidiert.

Konsolidieren bedeutet, bestehende Aussagen zu präzisieren, zu ersetzen oder
zu entfernen, nicht das ICM chronologisch zu erweitern. Die gegenstandsbezogene
Lerndatei bleibt als Herkunft erhalten und wird nicht standardmäßig geladen.
Bestehende `lernen.md` sind historische Archive und werden nicht erweitert.

## Wachstum durch Teilung

Kontext beginnt in der kleinsten zuständigen Einheit. Einzelne Erfahrungen
werden von Beginn an gegenstandsbezogen abgelegt; kanonisches Wissen bleibt
kompakt und wird in seiner zuständigen Datei konsolidiert.

Das ICM wächst damit wie ein Verbund von Zellen: durch kleine Einheiten mit
klarer Verantwortung, nicht durch immer größere Zentraldateien.
