# Book Workflow


# 📘 Eudaimonica – Book Workflow

Dieser Workflow definiert die Zusammenarbeit zwischen **Daniel**, **ChatGPT** und **GitHub Copilot** beim Schreiben der Bücher *Play*, *Multiplayer* und *Worldbuilding*.

Ziel: ein selbstorganisierendes Schreibsystem, in dem Ideen aus dem Chat → in Blueprints → in Integration-Tasks → in fertigen Text überführt werden.

---

## 1. 🎯 Zweck dieses Workflows

- Alle drei Akteure arbeiten synchron und rollenbasiert.
- ChatGPT = Denken, Struktur, Architektur.
- Copilot = Schreiben, Fortsetzen, Ausformulieren.
- Daniel = Entscheider, Kurator, Autor.

Dieser Workflow ist die zentrale Referenz für das gesamte Schreibsystem.

---

## 2. 👥 Rollen

### **Daniel**
- schreibt in den Buchdateien unter `resources/markdown/eudaimonica/*.md`
- entscheidet über Copilot-Vorschläge
- bringt Themen & Ideen in den Chat
- kopiert Textauszüge zur Überprüfung in den Chat

### **ChatGPT**
- spiegelt Gedanken und diskutiert Themen
- erstellt Blueprint-Strukturen in `resources/markdown/eudaimonica/blueprint/*.md`
- erzeugt Integration-Tasks inkl. Copilot-Prompts in `resources/markdown/eudaimonica/integration/*.md`
- überwacht Stil, Logik, Konsistenz der Bücher
- gibt präzises Feedback auf Copilot-Output

### **GitHub Copilot**
- liest den gesamten Projektordner inkl. `blueprint/`, `integration/` und `book-workflow.md`
- schreibt in den Buchdateien unter `resources/markdown/eudaimonica/*.md`
- folgt strikt den Prompts aus den Integration-Dateien
- hilft beim Ausformulieren, Fortsetzen, Verbessern

---

## 3. 📁 Projektstruktur

Alle relevanten Dateien liegen unter:

`resources/markdown/eudaimonica/`

**Bücher (finaler Text):**

- `resources/markdown/eudaimonica/play.md`
- `resources/markdown/eudaimonica/multiplayer.md`
- `resources/markdown/eudaimonica/worldbuilding.md`

**Blueprints (Ideen & Struktur):**

- `resources/markdown/eudaimonica/blueprint/play-blueprint.md`
- `resources/markdown/eudaimonica/blueprint/multiplayer-blueprint.md`
- `resources/markdown/eudaimonica/blueprint/worldbuilding-blueprint.md`
- `resources/markdown/eudaimonica/blueprint/meta-blueprint.md`
- `resources/markdown/eudaimonica/blueprint/structure-blueprint.md`

**Integration (Aufgaben + Copilot-Prompts):**

- `resources/markdown/eudaimonica/integration/play-integration.md`
- `resources/markdown/eudaimonica/integration/multiplayer-integration.md`
- `resources/markdown/eudaimonica/integration/worldbuilding-integration.md`

**Dieser Workflow (Meta-Prompt):**

- `resources/prompts/book-workflow.md`

---

## 4. 🧭 Ablauf (Schritt für Schritt)

### Schritt 1 – Diskussion (Daniel ↔ ChatGPT)
- Thema wird im Chat besprochen.
- ChatGPT spiegelt, stellt Fragen, destilliert klare Ideen.
- Ergebnis: ein **sauberer Blueprint-Eintrag**.

### Schritt 2 – Blueprint-Aktualisierung (ChatGPT)
- ChatGPT trägt die strukturierten Ideen in die passende Blueprint-Datei ein.
- Blueprint-Dateien bleiben **ideenorientiert, nicht textorientiert**.

### Schritt 3 – Integration-Task erzeugen (ChatGPT)
- ChatGPT formuliert aus dem Blueprint eine konkrete Schreibaufgabe.
- Jeder Integration-Task enthält:
  - Abschnittstitel
  - Beschreibung des Ziels
  - Wo es im Buch hingehört
  - Umfang / Schwerpunkt
  - fertigen **Copilot-Prompt** als HTML-Kommentar.

**Beispiel:**

