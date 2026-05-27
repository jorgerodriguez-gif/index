const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: false, slowMo: 500 });
  const page = await browser.newPage();

  console.log('Abriendo Manychat...');
  await page.goto('https://manychat.com/login');

  // Esperar a que Cloudflare pase (hasta 15 segundos)
  console.log('Esperando verificación de Cloudflare...');
  await page.waitForFunction(
    () => document.querySelector('button, a[href]') !== null && !document.body.innerText.includes('Verificando'),
    { timeout: 15000 }
  ).catch(() => console.log('Cloudflare tardó, continuando de todas formas...'));

  await page.waitForTimeout(2000);

  // Click en "Iniciar Sesión Con Google"
  await page.waitForSelector('text=Iniciar Sesión Con Google', { timeout: 15000 });
  await page.click('text=Iniciar Sesión Con Google');
  console.log('Botón de Google clickeado.');

  // Esperar la pantalla de Google con el campo de email
  try {
    await page.waitForSelector('input[type="email"]', { timeout: 15000 });
    await page.fill('input[type="email"]', 'jorge.rodriguez@freelan.com.mx');
    await page.keyboard.press('Enter');
    console.log('Email ingresado. Ingresa tu contraseña en el navegador.');
  } catch {
    console.log('No se encontró campo de email. Es posible que ya estés en la pantalla de contraseña.');
  }

  // Esperar a que cargue el dashboard (hasta 90 segundos para login manual)
  console.log('\n>>> Ingresa tu contraseña en el navegador y el script continuará automáticamente.\n');

  try {
    await page.waitForURL(/manychat\.com\/(dashboard|flow|automation|fb)/, { timeout: 90000 });
  } catch {
    await page.waitForTimeout(5000);
  }

  console.log('Sesión iniciada. URL actual:', page.url());
  await page.screenshot({ path: 'dashboard.png' });

  // Navegar a Flows
  await page.waitForTimeout(2000);
  const flowsLinks = [
    'text=Flows',
    'text=Flow',
    'text=Automation',
    'text=Automatización',
    'a[href*="flow"]',
    'a[href*="automation"]',
  ];

  for (const selector of flowsLinks) {
    try {
      await page.click(selector, { timeout: 3000 });
      console.log(`Navegando a flows con: ${selector}`);
      break;
    } catch {}
  }

  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'flows-page.png' });

  // Buscar el flujo "flujo para pruebas"
  console.log('Buscando "flujo para pruebas"...');
  try {
    await page.waitForSelector('text=/flujo para pruebas/i', { timeout: 10000 });
    await page.click('text=/flujo para pruebas/i');
    console.log('Flujo encontrado y abierto.');
  } catch {
    const searchInput = await page.$('input[placeholder*="Search"], input[placeholder*="Buscar"], input[type="search"]');
    if (searchInput) {
      await searchInput.fill('flujo para pruebas');
      await page.waitForTimeout(1500);
      try {
        await page.click('text=/flujo para pruebas/i', { timeout: 5000 });
      } catch {
        console.log('No se encontró el flujo. Revisa el screenshot.');
      }
    }
  }

  await page.waitForTimeout(3000);
  await page.screenshot({ path: 'flujo-pruebas.png', fullPage: true });
  console.log('\nScreenshot del flujo guardado: flujo-pruebas.png');

  // Capturar texto visible
  const pageText = await page.evaluate(() => document.body.innerText);
  const lines = pageText.split('\n').filter(l => l.trim().length > 5).slice(0, 100);
  console.log('\n--- Contenido visible ---');
  lines.forEach(l => console.log(l));

  console.log('\nPresiona Ctrl+C para cerrar...');
  await page.waitForTimeout(60000);
  await browser.close();
})();
