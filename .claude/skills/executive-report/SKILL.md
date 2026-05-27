---
name: executive-report
description: Generates premium executive marketing reports for agency clients. Enforces real data only, blocks all placeholders, applies cockpit-density design with minimal motion, and produces consultant-grade insight narratives with business impact framing.
---

# Executive Report Skill

## 0. CEFAT CLIENT OVERRIDES — HIGHEST PRIORITY

These rules apply when the client is **CEFAT** and override the general defaults below.

### 0a. Expansión de Siglas — OBLIGATORIO
Nunca usar siglas sin expandir. Siempre usar el nombre completo:
- LNV → "Lead No Calificado Ventas"
- LCM → "Lead Calificado Marketing"
- LNM → "Lead No Calificado Marketing"
- CLI → "Cliente"
- SR → "Sin respuesta"
- NI → "No interesado"

### 0b. Paleta CEFAT
```css
:root {
  --accent: #e63946;       /* Rojo CEFAT */
  --accent2: #f77f00;      /* Naranja CEFAT — único cliente donde se permite segundo acento */
  --bg: #0f172a;           /* Fondo oscuro cinematográfico */
  --surface: #1e293b;
  --surface-2: #263348;
  --border: #334155;
  --text: #f1f5f9;
  --muted: #94a3b8;
}
```

### 0c. Tipografía CEFAT
- Títulos principales: `font-size: 32px minimum`
- Subtítulos / KPI labels: `font-size: 24px minimum`
- Contenido / body: `font-size: 14px minimum`
- Labels de gráficos: `font-size: 12px minimum`
- Responsive: escala en móvil (usar `clamp()` o media queries)

### 0d. KPIs principales — 5 tarjetas obligatorias
1. Leads totales (HubSpot)
2. Sesiones web (GA4 — total)
3. Tasa de conversión
4. **Sesiones Google Ads (Paid Search)** — filtrar `sessionDefaultChannelGroup = "Paid Search"` en GA4
5. **Sesiones Meta Ads (Paid Social)** — filtrar `sessionDefaultChannelGroup = "Paid Social"` en GA4

### 0e. Estilo visual CEFAT
- Fondo: gradiente cinematográfico oscuro (fondo `#0f172a` con radial glow en esquina)
- NO usar "ALERTAS" como label visual — usar colores de estado sin la palabra "alerta"
- Espaciado amplio y legible
- Gráficos interactivos: hover tooltips con valores exactos en todos los gráficos
- Gráfico "Leads por día": mostrar número exacto al pasar mouse
- MOTION_INTENSITY para CEFAT: 5 (permite animaciones de hover en charts vía JS/CSS)

### 0f. Estructura del reporte CEFAT (14 secciones en este orden)
1. Header cinematográfico
2. KPIs principales (5 cards — ver 0d)
3. Comparativa período actual vs anterior
4. Leads por día (gráfico principal interactivo)
5. Sesiones por día
6. Fuentes de tráfico (donut interactivo)
7. Leads por fuente (barras)
8. Estados de leads (NOMBRES COMPLETOS — ver 0a)
9. Etapas de vida (NOMBRES COMPLETOS — ver 0a)
10. Desempeño por propietario
11. Páginas principales
12. Insights clave
13. Benchmark vs industria
14. Footer con datos / período

---

## 1. ACTIVE DIAL CONFIGURATION

* DESIGN_VARIANCE: 5 (Offset — asymmetric but controlled. Left-aligned headers, varied column widths, no dead-center everything)
* MOTION_INTENSITY: 3 (Static — CSS hover/active states only. No JS animations. Report must be printable and PDF-safe)
* VISUAL_DENSITY: 8 (Cockpit Mode — monospace numbers, 1px dividers instead of cards, tight paddings, maximum data per viewport)

**These dials are FIXED for this skill.** Do not change them unless the user explicitly overrides in chat. For CEFAT, see Section 0 overrides.

---

## 2. MANDATORY PRE-FLIGHT: DATA VALIDATION

**BEFORE generating any HTML, verify:**

- [ ] Client name is provided and real (not "Client", "Acme", or "TBD")
- [ ] Date range is specific (not "last month" — use exact dates: "1–21 mayo 2026")
- [ ] At least one real data source is present (GA4, Meta Ads, HubSpot, or manual data)
- [ ] KPI values are actual numbers pulled from tools or provided by user (not estimated ranges as primary values)
- [ ] The consultant has a named point of view on what the data means

