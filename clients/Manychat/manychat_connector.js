const https = require('https');
const fs = require('fs');
const path = require('path');

// Cargar .env manualmente
const envPath = path.join(__dirname, '.env');
fs.readFileSync(envPath, 'utf8').split('\n').forEach(line => {
  const [key, ...rest] = line.split('=');
  if (key && rest.length) process.env[key.trim()] = rest.join('=').trim();
});

const API_KEY = process.env.MANYCHAT_API_KEY;

function request(endpoint) {
  return new Promise((resolve, reject) => {
    const options = {
      hostname: 'api.manychat.com',
      path: endpoint,
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${API_KEY}`,
        'Content-Type': 'application/json',
      },
    };

    const req = https.request(options, res => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => {
        try {
          resolve(JSON.parse(data));
        } catch {
          resolve({ raw: data });
        }
      });
    });

    req.on('error', reject);
    req.end();
  });
}

async function main() {
  console.log('Conectando a Manychat API...\n');

  // 1. Info de la cuenta
  const info = await request('/fb/page/getInfo');
  if (info.status !== 'success') {
    console.error('Error al conectar:', JSON.stringify(info, null, 2));
    process.exit(1);
  }

  console.log('=== INFORMACIÓN DE CUENTA ===');
  console.log(`Nombre: ${info.data.name}`);
  console.log(`Pro: ${info.data.is_pro ? 'Sí' : 'No'}`);
  console.log(`Timezone: ${info.data.timezone}`);
  console.log(`Categoría: ${info.data.category || 'N/A'}\n`);

  // 2. Obtener campos personalizados
  console.log('Obteniendo campos personalizados...');
  const fields = await request('/fb/page/getCustomFields');

  if (fields.status === 'success' && fields.data) {
    console.log(`Total de campos: ${Array.isArray(fields.data) ? fields.data.length : 0}\n`);
    if (Array.isArray(fields.data) && fields.data.length > 0) {
      console.log('Campos disponibles:');
      fields.data.slice(0, 5).forEach(f => {
        console.log(`  - ${f.name || f.id} (${f.type || 'unknown'})`);
      });
      if (fields.data.length > 5) {
        console.log(`  ... y ${fields.data.length - 5} más`);
      }
    }
  } else {
    console.log('No se pudieron obtener campos personalizados');
  }

  console.log('\n=== ESTADO DE CONEXIÓN ===');
  console.log('✓ Conexión a API exitosa');
  console.log('✓ Autenticación válida');
  console.log('\nNota: Los flows no pueden ser listados vía API en Manychat.');
  console.log('Para trabajar con flows, usa la interfaz web o dispara flows');
  console.log('mediante POST a /fbsend/sendFlowToSubscriber con el ID del flow.');
}

main().catch(err => {
  console.error('Error inesperado:', err.message);
  process.exit(1);
});
