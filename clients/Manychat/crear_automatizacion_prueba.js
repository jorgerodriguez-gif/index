const { chromium } = require('playwright');

/**
 * Crear Automatización de PRUEBA - SALUDO SIMPLE
 * Basado en lo que ves en tu navegador
 */

async function main() {
  console.log('\n🤖 Creando Automatización de PRUEBA...\n');

  const browser = await chromium.launch({ headless: false, slowMo: 400 });
  const page = await browser.newPage();

  try {
    // 1. Ir a Manychat
    console.log('📱 Navegando a Manychat...');
    await page.goto('https://app.manychat.com', { waitUntil: 'networkidle' });
    await page.waitForTimeout(3000);
    console.log('✓ En Manychat\n');

    // 2. Encontrar y click en "Automations"
    console.log('🔍 Buscando sección Automations...');
    const automationMenuSelectors = [
      'text=Automations',
      'text=Automation',
      'text=Automatizaciones',
      'a[href*="automation"]',
      'button:has-text("Automation")',
    ];

    let foundAutomations = false;
    for (const sel of automationMenuSelectors) {
      try {
        const elem = await page.locator(sel).first();
        const visible = await elem.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          console.log(`✓ Encontrado: "${sel}"`);
          await elem.click();
          await page.waitForTimeout(3000);
          foundAutomations = true;
          break;
        }
      } catch {}
    }

    console.log('✓ En sección Automations\n');
    await page.screenshot({ path: '1_automations_list.png' });

    // 3. Buscar y click en "nueva automatizacion" / "New"
    console.log('➕ Buscando botón "nueva automatizacion"...');
    const newButtonSelectors = [
      'button:has-text("nueva automatizacion")',
      'button:has-text("Nueva automatizacion")',
      'button:has-text("Nueva")',
      'button:has-text("New")',
      'button:has-text("Create")',
      'text=nueva automatizacion',
      'text=Nueva automatizacion',
    ];

    let clickedNew = false;
    for (const sel of newButtonSelectors) {
      try {
        const elem = await page.locator(sel).first();
        const visible = await elem.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          console.log(`✓ Botón encontrado`);
          await elem.click();
          await page.waitForTimeout(2000);
          clickedNew = true;
          console.log('✓ Diálogo abierto\n');
          break;
        }
      } catch {}
    }

    await page.screenshot({ path: '2_dialog_abierto.png' });

    // 4. Llenar el nombre de la automatización
    console.log('📝 Ingresando nombre de la automatización...');
    const automationName = `PRUEBA SALUDO ${new Date().toLocaleString()}`;

    // Buscar input y llenar
    const inputs = await page.locator('input, textarea').all();
    if (inputs.length > 0) {
      await inputs[0].fill(automationName);
      console.log(`✓ Nombre ingresado: "${automationName}"\n`);
    }

    await page.screenshot({ path: '3_nombre_ingresado.png' });

    // 5. Buscar botón para confirmar/crear
    console.log('✓ Buscando botón para crear...');
    const createSelectors = [
      'button:has-text("Create")',
      'button:has-text("Crear")',
      'button:has-text("Next")',
      'button:has-text("Siguiente")',
      'button:has-text("OK")',
      'button[type="submit"]',
    ];

    for (const sel of createSelectors) {
      try {
        const elem = await page.locator(sel).first();
        const visible = await elem.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          console.log(`✓ Click en crear...`);
          await elem.click();
          await page.waitForTimeout(3000);
          break;
        }
      } catch {}
    }

    await page.screenshot({ path: '4_automatizacion_creada.png' });

    // 6. Esperar a que se abra el editor
    console.log('✓ Esperando editor...\n');
    await page.waitForTimeout(2000);

    // 7. Agregar mensaje de saludo
    console.log('💬 Agregando mensaje de saludo...');

    // Buscar botón para agregar mensaje
    const addMessageSelectors = [
      'text=Add Message',
      'text=Agregar Mensaje',
      'text=Add',
      'text=Agregar',
      'button:has-text("Message")',
      'button:has-text("Add Block")',
    ];

    let messageAdded = false;
    for (const sel of addMessageSelectors) {
      try {
        const elem = await page.locator(sel).first();
        const visible = await elem.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          await elem.click();
          await page.waitForTimeout(1500);
          messageAdded = true;
          console.log(`✓ Bloque de mensaje abierto`);
          break;
        }
      } catch {}
    }

    // 8. Buscar textarea/input para el mensaje
    const messageText = '¡Hola! 👋\n\nEste es un mensaje de PRUEBA.\nBienvenido a nuestro bot automático.';

    const textareas = await page.locator('textarea, [contenteditable="true"]').all();
    if (textareas.length > 0) {
      await textareas[0].fill(messageText);
      console.log(`✓ Mensaje ingresado\n`);
    }

    await page.screenshot({ path: '5_mensaje_agregado.png' });

    // 9. Guardar la automatización
    console.log('💾 Guardando automatización...');

    const saveSelectors = [
      'button:has-text("Save")',
      'button:has-text("Guardar")',
      'button:has-text("Done")',
      'button:has-text("Listo")',
      'button[type="submit"]',
    ];

    for (const sel of saveSelectors) {
      try {
        const elem = await page.locator(sel).first();
        const visible = await elem.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          await elem.click();
          await page.waitForTimeout(2000);
          console.log(`✓ Guardado\n`);
          break;
        }
      } catch {}
    }

    await page.screenshot({ path: '6_guardado.png' });

    // 10. Confirmación
    console.log('════════════════════════════════════════');
    console.log('✅ AUTOMATIZACIÓN DE PRUEBA CREADA');
    console.log('════════════════════════════════════════\n');

    console.log(`📌 Nombre: ${automationName}`);
    console.log('📌 Mensaje: ¡Hola! Mensaje de PRUEBA');
    console.log('📌 Estado: Guardada\n');

    console.log('🔗 Screenshots guardados:');
    console.log('   - 1_automations_list.png');
    console.log('   - 2_dialog_abierto.png');
    console.log('   - 3_nombre_ingresado.png');
    console.log('   - 4_automatizacion_creada.png');
    console.log('   - 5_mensaje_agregado.png');
    console.log('   - 6_guardado.png\n');

    console.log('💡 Verifica en tu navegador que aparezca la nueva automatización\n');
    console.log('⏳ El navegador permanecerá abierto 30 segundos...\n');

    await page.waitForTimeout(30000);

  } catch (err) {
    console.error('❌ Error:', err.message);
    console.log('\n💡 Verifica los screenshots para debugging');
    await page.waitForTimeout(10000);
  } finally {
    await browser.close();
  }
}

main();