**If any of these are missing: STOP and ask for the missing input. Do NOT generate a report with placeholder sections.**

---

## 3. DATA ACQUISITION — GA4 MCP WORKFLOW

When the user says "genera el reporte de [client]" or similar, follow this sequence before writing any HTML:

### Step 1 — Identify the property
```
Use: mcp__analytics-mcp__get_account_summaries
→ Find the property ID for the client
→ Confirm the date range with the user if unclear
```

### Step 2 — Pull core traffic metrics
```
Use: mcp__analytics-mcp__run_report
Parameters:
  property_id: [from step 1]
  date_ranges: [{ startDate: "YYYY-MM-DD", endDate: "YYYY-MM-DD" }]
  dimensions: ["sessionDefaultChannelGroup", "deviceCategory"]
  metrics: ["sessions", "activeUsers", "newUsers", "bounceRate", "averageSessionDuration", "engagementRate", "screenPageViews"]
```

### Step 3 — Pull conversion data
```
Use: mcp__analytics-mcp__run_report
Parameters:
  dimensions: ["pagePath"]
  metrics: ["screenPageViews", "sessions"]
  → Filter for /gracias/, /thank-you/, /confirmacion/, /success/, or known goal page
  → Cross-reference with total sessions to calculate conversion rate
```

### Step 4 — Pull top pages
```
Use: mcp__analytics-mcp__run_report
Parameters:
  dimensions: ["pagePath"]
  metrics: ["screenPageViews"]
  orderBys: [{ metric: "screenPageViews", order: "DESCENDING" }]
  limit: 10
```

### Step 5 — Pull HubSpot CRM data (if HubSpot is connected)

#### 5a — Contacts created in the period
```
Use: mcp__claude_ai_HubSpot__search_crm_objects
Parameters:
  objectType: "contacts"
  filters: [{ propertyName: "createdate", operator: "BETWEEN", value: "YYYY-MM-DD", highValue: "YYYY-MM-DD" }]
  properties: ["firstname", "lastname", "email", "hs_lead_status", "lifecyclestage", "hs_analytics_source", "createdate"]
  limit: 100
→ Total contacts created = baseline lead volume
→ Break down by lifecyclestage: lead / marketing qualified lead (MQL) / sales qualified lead (SQL) / customer
→ Break down by hs_analytics_source to compare with GA4 channel data
```

#### 5b — Deals created and pipeline value
```
Use: mcp__claude_ai_HubSpot__search_crm_objects
Parameters:
  objectType: "deals"
  filters: [{ propertyName: "createdate", operator: "BETWEEN", value: "YYYY-MM-DD", highValue: "YYYY-MM-DD" }]
  properties: ["dealname", "amount", "dealstage", "pipeline", "closedate", "hs_deal_stage_probability"]
  limit: 100
→ Count deals by stage to build a CRM funnel
→ Sum amount by stage: pipeline total, weighted pipeline, closed won
→ Calculate deal velocity: average days from contact to deal creation
```

#### 5c — Campaign performance (if email campaigns exist)
```
Use: mcp__claude_ai_HubSpot__get_campaign_analytics
→ Pull metrics for any active campaigns in the period
→ Key metrics: sends, opens, clicks, unsubscribes, conversions

Use: mcp__claude_ai_HubSpot__get_campaign_asset_metrics
→ For each campaign: which emails/landing pages drove the most engagement

Use: mcp__claude_ai_HubSpot__get_campaign_contacts_by_type
  contactType: "influenced"  → contacts that interacted with campaign
  contactType: "associated"  → contacts directly assigned to campaign
→ Cross-reference with contacts created to estimate campaign attribution
```

#### 5d — Lead source attribution cross-check
After pulling both GA4 (Step 2-4) and HubSpot (Step 5a-5c):
```
Compare:
  GA4 sessions by channel  ←→  HubSpot contacts by hs_analytics_source
  GA4 /gracias/ visits     ←→  HubSpot contacts created (should be similar)
  GA4 paid social sessions ←→  HubSpot contacts from "PAID_SOCIAL" source

If numbers diverge significantly (>20% gap):
  → Flag in methodology: "Discrepancia entre GA4 y HubSpot CRM — posible doble conteo o leads sin tracking UTM"
  → Use the lower number as the conservative estimate in KPIs
  → Note both numbers in the table
```

