const https = require('https');
const fs = require('fs');
const path = require('path');

// Cargar .env
const envPath = path.join(__dirname, '.env');
fs.readFileSync(envPath, 'utf8').split('\n').forEach(line => {
  const [key, ...rest] = line.split('=');
  if (key && rest.length) process.env[key.trim()] = rest.join('=').trim();
});

const API_KEY = process.env.MANYCHAT_API_KEY;

function request(endpoint, method = 'GET', body = null) {
  return new Promise((resolve, reject) => {
    const options = {
      hostname: 'api.manychat.com',
      path: endpoint,
      method,
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
          resolve({ status: res.statusCode, data: JSON.parse(data) });
        } catch {
          resolve({ status: res.statusCode, data });
        }
      });
    });

    req.on('error', reject);
    if (body) req.write(JSON.stringify(body));
    req.end();
  });
}

async function main() {
  console.log('🔍 Diagnóstico Completo de Manychat API\n');
  console.log('Documentación oficial: https://api.manychat.com/swagger\n');

  // Endpoints actuales que funcionan
  const endpoints = [
    { path: '/fb/page/getInfo', method: 'GET', desc: 'Información de cuenta', important: true },
    { path: '/fb/page/getTags', method: 'GET', desc: 'Lista de tags' },
    { path: '/fb/page/getCustomFields', method: 'GET', desc: 'Campos personalizados' },
    { path: '/fb/subscriber/getList', method: 'GET', desc: 'Lista de suscriptores' },
    { path: '/fb/automations/getList', method: 'GET', desc: 'Lista de automatizaciones' },
    { path: '/fbsend/sendContent', method: 'POST', desc: 'Enviar contenido a suscriptor' },
    { path: '/fbsend/sendFlowToSubscriber', method: 'POST', desc: 'Disparar flow a suscriptor' },
  ];

  console.log('Probando endpoints...\n');

  for (let ep of endpoints) {
    try {
      const result = await request(ep.path, ep.method);
      const status = result.status === 200 ? '✓' : '✗';
      const code = result.status === 200 ? '200' : result.status;

      console.log(`${status} [${code}] ${ep.desc}`);
      console.log(`   ${ep.path}`);

      if (result.status === 200 && result.data && result.data.data) {
        if (Array.isArray(result.data.data)) {
          console.log(`   ➜ Array con ${result.data.data.length} elementos`);
        }
      }
      console.log();
    } catch (err) {
      console.log(`✗ ERROR: ${ep.desc}\n   ${err.message}\n`);
    }
  }

  console.log('📚 Limitaciones Importantes:');
  console.log('• NO puedes crear/editar flows via API');
  console.log('• Solo puedes disparar flows existentes');
  console.log('• Los flows se crean desde la interfaz web\n');

  console.log('🔗 Recursos:');
  console.log('• Docs oficiales: https://api.manychat.com/swagger');
  console.log('• Centro de ayuda: https://help.manychat.com');
}

main().catch(err => {
  console.error('Error:', err.message);
  process.exit(1);
});
