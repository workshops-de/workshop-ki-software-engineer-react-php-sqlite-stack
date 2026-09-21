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
| 12  | Claude Code Workshop           | adaptiert von [`workshop-claude-code`](https://github.com/workshops-de/workshop-claude-code) (27 Tasks, gleiches Nummernschema); Referenz-Domäne "Bookmonkey Community" (Bücher ausleihen) statt "Clash"; **Slides fehlen noch** (siehe `lesson.yml`) |

Details zur Migrationsentscheidung: siehe Konzept-Zusammenfassung im PR/Commit-Verlauf.

### Lesson 12: Claude Code Workshop

Diese Lesson ist strukturell 1:1 von [`workshop-claude-code`](https://github.com/workshops-de/workshop-claude-code)
übernommen (27 Tasks, gestuftes Nummernschema `010`–`270`, keine vorbereiteten Solution-Branches —
Teilnehmer besitzen jeden Code, den sie schreiben, wie im Original). Referenz-App ist nicht
[`pawsaw/clash`](https://github.com/pawsaw/clash), sondern eine erweiterte **"Bookmonkey
Community"**-Domäne (Bücher ausleihen: Nutzer bieten Bücher zum Verleih an, andere fragen an, der
Besitzer akzeptiert/lehnt ab) auf Next.js + PHP/Slim + SQLite — analog zu unserem `app/`-Ordner,
aber bewusst **kein Startcode**: Teilnehmer bauen alles selbst auf.

7 der 27 Tasks (`060`–`120`, "Building Bookmonkey") enthalten echte Architektur-Anpassungen
gegenüber dem Original (Next.js-Monolith mit Prisma/Server-Actions → getrennte Next.js-Frontend +
PHP/Slim-Backend-Architektur mit PDO/SQLite). Die restlichen 20 Tasks sind Claude-Code-Tool-Wissen
und praktisch stack-agnostisch, daher nahezu unverändert übernommen.

**Offen:** Die Slides (Google Slides im Original) fehlen noch für diese Lesson.

## 🔗 Platform Integration

- **lesson.yml**: Lesson-Metadaten, werden zur workshops.de-Plattform synchronisiert
- **task.yml**: Task-Metadaten, werden synchronisiert
- **GitHub Sync**: Die Plattform importiert Lessons/Tasks automatisch aus diesem Repo

## 📄 License

MIT
