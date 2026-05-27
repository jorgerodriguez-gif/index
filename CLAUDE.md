# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Workspace Overview

This is a **multi-project workspace** for Jorge Rodriguez containing four distinct projects:

| Project | Purpose | Status | Key Tech |
|---------|---------|--------|----------|
| **Manychat** | Chatbot/messaging platform API integration with automation testing | Active | Node.js, Playwright, Manychat API |
| **Agentes** | Marketing audit analysis and competitive intelligence documentation | Analysis | Documentation, Web screenshots |
| **Datavision** | Email sequence templates and web application development | Active | Email marketing, Screenshots |
| **Sadasi** | Placeholder/inactive project | Inactive | — |

## Project Details

### Manychat (`/Manychat`)

**Purpose:** Integrate with Manychat API and automate testing of chatbot flows.

**Setup & Commands:**
```bash
# Install dependencies
npm install

# Run API connector (fetches Manychat account info)
node manychat_connector.js

# Run browser automation (logs in and navigates flows)
node manychat-review.js
```

**Architecture:**
- `manychat_connector.js` — HTTPS client for Manychat API (`api.manychat.com`), uses Bearer token auth
- `manychat-review.js` — Playwright browser automation; logs into Manychat, navigates to Flows section, captures flow details as screenshots
- Both scripts load environment variables from `.env` (API key stored there)
- Playwright MCP configured via `.mcp.json` for extended capabilities

**Key Implementation Details:**
- Manual `.env` parsing (doesn't use dotenv package)
- Google OAuth login with manual password entry in browser
- Cloudflare bypass handling (15s timeout)
- Screenshot-based logging (useful for debugging UI changes)
- Supports flexible flow navigation (multiple selector fallbacks)

**Important:** The `.env` file contains `MANYCHAT_API_KEY` — **never commit this file or expose the key**.

### Agentes (`/Agentes`)

**Purpose:** Marketing audit analysis and competitive intelligence for B2B clients.

**Content:**
- `MARKETING-AUDIT.md` — Comprehensive marketing audit of Grupo Ei (customs brokerage), including score breakdown, recommendations, and revenue impact analysis
- Website screenshots and extracted content (`grupoei-*.md` files)
- PDF reports for client delivery

**Context:** Grupo Ei is a B2B customs & logistics provider. Audit identified gaps in conversion optimization, social proof, and institutional trust signals. Top recommendations focus on fixing trust signals, reducing form friction, and creating case studies.

### Datavision (`/Datavision`)

**Purpose:** Email marketing sequences and web application documentation.

**Content:**
- `EMAIL-SEQUENCES.md` — Template prompts and sequences for email marketing campaigns
- Screenshots of web application (Lovable-based) showing plant analysis, login, and dashboard UI

**Note:** This appears to be an agricultural/crop analysis application based on screenshot naming (`azure-plant-scan.png`).

### Sadasi (`/Sadasi`)

**Status:** Empty — placeholder for future project.

---

## Shared Infrastructure

### Playwright MCP

All projects with web automation have `.playwright-mcp` directory (Playwright Model Context Provider). This provides:
- Browser automation capabilities (Chromium, Firefox, WebKit)
- Test generation and healing
- DOM inspection and element interaction
- Screenshot and trace recording

**Common Playwright patterns in this workspace:**
- Chrome launch with `headless: false` and `slowMo` for interactive debugging
- URL-based navigation with timeout handling
- Cloudflare bypass detection
- Screenshot capture for manual review and debugging

### Project Structure

Each project has:
- `.claude/` — Claude Code configuration (settings, plans, etc.)
- `.playwright-mcp/` — Playwright MCP cache/tools
- Project-specific files and documentation

---

## Working with This Workspace

### When Creating New Features/Fixes

1. **Manychat work:** Update connector scripts or browser automation. Changes likely affect login flow or API interaction.
2. **Documentation work:** Update `.md` files in Agentes or Datavision. Maintain context for client deliverables.
3. **Cross-project changes:** Rare; most projects are independent.

### Common Development Patterns

**Node.js projects** (Manychat):
```bash
node <script-name>.js    # Run scripts directly
npm install              # Install dependencies
```

**Documentation projects** (Agentes, Datavision):
- Update `.md` files
- Maintain screenshot references
- PDF reports are client deliverables (do not modify unless explicitly requested)

### Testing & Verification

- **Manychat API script:** Validates MANYCHAT_API_KEY and connection to Manychat API
- **Manychat browser script:** Uses Playwright to open headless browser and capture flow state as screenshots
- **Documentation:** No automated tests; review manually for accuracy and formatting

### Secrets & Environment

- `.env` file in Manychat contains `MANYCHAT_API_KEY` — **never commit or expose**
- Other projects do not have secrets (safe to share)
- Workspace-level `.gitignore` typically excludes `.env`

---

## Future Work & Context

- **Agentes:** Marketing audit work is analysis-driven; client recommendations focus on trust signals and conversion optimization
- **Datavision:** Email templates are reusable; screenshot documentation helps track UI/UX progress
- **Manychat:** API connector and automation scripts are utilities for campaign management and testing
