# Entwicklung von d15r

## Bestehende Architektur

D15r ist eine Laravel-Anwendung mit Blade, Markdown-Inhalten, Alpine.js und
Laravel Mix. Tailwind CSS erzeugt die sichtbare Gestaltung.

Die bestehende Architektur wird erweitert, solange kein konkretes Problem
einen Wechsel rechtfertigt.

## Arbeitsweise

- Vor einer Änderung werden Route, Controller, View, Inhalt und vorhandene
  Tests des betroffenen Pfads gelesen.
- Wiederverwendbare Darstellung bleibt in gemeinsamen Layouts oder klar
  zuständigen Views.
- Neue Abstraktionen entstehen erst, wenn reale Wiederholung oder eine klare
  Verantwortung sichtbar ist.
- Inhalte bleiben nach Möglichkeit in ihren bestehenden Markdown-Quellen.
- Fachliche Aussagen werden nicht als Nebeneffekt einer technischen
  Umstrukturierung umgeschrieben.
- Kompilierte Assets werden nur über den vorhandenen Build-Prozess erzeugt.

## Absicherung

- Der kleinste relevante Test wird zuerst ausgeführt.
- Bei Änderungen an gemeinsamem Layout oder Routing werden die betroffenen
  Controller- und Feature-Tests ausgeführt.
- Bestehende bekannte Fehler werden von neuen Regressionen unterschieden.
- `git diff --check` prüft den Patch auf mechanische Fehler.
- Sichtbare Änderungen folgen zusätzlich der Prüfung aus `design.md`.

## Git

- Vor der Arbeit werden Branch und Arbeitsbaum geprüft.
- Fremde Änderungen bleiben unangetastet.
- Commits und Pushes erfolgen nur auf ausdrücklichen Auftrag.
- Destruktive Git-Befehle werden nicht verwendet, um einen fremden
  Arbeitsstand zu bereinigen.