```md
### Abschnitt: Echte Sicherheit

- [ ] Schreibe den Abschnitt in `resources/markdown/eudaimonica/play.md` unter Kapitel „Sicherheit“.

<!-- Copilot:
Schreibe 800–1000 Wörter in du-Ansprache.
Thema: Echte Sicherheit = Beziehungen, Kompetenzen, Infrastruktur.
Ton: ruhig, klar, anschaulich.
Baue Beispiele ein: Waldgarten, gemeinsames Haus, Nachbarschaft.
→ Fokus auf Gleichgewicht & Leidensdruck als Feedbackmechanik.
-->
```

### Schritt 4 – Schreiben (Daniel ↔ Copilot)
- Daniel öffnet die passende Buchdatei.
- Copilot liest Blueprint, Integration und die Buchdatei.
- Copilot macht Vorschläge, schreibt Abschnitte oder Übergänge.
- Daniel steuert, verfeinert und entscheidet, was bleibt.

### Schritt 5 – Review (Daniel ↔ ChatGPT)
- Daniel kopiert Textauszüge zurück in den Chat.
- ChatGPT prüft:
  - Stimmigkeit zur Gesamtphilosophie
  - Konsistenz zu anderen Kapiteln
  - Klarheit, Struktur, Wiederholungen
  - Narrativ & Gleichgewichtssystem
- ChatGPT macht konkrete Verbesserungsvorschläge oder Alternativformulierungen.

### Schritt 6 – Abschluss (ChatGPT)
- Integration-Task wird in der entsprechenden Datei abgehakt.
- Ggf. Folge-Tasks werden ergänzt (Übergänge, Querverweise, neue Abschnitte).

---

## 5. 📄 Dateitypen & ihre Rollen

### Blueprint-Dateien
- Sammeln **Ideen, Konzepte, Metaphern, Struktur**.
- Kein fertiger Fließtext.
- Dienen als Denk- und Canvas-Ebene für ChatGPT & Daniel.

### Integration-Dateien
- Enthalten **konkrete Aufgaben** für das Schreiben.
- Jede Aufgabe inklusive Copilot-Prompt als HTML-Kommentar (`<!-- ... -->`).
- Verknüpfen Blueprint (Idee) mit Buch (Text).

### Buch-Dateien
- Enthalten den eigentlichen Text für die drei Bücher.
- Hier schreiben nur **Daniel** und **Copilot**.
- ChatGPT interagiert mit diesen Dateien nur indirekt über Copy/Paste.

---

## 6. 🤖 Copilot-Regeln

- Copilot schreibt ausschließlich in den Buchdateien unter `resources/markdown/eudaimonica/*.md`.
- Er folgt **primär den Prompts** aus den Integration-Dateien.
- Er nutzt Blueprint-Dateien als Kontext, erfindet aber keine völlig neuen Konzepte.
- Ton & Stil der bestehenden Texte werden respektiert und fortgeführt.

---

## 7. 🧠 ChatGPT-Regeln

- Schreibt **nie direkt** in die Buchdateien.
- Arbeitet nur auf der Ebene von Blueprint und Integration.
- Erstellt alle Copilot-Prompts als HTML-Kommentare.
- Achtet auf fraktale Konsistenz zwischen Play / Multiplayer / Worldbuilding.
- Hält die Gleichgewichtslogik (Individuum – Stadt – Welt) auf allen Ebenen stimmig.

---

## 8. 🔄 Beispiel eines gesamten Zyklus

1. Daniel: „Ich möchte einen Abschnitt über echte Sicherheit schreiben.“
2. ChatGPT: Diskussion → Destillation → Blueprint-Inhalt.
3. ChatGPT: erstellt Integration-Task + Copilot-Prompt.
4. Daniel öffnet `play.md`, Copilot schreibt / ergänzt.
5. Daniel bringt den Abschnitt zurück in den Chat.
6. ChatGPT optimiert Text & Einbettung.
7. ChatGPT hakt den Integration-Task ab und ergänzt ggf. Folge-Tasks.

---

## 9. 🗂️ Weiterentwicklung

- Änderungen an diesem Workflow werden ebenfalls versioniert.
- Neue Erkenntnisse fließen direkt hier ein.
- Copilot soll diese Datei aktiv lesen und daraus sein Verhalten ableiten.

---

_Ende des Workflows._