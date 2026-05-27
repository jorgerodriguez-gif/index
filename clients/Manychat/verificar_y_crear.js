const { chromium } = require('playwright');
const fs = require('fs');

async function main() {
  console.log('\n🔍 VERIFICACIÓN Y CREACIÓN REAL\n');

  const browser = await chromium.launch({ headless: false, slowMo: 300 });
  const page = await browser.newPage();

  try {
    // 1. Ir a Manychat Automations
    console.log('1️⃣  Navegando a Automations...');
    await page.goto('https://app.manychat.com', { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);

    // Hacer click en Automations
    try {
      await page.click('text=Automations');
      await page.waitForTimeout(3000);
    } catch {
      try {
        await page.click('text=Automatizaciones');
        await page.waitForTimeout(3000);
      } catch {}
    }

    // 2. Captura ANTES de crear
    console.log('2️⃣  Tomando captura ANTES de crear...');
    await page.screenshot({ path: 'ANTES_crear.png' });

    // 3. Inspeccionar HTML para ver automatizaciones existentes
    console.log('3️⃣  Inspeccionando automatizaciones existentes...');
    const automationsHTML = await page.evaluate(() => {
      const items = document.querySelectorAll('[role="listitem"], tr, .automation-item, li');
      return Array.from(items)
        .map(el => ({
          text: el.innerText?.substring(0, 100),
          html: el.className,
          tag: el.tagName
        }))
        .slice(0, 20);
    });

    console.log(`   Encontradas ${automationsHTML.length} automatizaciones:`);
    automationsHTML.forEach((a, i) => {
      console.log(`   ${i + 1}. ${a.text}`);
    });

    // 4. Buscar y clickear botón "Nueva"
    console.log('\n4️⃣  Buscando botón "nueva automatizacion"...');

    const buttonText = await page.evaluate(() => {
      const buttons = document.querySelectorAll('button');
      return Array.from(buttons)
        .map(b => b.innerText)
        .filter(t => t && t.length < 50);
    });

    console.log('   Botones disponibles:', buttonText.slice(0, 10));

    // Click en el botón
    try {
      await page.click('button:has-text("nueva automatizacion")');
      console.log('   ✓ Click en "nueva automatizacion"');
    } catch {
      try {
        const buttons = await page.locator('button').all();
        for (const btn of buttons) {
          const text = await btn.innerText();
          if (text.toLowerCase().includes('nueva') || text.toLowerCase().includes('create')) {
            await btn.click();
            console.log(`   ✓ Click en botón: "${text}"`);
            break;
          }
        }
      } catch (e) {
        console.log(`   ⚠️  Error: ${e.message}`);
      }
    }

    await page.waitForTimeout(2000);
    await page.screenshot({ path: 'DIALOG_abierto.png' });

    // 5. Llenar nombre
    console.log('\n5️⃣  Llenando nombre de la automatización...');
    const automationName = `TEST_PRUEBA_${Date.now()}`;

    // Encontrar todos los inputs
    const inputCount = await page.locator('input, textarea').count();
    console.log(`   Encontrados ${inputCount} inputs/textareas`);

    if (inputCount > 0) {
      const firstInput = page.locator('input, textarea').first();
      await firstInput.fill(automationName);
      console.log(`   ✓ Nombre ingresado: "${automationName}"`);
    }

    await page.screenshot({ path: 'NOMBRE_ingresado.png' });

    // 6. Click en botón Create/Crear
    console.log('\n6️⃣  Buscando botón Create...');

    try {
      const buttons = await page.locator('button').all();
      let clicked = false;
      for (const btn of buttons) {
        const text = await btn.innerText();
        if (text.toLowerCase().includes('create') ||
            text.toLowerCase().includes('crear') ||
            text.toLowerCase().includes('siguiente')) {
          await btn.click();
          console.log(`   ✓ Clicked: "${text}"`);
          clicked = true;
          await page.waitForTimeout(3000);
          break;
        }
      }
      if (!clicked) {
        console.log('   ⚠️  No se encontró botón create');
      }
    } catch (e) {
      console.log(`   ⚠️  Error: ${e.message}`);
    }

    await page.screenshot({ path: 'AUTOMATIZACION_creada.png' });

    // 7. Esperar y capturar
    console.log('\n7️⃣  Esperando a que cargue...');
    await page.waitForTimeout(3000);
    await page.screenshot({ path: 'EDITOR_abierto.png' });

    // 8. Inspeccionar si hay elementos de editor
    console.log('\n8️⃣  Verificando si se abrió el editor...');
    const editorElements = await page.evaluate(() => {
      return {
        textareas: document.querySelectorAll('textarea').length,
        contentEditable: document.querySelectorAll('[contenteditable]').length,
        buttons: document.querySelectorAll('button').length,
        title: document.title,
        url: window.location.href
      };
    });

    console.log(`   - Textareas: ${editorElements.textareas}`);
    console.log(`   - ContentEditable: ${editorElements.contentEditable}`);
    console.log(`   - Buttons: ${editorElements.buttons}`);
    console.log(`   - URL: ${editorElements.url}`);

    // 9. Guardar reporte
    const report = {
      timestamp: new Date().toISOString(),
      automationName,
      foundAutomations: automationsHTML.length,
      editorElements,
      screenshots: [
        'ANTES_crear.png',
        'DIALOG_abierto.png',
        'NOMBRE_ingresado.png',
        'AUTOMATIZACION_creada.png',
        'EDITOR_abierto.png'
      ]
    };

    fs.writeFileSync('verification_report.json', JSON.stringify(report, null, 2));
    console.log('\n✅ Reporte guardado: verification_report.json');

    // 10. MANTENER NAVEGADOR ABIERTO
    console.log('\n════════════════════════════════════════');
    console.log('🔍 NAVEGADOR ABIERTO PARA INSPECCIÓN');
    console.log('════════════════════════════════════════');
    console.log('\n📸 Screenshots guardados:');
    report.screenshots.forEach(s => console.log(`   - ${s}`));
    console.log('\n📋 Reporte: verification_report.json');
    console.log('\n⏳ El navegador permanecerá abierto indefinidamente');
    console.log('   (No se cerrará hasta que lo cierres manualmente)\n');
    console.log('💡 Puedes inspeccionar el navegador libremente.\n');

    // NUNCA CERRAR
    await new Promise(() => {});

  } catch (err) {
    console.error('\n❌ ERROR:', err.message);
    console.log('\n⏳ El navegador permanecerá abierto para debugging...\n');
    await new Promise(() => {});
  }
}

main();
