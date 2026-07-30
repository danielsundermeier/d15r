# Gestaltung von d15r

Diese Datei beschreibt die bestätigte gestalterische Ausgangslage. Sie ist ein
lebender Standard und wird anhand realer Nutzung weiterentwickelt.

## Ausdruck

D15r wirkt wie ein ruhiges philosophisches Journal und Forschungsnotizbuch.
Die Gestaltung unterstützt Nachdenken, Lesen und Orientierung. Sie inszeniert
weder eine fertige Lehre noch ein technisches KI-Produkt.

Die Seite soll vermitteln:

- Hier entwickelt sich eine lebende Philosophie.
- Der aktuelle Stand ist ernst gemeint, aber nicht endgültig.
- Inhalte besitzen Vorrang vor dekorativen Effekten.
- Ruhe entsteht durch klare Hierarchie, Lesebreite und großzügigen Raum.

## Technische Grundlage

- Tailwind CSS wird mit seinen Standardwerten für Farben, Abstände,
  Typografie und Breakpoints verwendet.
- Die im Projekt installierte Tailwind-Version ist maßgeblich. Nicht verfügbare
  Klassen werden nicht vorausgesetzt.
- Eigene Design-Tokens, zusätzliche Schriftarten und neue UI-Bibliotheken
  werden nur bei einem bestätigten Bedarf eingeführt.
- Light und Dark Mode sind gleichwertige Darstellungen. Eine sichtbare
  Änderung wird in beiden Modi geprüft.
- Die manuell gewählte Darstellung bleibt über Seitenwechsel erhalten.

## Aktuelle visuelle Sprache

- `stone` bildet ruhige helle Flächen.
- `slate` trägt Text, Linien und dunkle Flächen.
- `sky` markiert Links, Orientierung und Klarheit.
- `amber` kennzeichnet sparsam Experimente, Entwicklung und lebendige
  Aufmerksamkeit.
- Große Überschriften verwenden eine enge Laufweite und eine klare
  Gewichtung.
- Fließtext bleibt in einer begrenzten Lesespalte.
- Linien, Flächenwechsel und Weißraum strukturieren stärker als Schatten.
- Karten werden nur eingesetzt, wenn sie echte Einheiten oder Zugänge
  abgrenzen.

## Globale Struktur

- Header und Footer bilden auf allen öffentlichen Seiten denselben Rahmen.
- Die Hauptnavigation unterscheidet Philosophie, Eudaimonica, Journal,
  Experiment und Zusammenarbeit.
- Ein allgemeiner Verkaufs- oder Kontakt-CTA wird nicht nach jedem Inhalt
  wiederholt.
- Kontakt erscheint dort, wo eine Zusammenarbeit oder Anfrage inhaltlich
  sinnvoll ist.
- Der Footer beschreibt d15r als lebendes Experiment und führt zu
  ergänzenden sowie rechtlichen Seiten.

## Seitentypen

### Startseite

Die Startseite erklärt den Kern in einem starken ersten Blick, zeigt die
Aufwärtsspirale, bietet wenige verständliche Zugänge und kuratiert aktuelle
Gedanken. Sie ist keine vollständige Inhaltsablage.

### Journal

Das Journal hebt den aktuellsten Gedanken hervor und stellt ältere Texte als
ruhiges Archiv dar. Datum und Lesezeit unterstützen Orientierung, ohne den
Inhalt zu dominieren.

### Essay

Essays besitzen einen großzügigen Titelbereich, eine schmale Lesespalte und
eine zurückhaltende Navigation zum vorherigen und nächsten Gedanken.

### Langform

Philosophie und Eudaimonica sind lebende Dokumente. Auf großen Bildschirmen
hilft eine Inhaltsnavigation; auf kleinen Bildschirmen bleibt die
Textdarstellung vorrangig.

### Experiment

Die Seite über KI beschreibt ein offenes persönliches Experiment. Sie erhält
keine futuristische oder werbliche KI-Ästhetik.

### Kontakt und Rechtliches

Formulare und rechtliche Angaben verwenden denselben visuellen Rahmen wie die
restliche Seite. Lange Rechtstexte bleiben in einer begrenzten, typografisch
strukturierten Lesespalte. Kontaktformulare werden nicht auf unbeteiligten
Seiten dupliziert.

## Responsive und zugänglich

- Mobile Ansichten werden als eigenständige Nutzungssituation geprüft.
- Navigation, Theme-Umschaltung und Formulare bleiben per Tastatur und mit
  verständlichen Bezeichnungen bedienbar.
- Überschriften folgen einer nachvollziehbaren Hierarchie.
- Farbe ist nicht der einzige Träger einer Bedeutung.
- Kontraste und Lesbarkeit werden in Light und Dark Mode geprüft.
- Animationen und Bewegungen bleiben dezent und funktional.

## Prüfung sichtbarer Änderungen

Je nach Umfang werden mindestens geprüft:

1. Frontend-Build,
2. relevante Feature-Tests,
3. `git diff --check`,
4. betroffene Seite im Browser,
5. Light und Dark Mode,
6. ein mobiler Breakpoint bei Layout- oder Navigationsänderungen,
7. Browserfehler bei interaktiven Änderungen.

Ein bestandener Build bestätigt technische Gültigkeit, nicht automatisch die
gestalterische Qualität. Dafür bleiben visuelle Prüfung und Userfeedback
entscheidend.
