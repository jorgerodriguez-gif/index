const { chromium } = require('playwright');

(async () => {
  console.log('\n🌐 Abriendo Manychat...\n');

  const browser = await chromium.launch({ headless: false, slowMo: 200 });
  const page = await browser.newPage();

  await page.goto('https://app.manychat.com', { waitUntil: 'networkidle' });

  console.log('✓ Manychat abierto en el navegador\n');
  console.log('💡 Tips:');
  console.log('   - Busca "Automations" o "Automatizaciones" en el menú izquierdo');
  console.log('   - Busca por "TEST SALUDO" en la lista');
  console.log('   - Si no la ves, intenta buscar por fecha (5/22/2026)\n');
  console.log('El navegador permanecerá abierto. Presiona Ctrl+C para cerrar.\n');

  // Mantener abierto indefinidamente
  await new Promise(() => {});
})();