### Step 6 — Synthesize before writing
After pulling all data (GA4 + HubSpot):
- Build the full funnel: Sessions → Engaged → Form submit (GA4) → Contact created → MQL → Deal → Closed won (HubSpot)
- Calculate derived metrics: conv. rate GA4, contact-to-deal rate CRM, pipeline coverage ratio
- Identify the 3 most important findings across both sources (not per-platform)
- Frame each finding as a business consequence, not a metric description
- Identify 1–3 specific revenue opportunities with CRM evidence (pipeline data beats traffic guesses)

**Only then write the HTML.**

---

## 4. REPORT STRUCTURE — MANDATORY SECTIONS

Every report MUST include these sections in this order. No section may be empty, commented out, or contain placeholder text.

### A. Header
- Client name + report type (not "Reporte de Marketing Digital" generically — be specific: "Reporte de Campaña Paid Social")
- Exact date range analyzed
- Agency name + analyst email
- Generation date
- Data source(s) listed explicitly

### B. Score Banner (full-bleed, single accent color)
- Overall score as a large number (calculate it, don't approximate)
- Rating label in Spanish: "Crítico / Por debajo del promedio / Promedio / Bueno / Excelente"
- One-sentence diagnosis (the "so what" of the score)

### C. Scorecard by Category
Categories depend on data available. Use only categories for which you have actual data:
- Paid Advertising (if Meta/Google Ads data present)
- Website & Conversión (if GA4 data present)
- SEO & Orgánico (if GA4 organic data present)
- Contenido & Mensajes (if social/content data present)
- Social Media (if platform data present)
- Email & Automatización (if email platform data present)

**Do not include a category if you have no data for it. Score: 0 ≠ data absent.**

### D. KPI Grid
- Only metrics with real values
- Each KPI shows: value, label, context badge (trend or benchmark comparison)
- Numbers formatted with `font-variant-numeric: tabular-nums` and `font-family: monospace`
- No `~` estimates as primary KPI values — estimates go in footnotes

### E. Traffic Sources
- Bar chart + data table side by side
- Percentages must add to 100%
- Highlight the dominant channel visually

### F. Conversion Funnel — Full Funnel (GA4 + HubSpot)
When both sources are available, show a unified funnel that crosses the two:

```
[GA4]       Sesiones totales
[GA4]       Usuarios con engagement (engaged sessions)
[GA4]       Visitas a LP principal
[GA4]       Clics en CTA estimados
[GA4→HS]    Envíos de formulario / visitas a /gracias/
[HubSpot]   Contactos creados en CRM
[HubSpot]   Contactos MQL (marketing qualified)
[HubSpot]   Deals creados
[HubSpot]   Deals cerrados (Closed Won)
```

For each step: absolute number + % conversion to next step + % drop-off.
The GA4→HubSpot handoff step is the most critical — highlight it visually (thicker border, accent color label).

If only GA4 is available: show the standard GA4-only funnel (Steps 1–5 from Section 3).
If only HubSpot is available: show CRM funnel starting from contact stage.

### G. HubSpot CRM Summary (include only if HubSpot data is present)
Two-column layout:

**Left — Contact Pipeline**
- Total contacts created (period)
- Breakdown by lifecycle stage (table: stage → count → % of total)
- Top source channels (from `hs_analytics_source`, 3–5 rows)
- MQL rate: MQLs / total contacts created

**Right — Deal Pipeline**
- Open deals: count + total pipeline value
- Weighted pipeline value (sum of amount × probability)
- Deals closed won: count + revenue
- Average deal value
- Conversion rate: contacts → deals

If no deals exist yet (early-stage client): show contacts pipeline only, note "Pipeline de deals aún no configurado en CRM".

### H. Email Campaign Performance (include only if campaigns exist in HubSpot)
Table format:

| Campaña | Envíos | Tasa Apertura | Tasa Clic | Conversiones | Contactos Influenciados |
|---|---|---|---|---|---|
| [real campaign name] | [real number] | [real %] | [real %] | [real number] | [real number] |

Below the table: one sentence per campaign identifying the best and worst performing, with specific metric evidence.

### I. Insights — THE MOST IMPORTANT SECTION
- Maximum 4 insights (not 6–8 generic observations)
- Each insight follows this structure:
  1. **Finding** — What the data shows (one sentence, specific numbers)
  2. **Why it matters** — Business consequence if left unaddressed
  3. **Signal strength** — Is this confirmed data or an inference? Label it.
- Color coding: Red = problem requiring action, Green = strength to leverage, Yellow = watch this
- No generic statements like "la campaña genera tráfico" — every insight must be non-obvious

### H. Consultant Opportunities (agency-internal framing)
- 2–4 specific service opportunities identified from the data
- Each one: service name → what the data shows → estimated impact → confidence level
- This section is for the consultant, not the client. Write accordingly.

### I. Benchmark Comparison
- Only include benchmarks for metrics where you know the industry standard
- Source must be stated: "Benchmark: industria educación México" or similar
- Do not invent benchmarks. If unknown, omit the row.

### J. Action Plan
- Tiered by urgency: Esta Semana / Este Mes / Este Trimestre
- Each action: title + rationale (tied to a specific metric) + effort estimate + expected impact
- No generic actions like "mejorar el SEO" — must be specific: "Crear 3 artículos optimizados para 'cursos de actuación CDMX'"
- Each action item has a visible checkbox (for client use)

### K. Roadmap 30-60-90
- Three rows: quick wins → optimization → scale
- Each row: period, objective, 2–3 specific actions, measurable target metric

### L. Methodology Footer
- Data source with property ID and account ID
- Period analyzed (exact dates)
- How conversions were estimated (if estimated)
- Benchmark sources
- Tool used to generate

---

## 5. DESIGN SYSTEM — COCKPIT MODE (VISUAL_DENSITY: 8)

### Typography
```css
font-family: 'Geist', 'Outfit', system-ui, sans-serif;  /* headings */
font-family: 'Geist Mono', 'JetBrains Mono', monospace; /* ALL numbers */
font-variant-numeric: tabular-nums;                      /* ALL number elements */
```
- Headlines: `font-size: 32px; font-weight: 800; letter-spacing: -0.03em; line-height: 1`
- Section labels: `font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase`
- Body: `font-size: 13px; line-height: 1.55; color: #475569`
- KPI values: `font-size: 26px; font-weight: 800; font-family: monospace`
- No Inter. No Segoe UI. No system-ui for anything visible.

### Color Palette — ONE ACCENT, strictly
```css
:root {
  --bg: #f8f9fa;           /* page background — off-white, NOT pure white */
  --surface: #ffffff;      /* card/panel surface */
  --border: #e2e8f0;       /* all dividers */
  --text: #0f172a;         /* primary text */
  --muted: #64748b;        /* secondary text */
  --accent: [ONE COLOR];   /* chosen per client brand — default: #e94560 */
  --green: #0f9b6a;        /* positive indicators */
  --yellow: #d97706;       /* warning indicators */
  --red: #dc2626;          /* critical indicators */
}
```

**Accent color rules:**
- Use the client's brand color if known, otherwise use a single considered choice
- Never use purple/violet/indigo as accent — AI fingerprint
- Never use pure `#e94560` for every client — vary it per engagement
- `--accent` is used in: score banner, active bars, section labels, highlight boxes ONLY

### Layout — DENSITY MODE
```css
.container { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }
.kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1px; background: var(--border); }
.kpi-card { background: var(--surface); padding: 16px; }  /* NO border-radius, NO shadow */
.two-col { display: grid; grid-template-columns: 3fr 2fr; gap: 24px; }  /* NOT 1fr 1fr */
```

**DENSITY MODE rules:**
- KPI grid: use `1px` background color trick instead of `gap` to create dividers without card look
- No `border-radius` above 6px on data elements (tables, bars, KPI values)
- Sections separated by `border-top: 1px solid var(--border)` + `padding-top: 32px`, NOT `margin-bottom: 48px`
- Max 8px padding on small elements (badges, tags)
- Every number in `font-family: monospace`

### Shadows — TINTED, MINIMAL
```css
/* BANNED: box-shadow: 0 2px 8px rgba(0,0,0,.05) */
/* USE instead (tinted to bg): */
box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.03);
```
Only the score banner and header get elevation treatment. Everything else is flat with border separators.

### Header
- Full-bleed dark background: use client brand dark, NOT generic `#1a1a2e`
- NO 135° gradient — use either flat dark or a subtle radial glow from one corner
- Left-aligned content, right-aligned agency meta
- Period badge: rectangular `border-radius: 4px`, NOT pill-shaped `border-radius: 20px`

### Score Banner
- Full-bleed single accent color
- Score number: `font-size: 64px; font-weight: 900; font-family: monospace`
- Rating and description beside it, not below
- No gradient on this element — solid color only

### Cards — BANNED for data tables and KPIs
In VISUAL_DENSITY: 8, generic `white + border + shadow` cards are BANNED for:
- KPI metrics → use borderless grid with 1px separators
- Data tables → use borderless table with `border-bottom` on rows
- Score rows → use full-width rows with `border-bottom`

Cards are ONLY allowed for:
- The action plan container (one large card wrapping all tiers)
- The methodology/footnotes section
- The highlight/consultant box

### Bar Charts — CSS only, no JS
```css
.bar-fill { height: 6px; border-radius: 2px; background: var(--accent); } /* NOT 8px */
.bar-track { height: 6px; background: var(--border); border-radius: 2px; overflow: hidden; }
```
- Bars are 6px height, not 8px (cockpit density)
- No transition animations (print-safe, MOTION_INTENSITY: 3)

### Tables
```css
table { width: 100%; border-collapse: collapse; font-size: 13px; }
th { font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); padding: 8px 10px; border-bottom: 2px solid var(--border); }
td { padding: 8px 10px; border-bottom: 1px solid var(--border); font-variant-numeric: tabular-nums; }
```
- Numbers in `td` get `font-family: 'Geist Mono', monospace`
- No alternating row backgrounds — use hover only: `tr:hover td { background: #f8f9fa; }`

---

## 6. FORBIDDEN PATTERNS — HARD BLOCKS

### Placeholder content (CRITICAL — causes immediate report rejection)
```
BANNED strings in output:
- "[CLIENT NAME]", "[Insertar...]", "TBD", "N/A" as a primary value
- "$X", "~$X", "Ticket promedio de $X"
- "Lorem ipsum" in any language
- "// TODO", "// placeholder", "/* insert data */"
- Any comment in the HTML output
- Empty `<td></td>` cells
- Sections with "No hay datos disponibles" without explanation
```

### Design anti-patterns
```
BANNED CSS/HTML:
- font-family: 'Inter', 'Segoe UI', system-ui (for visible content)
- linear-gradient(135deg, ...) on header or hero areas
- border-radius: 20px on badges (use 3px or 4px)
- Multiple accent colors (--accent2 banned — one color only)
- Inline style="..." for anything beyond dynamic width values
- Emojis anywhere in the document
- Pure #000000 or #ffffff backgrounds
```

### Copy anti-patterns
```
BANNED words/phrases:
- "Elevate", "Seamless", "Unleash", "Next-Gen", "Game-changer"
- "La campaña está funcionando" without specific metric proof
- "Hay oportunidades claras" without naming them explicitly
- "Below Average" (use Spanish always: "Por debajo del promedio")
- Exclamation marks in any heading or badge
- "¡Excelente!" in success states
```

---

## 7. INSIGHT GENERATION METHODOLOGY

This is the core consultant value. Apply this framework before writing the Insights section:

### The 3-Question Filter
For every potential insight, ask:
1. **Is it non-obvious?** If a client could see this without analysis, it's not an insight.
2. **Does it have a business consequence?** If the finding doesn't affect revenue, leads, or cost — it's a metric, not an insight.
3. **Is it actionable in the next 30 days?** If not, it belongs in the Roadmap, not the Insights.

Only findings that pass all 3 questions become insights.

### Insight Hierarchy (maximum 4)
1. **The critical problem** — the one thing that is actively costing money right now
2. **The hidden strength** — what's working that the client doesn't know to protect
3. **The quick win** — the highest-leverage action available immediately
4. **The strategic risk** — what could break in 60–90 days if ignored

### Framing formula for each insight
```
[METRIC] de [VALUE] en [CHANNEL/PAGE] indica que [BEHAVIOR].
Si no se atiende, el efecto en negocio es [CONSEQUENCE].
Prioridad: [Alta/Media/Baja] — [Confirmado por datos / Inferencia de datos].
```

---

## 8. SCORING METHODOLOGY

Use this consistent formula across all reports:

| Category | Max | Data source | Scoring logic |
|---|---|---|---|
| Paid Advertising | 100 | GA4 / Ads platform | CPC vs benchmark (30), CTR vs benchmark (30), ROAS or conv. rate (40) |
| Website & Conversión | 100 | GA4 | Bounce rate (30), session duration (25), conv. rate (45) |
| SEO & Orgánico | 100 | GA4 | % organic traffic (40), keyword rankings present (30), technical issues (30) |
| Contenido & Mensajes | 100 | GA4 + HubSpot | Message-market fit signals (40), content volume (30), engagement signals (30) |
| Social Media | 100 | GA4 + platform | Follower growth (20), engagement rate (40), organic reach (40) |
| Email & Automatización | 100 | HubSpot | Sequence in place (30), open rate vs benchmark (40), automation coverage (30) |
| CRM & Pipeline | 100 | HubSpot | Contact-to-MQL rate (30), deals in pipeline (30), pipeline coverage ratio (40) |

**CRM & Pipeline score** (only include if HubSpot has deal data):
- Contact-to-MQL rate ≥ 20% → 30 pts; 10–19% → 20 pts; < 10% → 10 pts
- Deals in pipeline covering ≥ 3× monthly revenue target → 30 pts; 1–3× → 20 pts; < 1× → 10 pts
- Pipeline coverage ratio (weighted pipeline / revenue target): ≥ 2× → 40 pts; 1–2× → 25 pts; < 1× → 10 pts

**Email & Automatización score** (use HubSpot campaign data when available):
- Open rate ≥ 25% → 40 pts; 15–24% → 25 pts; < 15% → 10 pts (benchmark: B2C education México ~22%)
- Click rate ≥ 3% → 20 pts; 1–2.9% → 12 pts; < 1% → 5 pts (included in automation coverage sub-score)
- No sequences configured → 0 pts for automation coverage

**Overall score = weighted average** (weight each category by data confidence):
- High confidence (direct data): weight 1.0
- Estimated (inferred from proxies): weight 0.7
- Unknown (no data): exclude from average, note in methodology

Score thresholds:
- 0–39: Crítico
- 40–54: Por debajo del promedio
- 55–69: Promedio
- 70–84: Bueno
- 85–100: Excelente

---

## 9. PRINT STYLESHEET — MANDATORY

Every report MUST include a print/PDF stylesheet:

```css
@media print {
  body { background: white; color: #0f172a; font-size: 11px; }
  .header { background: #0f172a !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  .score-banner { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  .bar-fill { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  .container { max-width: 100%; padding: 0; }
  .two-col { grid-template-columns: 1fr 1fr; }
  .no-print { display: none; }
  .section { break-inside: avoid; page-break-inside: avoid; }
  .card { box-shadow: none; border: 1px solid #e2e8f0; }
  a { text-decoration: none; color: inherit; }
  @page { margin: 1.5cm 1.5cm 1.5cm 1.5cm; size: A4; }
}
```

---

## 10. FINAL PRE-OUTPUT CHECKLIST

Run this before outputting any HTML:

- [ ] All KPI values are real numbers from tools or user-provided data
- [ ] No inline `style=""` except for dynamic width values (`width: 68%`)
- [ ] No emojis anywhere in the document
- [ ] No placeholder strings (`$X`, `[client]`, `TBD`)
- [ ] Font is Geist or Outfit (loaded from Google Fonts)
- [ ] All numbers are in monospace / tabular-nums
- [ ] Only ONE accent color is used throughout
- [ ] Header uses flat dark, NOT 135° gradient
- [ ] Badges use `border-radius: 3px`, NOT `border-radius: 20px`
- [ ] Insights section has maximum 4 insights, each with business consequence stated
- [ ] Consultant opportunities section exists and is specific
- [ ] Print stylesheet is present and complete
- [ ] Methodology section lists property ID, date range, and estimation notes
- [ ] If HubSpot data was used: GA4 vs HubSpot contact count discrepancy is documented if > 20% gap
- [ ] HubSpot sections (CRM summary, email campaigns) are present only when real data exists for them — no empty tables
- [ ] Full funnel shows the GA4→HubSpot handoff step with explicit label
- [ ] No HTML comments in the output

**If any item fails: fix before outputting.**
