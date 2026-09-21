# KI Software Engineer — React (TypeScript) + PHP/SQLite Stack

Workshop-Slides und Aufgaben für den **workshops.de**-Kurs "KI Software Engineer", spezialisiert auf den
Technologie-Stack:

- **Frontend:** TypeScript mit modernem React (Next.js, App Router)
- **Backend:** PHP (Slim Framework) mit SQLite
- **Begleit-App:** [Bookmonkey](./app) — ein Bücherkatalog, der über die gesamte Workshop-Dauer
  weiterentwickelt wird (gleiches Domänenmodell wie im ursprünglichen Angular-Workshop, jetzt mit
  eigenem PHP-Backend statt einer externen Fake-API)

Dieses Repository basiert auf dem [`ki-software-engineer-slides`](https://github.com/workshops-de/ki-software-engineer-slides)
Kurs und dem [`workshop-slides-template`](https://github.com/workshops-de/workshop-slides-template) für die
Slidev/Classroom-Integration. Es nutzt weiterhin das **Lesson-Format**, damit Inhalte 1:1 in das
workshops.de-Classroom-System importiert werden können.

## 🚀 Quick Start (Slides)

```bash
npm install
npm run dev        # interaktives Menü, wählt eine Lesson
npm run dev:01      # startet Lesson 01 direkt
```

Slides öffnen unter http://localhost:3030.

## 🚀 Quick Start (Begleit-App)

```bash
cd app
docker compose up
```

- Frontend: http://localhost:3000
- Backend/API: http://localhost:8080

Details siehe [`app/README.md`](./app/README.md).

## 📁 Project Structure

```
/
├── 00-index.md                      # Übersicht aller Lessons
├── slides.md                        # Alle Lessons in einem Deck (Presenter-View)
├── sources.md                       # Quellen der Slides
├── package.json                     # Slidev-Dependencies & Scripts
├── scripts/                         # Build- & Dev-Skripte für Slidev
├── lessons/                         # Alle Lessons (siehe unten)
├── app/                             # Begleit-App "Bookmonkey" (Next.js + PHP/Slim + SQLite)
│   ├── frontend/                    # Next.js (TypeScript) Client
│   ├── backend/                     # PHP/Slim API + SQLite
│   └── docker-compose.yml           # Lokales Dev-Setup (kein Online-Playground)
└── .cursor/
    ├── rules/                       # AI-Regeln für Slide-/Task-Erstellung
    └── skills/                      # Skills: lesson-migration, lesson-review, lesson-section
```

## 📚 Lessons

| #   | Lesson                      | Stack-Anpassung                                                                 |
| --- | ---------------------------- | -------------------------------------------------------------------------------- |
| 01  | Why Software Engineers Need AI | unverändert (stack-agnostisch)                                                  |
| 011 | Model Selection & Benchmarks  | unverändert (stack-agnostisch)                                                  |
| 02  | How LLMs Work                 | Beispiel für Halluzinationen an React/Next.js angepasst                         |
| 04  | Prompt Engineering            | Tasks arbeiten am Bookmonkey-Frontend (Next.js) statt Angular                   |
| 06  | Context Engineering           | unverändert (stack-agnostisch)                                                  |
| 07  | Agents & Skills               | Refactoring-Skill für React-Komponenten & PHP-Klassen statt Angular             |
| 08  | Code Agents                   | unverändert (Tool-Feature-Overview, stack-agnostisch)                          |
| 09  | Model Context Protocol        | MCP-Server generiert React-Komponenten & PHP-Controller statt Angular-Code       |
| 10  | Agentic Workflow               | unverändert (stack-agnostisch, GitHub Actions)                                 |
| 11  | Evals                          | unverändert (Tool ist stack-agnostisch)                                        |
| 12  | Claude Code Workshop           | adaptiert von [`workshop-claude-code`](https://github.com/workshops-de/workshop-claude-code) (28 Tasks, gleiches Nummernschema); vereinfachte, **offline-fähige** Referenz-Domäne (Bücher anlegen/editieren + Checkout) statt "Clash"; **Slides fehlen noch** (siehe `lesson.yml`) |

Details zur Migrationsentscheidung: siehe Konzept-Zusammenfassung im PR/Commit-Verlauf.

### Lesson 12: Claude Code Workshop

Diese Lesson ist strukturell 1:1 von [`workshop-claude-code`](https://github.com/workshops-de/workshop-claude-code)
übernommen (28 Tasks, gestuftes Nummernschema `010`–`270`, keine vorbereiteten Solution-Branches —
Teilnehmer besitzen jeden Code, den sie schreiben, wie im Original). Referenz-App ist nicht
[`pawsaw/clash`](https://github.com/pawsaw/clash), sondern eine bewusst **einfache** Bookmonkey-
Variante (Bücher anlegen/editieren, Cover-Upload, ein simpler Checkout/Return-Workflow) auf
Next.js + PHP/Slim + SQLite — analog zu unserem `app/`-Ordner, aber **kein Startcode**: Teilnehmer
bauen alles selbst auf.

**Wichtig — für einen Kunden mit komplett offline/air-gapped Umgebung angepasst:**
- Keine Vercel-Skills-Marketplace-Installs mehr (`npx skills add vercel/...` in den Tasks 060,
  130, 170 entfernt)
- Kein shadcn/ui (externe Component-Registry) — nur reines Tailwind CSS
- Kartenaufgabe (Leaflet + OpenStreetMap-Kacheln = externe Netzwerkzugriffe) ersetzt durch einen
  rein client-seitigen Cover-Upload mit Vorschau (Task `110`) — gleiche Lernlektion ("harte
  Constraints vorher benennen"), ohne jeden externen Call
- Domäne stark vereinfacht: nur "Book" (+ optional Reviews) statt einer komplexen
  Zwei-Parteien-Workflow-Domäne mit Venues/Notifications
- Tasks `010`, `015`, `260`, `270` brauchen weiterhin einmalige Installs aus dem Netz (Claude
  Code selbst, Spec Kit, BMAD) — siehe die jeweiligen `trainer_hint.md` für Vorbereitungs-Hinweise

Details zu allen Architektur-Anpassungen (Tasks `060`–`120`, "Building Bookmonkey": Next.js-
Monolith mit Prisma/Server-Actions → getrennte Next.js-Frontend + PHP/Slim-Backend-Architektur mit
PDO/SQLite) stehen in den jeweiligen `body.md`/`trainer_hint.md`-Dateien. Die restlichen ~20 Tasks
sind reines Claude-Code-Tool-Wissen und praktisch stack-agnostisch.

**Offen:** Die Slides (Google Slides im Original) fehlen noch für diese Lesson.

## 🔗 Platform Integration

- **lesson.yml**: Lesson-Metadaten, werden zur workshops.de-Plattform synchronisiert
- **task.yml**: Task-Metadaten, werden synchronisiert
- **GitHub Sync**: Die Plattform importiert Lessons/Tasks automatisch aus diesem Repo

## 📄 License

MIT
