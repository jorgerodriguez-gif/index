const https = require('https');
const fs = require('fs');
const path = require('path');

// Cargar .env
const envPath = path.join(__dirname, '.env');
fs.readFileSync(envPath, 'utf8').split('\n').forEach(line => {
  const [key, ...rest] = line.split('=');
  if (key && rest.length) process.env[key.trim()] = rest.join('=').trim();
});

const API_KEY = process.env.HUBSPOT_API_KEY;
const PORTAL_ID = process.env.HUBSPOT_PORTAL_ID;

if (!API_KEY || !PORTAL_ID) {
  console.error('❌ Error: HUBSPOT_API_KEY o HUBSPOT_PORTAL_ID no configurados en .env');
  process.exit(1);
}

function request(endpoint, options = {}) {
  return new Promise((resolve, reject) => {
    const reqOptions = {
      hostname: 'api.hubapi.com',
      path: endpoint,
      method: options.method || 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`,
        'Content-Type': 'application/json',
      },
    };

    const req = https.request(reqOptions, res => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => {
        try {
          resolve({ status: res.statusCode, data: JSON.parse(data) });
        } catch {
          resolve({ status: res.statusCode, raw: data });
        }
      });
    });

    req.on('error', reject);
    if (options.body) req.write(JSON.stringify(options.body));
    req.end();
  });
}

async function getLeadsFromMay2026() {
  console.log('🔍 Conectando a HubSpot API...\n');

  try {
    // Dates for May 2026
    const mayStart = new Date('2026-05-01T00:00:00Z').getTime();
    const mayEnd = new Date('2026-06-01T00:00:00Z').getTime();

    console.log(`📅 Buscando leads creados entre:\n   ${new Date(mayStart).toLocaleDateString('es-MX')}\n   ${new Date(mayEnd).toLocaleDateString('es-MX')}\n`);

    // Query contacts created in May 2026
    const response = await request('/crm/v3/objects/contacts/search', {
      method: 'POST',
      body: {
        filterGroups: [
          {
            filters: [
              {
                propertyName: 'hs_analytics_date_first_seen',
                operator: 'GTE',
                value: mayStart
              },
              {
                propertyName: 'hs_analytics_date_first_seen',
                operator: 'LT',
                value: mayEnd
              }
            ]
          }
        ],
        sorts: [{ propertyName: 'hs_analytics_date_first_seen', direction: 'DESCENDING' }],
        properties: [
          'firstname',
          'lastname',
          'email',
          'phone',
          'lifecyclestage',
          'hs_analytics_date_first_seen',
          'company',
          'city',
          'country',
          'hs_lead_status'
        ],
        limit: 100
      }
    });

    if (response.status !== 200) {
      console.error('❌ Error al conectar con HubSpot:', response.data);
      process.exit(1);
    }

    const contacts = response.data.results || [];
    console.log(`✅ Se encontraron ${contacts.length} leads en mayo 2026\n`);

    return contacts;

  } catch (error) {
    console.error('❌ Error:', error.message);
    process.exit(1);
  }
}

async function generateReport(contacts) {
  if (contacts.length === 0) {
    console.log('⚠️  No hay leads creados en mayo 2026');
    return;
  }

  // Preparar datos
  const leads = contacts.map(c => {
    const props = c.properties;
    return {
      id: c.id,
      nombre: `${props.firstname?.value || ''} ${props.lastname?.value || ''}`.trim(),
      email: props.email?.value || 'N/A',
      telefono: props.phone?.value || 'N/A',
      empresa: props.company?.value || 'N/A',
      ciudad: props.city?.value || 'N/A',
      pais: props.country?.value || 'N/A',
      etapa: props.lifecyclestage?.value || 'unknown',
      lead_status: props.hs_lead_status?.value || 'N/A',
      fecha_creacion: new Date(parseInt(props.hs_analytics_date_first_seen?.value || 0)).toLocaleDateString('es-MX')
    };
  });

  // Estadísticas
  const stats = {
    total: leads.length,
    por_etapa: {},
    por_pais: {},
    por_ciudad: {},
    por_lead_status: {}
  };

  leads.forEach(lead => {
    stats.por_etapa[lead.etapa] = (stats.por_etapa[lead.etapa] || 0) + 1;
    stats.por_pais[lead.pais] = (stats.por_pais[lead.pais] || 0) + 1;
    stats.por_ciudad[lead.ciudad] = (stats.por_ciudad[lead.ciudad] || 0) + 1;
    stats.por_lead_status[lead.lead_status] = (stats.por_lead_status[lead.lead_status] || 0) + 1;
  });

  // Generar reporte
  let report = `# 📊 REPORTE DE LEADS - MAYO 2026\n\n`;
  report += `**Fecha del Reporte:** ${new Date().toLocaleDateString('es-MX')}\n`;
  report += `**Portal ID:** ${PORTAL_ID}\n`;
  report += `**Total de Leads:** ${stats.total}\n\n`;

  report += `---\n\n`;

  report += `## 📈 RESUMEN EJECUTIVO\n\n`;
  report += `| Métrica | Valor |\n`;
  report += `|--------|-------|\n`;
  report += `| Total de leads | ${stats.total} |\n`;
  report += `| Etapas representadas | ${Object.keys(stats.por_etapa).length} |\n`;
  report += `| Países | ${Object.keys(stats.por_pais).length} |\n`;
  report += `| Ciudades | ${Object.keys(stats.por_ciudad).length} |\n`;
  report += `| Estados de lead | ${Object.keys(stats.por_lead_status).length} |\n\n`;

  report += `## 🎯 DISTRIBUCIÓN POR ETAPA DE CICLO DE VIDA\n\n`;
  Object.entries(stats.por_etapa)
    .sort((a, b) => b[1] - a[1])
    .forEach(([etapa, count]) => {
      const percentage = ((count / stats.total) * 100).toFixed(1);
      const bar = '█'.repeat(Math.round(percentage / 5));
      report += `- **${etapa}**: ${count} leads (${percentage}%) ${bar}\n`;
    });

  report += `\n## 📍 DISTRIBUCIÓN POR PAÍS\n\n`;
  Object.entries(stats.por_pais)
    .sort((a, b) => b[1] - a[1])
    .forEach(([pais, count]) => {
      const percentage = ((count / stats.total) * 100).toFixed(1);
      report += `- **${pais || 'No especificado'}**: ${count} leads (${percentage}%)\n`;
    });

  report += `\n## 🏙️ TOP 10 CIUDADES\n\n`;
  const topCities = Object.entries(stats.por_ciudad)
    .sort((a, b) => b[1] - a[1])
    .slice(0, 10);

  topCities.forEach(([ciudad, count], idx) => {
    report += `${idx + 1}. **${ciudad || 'No especificado'}**: ${count} leads\n`;
  });

  report += `\n## 💼 ESTADO DEL LEAD\n\n`;
  Object.entries(stats.por_lead_status)
    .sort((a, b) => b[1] - a[1])
    .forEach(([status, count]) => {
      const percentage = ((count / stats.total) * 100).toFixed(1);
      report += `- **${status}**: ${count} leads (${percentage}%)\n`;
    });

  report += `\n---\n\n`;

  report += `## 📋 LISTA DETALLADA DE LEADS (${leads.length})\n\n`;
  report += `| # | Nombre | Email | Teléfono | Empresa | Ciudad | País | Etapa | Estado | Fecha |\n`;
  report += `|---|--------|-------|----------|---------|--------|------|-------|--------|-------|\n`;

  leads.forEach((lead, idx) => {
    report += `| ${idx + 1} | ${lead.nombre} | ${lead.email} | ${lead.telefono} | ${lead.empresa} | ${lead.ciudad} | ${lead.pais} | ${lead.etapa} | ${lead.lead_status} | ${lead.fecha_creacion} |\n`;
  });

  // Guardar reporte
  const reportPath = path.join(__dirname, 'REPORTE-LEADS-MAYO-2026.md');
  fs.writeFileSync(reportPath, report);

  console.log(`\n✅ Reporte guardado en:\n   ${reportPath}\n`);
  console.log('═'.repeat(80));
  console.log(report);
  console.log('═'.repeat(80));
}

(async () => {
  try {
    const contacts = await getLeadsFromMay2026();
    await generateReport(contacts);
  } catch (error) {
    console.error('❌ Error:', error);
    process.exit(1);
  }
})();
