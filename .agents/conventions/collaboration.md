# Zusammenarbeit an d15r

Diese Konvention beschreibt die verbindliche Arbeitsweise für konkrete
Aufgaben an d15r.

## Grundhaltung

- Bestehende Inhalte, Codepfade und Darstellung werden vor Änderungen
  verstanden.
- Arbeit erfolgt in kleinen, eigenständig prüfbaren Schritten.
- Bestehende Gestaltung wird erweitert, statt auf jeder Seite neu erfunden.
- Nicht zur Aufgabe gehörende Änderungen werden weder übernommen noch
  zurückgesetzt.
- Unsicherheit wird sichtbar gehalten und nicht durch erfundene Gewissheit
  ersetzt.

## Kontext vor der Arbeit

1. Den Einstieg unter `../../AGENTS.md` und die zuständige Rolle vollständig
   lesen.
2. `../domains/AGENTS.md` vollständig lesen und dessen Routing folgen.
3. Für sichtbare Änderungen zusätzlich `design.md` vollständig lesen.
4. Für technische Änderungen zusätzlich `development.md` vollständig lesen.
5. Bei einer größeren laufenden Aufgabe die zugehörige Datei unter
   `../plan/` lesen.

Bestehendes ICM-Wissen wird im Arbeitsdokument nur referenziert. Dort verbleiben
Ziel, aufgabenspezifisches Delta, offene Fragen, nächster Schritt und geplante
Absicherung.

## Verbindlicher Analyse-Stopp

Wenn der User ausdrücklich darum bittet, `AGENTS.md` oder das ICM zu lesen,
erfolgt danach zunächst nur Analyse. Nach der Untersuchung werden kurz
festgehalten:

- was gefunden wurde,
- welcher kleinste nächste Schritt sinnvoll ist,
- welche Dateien davon betroffen wären,
- wie das Ergebnis geprüft würde.

Produktive Änderungen beginnen erst nach ausdrücklicher Freigabe. Hat der User
die konkrete Änderung bereits beauftragt, gilt diese Freigabe als erteilt.
Wächst der Schritt wesentlich über den angekündigten Umfang hinaus, wird erneut
gestoppt.

## Kommunikation

- Vor Änderungen werden Umfang und erwartete Wirkung benannt.
- Fachlich unscharfe Entscheidungen werden nicht nebenbei technisch festgelegt.
- Nach einem Schritt werden Ergebnis, Absicherung und verbleibende
  Unsicherheiten knapp gemeldet.
- Direktes Userfeedback wird als Beobachtung behandelt und in der
  Evolutionsprüfung berücksichtigt.

## ICM-Pflege

Nach jedem abgeschlossenen Schritt wird geprüft:

1. Ist eine dauerhaft relevante technische oder gestalterische Konvention
   entstanden?
2. Wurde fachliches Wissen über Zweck, Begriffe oder Beziehungen von d15r
   bestätigt, korrigiert oder widerlegt?
3. Betrifft eine Beobachtung nur den aktuellen Auftrag oder hilft sie späteren
   Aufgaben?
4. Muss bestehendes ICM-Wissen präzisiert, zusammengeführt oder entfernt
   werden?

Bestätigtes technisches Wissen gehört nach `conventions/`, bestätigtes
fachliches Wissen nach `domains/`. Vorläufige Annahmen bleiben in der
Arbeitsdatei oder werden als Experiment gekennzeichnet.
