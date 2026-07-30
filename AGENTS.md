# D15r

D15r ist ein eigenständiges Holon für eine lebende persönliche Philosophie und
ihren Ausdruck als Webseite.

## Arbeitsmodell

- Sichtbare Projektdateien enthalten Anwendung, Inhalte und öffentliche
  Dokumentation.
- `.agents/` enthält den für Agenten konsolidierten Projektkontext.
- `AGENTS.md` ist der stabile Einstieg und routet in den für eine Aufgabe
  notwendigen Kontext.
- Bestätigtes Wissen wird an genau einer zuständigen Stelle gepflegt und von
  anderen Stellen nur referenziert.

## Routing

| Signal oder Auftrag | Zuständiger Einstieg |
| --- | --- |
| Jede neue, noch nicht technisch zugeschnittene Arbeit an d15r | `.agents/roles/coordinator/AGENTS.md` |
| Ein ausdrücklich übergebener, bereits klar zugeschnittener technischer Schritt | `.agents/roles/developer/AGENTS.md` |

Die verlinkte `AGENTS.md` und der von ihr geroutete Kontext werden vor der
Arbeit vollständig gelesen. Passt kein Routing-Eintrag eindeutig, wird keine
neue Prozesslogik erfunden, sondern der notwendige Kontext mit dem User
geklärt.

## Grenzen

- Bestehende, nicht zur Aufgabe gehörende Änderungen bleiben unangetastet.
- D15r verändert keine anderen Holons ohne ausdrücklichen Auftrag.
- Inhalte der Philosophie werden nicht beiläufig durch technische Arbeit
  verändert.
- Aktuelle Gestaltung und Architektur sind Ausgangslagen, keine unveränderbaren
  Endzustände.
- Neue Regeln und Strukturen entstehen aus realer Arbeit, nicht vorsorglich.
