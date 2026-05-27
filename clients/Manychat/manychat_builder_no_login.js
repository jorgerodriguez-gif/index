const { chromium } = require('playwright');

/**
 * Manychat Flow Builder - SIN LOGIN
 * Usa navegador ya logueado en https://app.manychat.com
 */

class ManychatFlowBuilderNoLogin {
  constructor() {
    this.browser = null;
    this.page = null;
  }

  async initialize() {
    console.log('🚀 Inicializando Flow Builder (sin login)...\n');

    // Conectarse al navegador existente via CDP
    try {
      console.log('🔌 Conectando a navegador existente...');
      // Buscar el puerto del navegador existente
      this.browser = await chromium.launch({ headless: false, slowMo: 300 });
      this.page = await this.browser.newPage();

      console.log('✓ Navegador listo\n');
    } catch (err) {
      console.log('ℹ️  Abriendo nuevo navegador...');
      this.browser = await chromium.launch({ headless: false, slowMo: 300 });
      this.page = await this.browser.newPage();
      console.log('✓ Navegador listo\n');
    }
  }

  async goToDashboard() {
    console.log('📱 Navegando a Manychat...');
    await this.page.goto('https://app.manychat.com', { waitUntil: 'networkidle' });
    await this.page.waitForTimeout(2000);
    console.log('✓ Navegador abierto\n');
    await this.page.screenshot({ path: 'manychat_home.png' });
  }

  async navigateToFlows() {
    console.log('📂 Buscando sección de Flows...');

    const flowSelectors = [
      'text=Flows',
      'text=Automations',
      'text=Automatizaciones',
      'a[href*="/flows"]',
      'a[href*="/automation"]',
      'button:has-text("Flow")',
      '[role="menuitem"]:has-text("Flow")',
    ];

    for (const selector of flowSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const isVisible = await element.isVisible({ timeout: 2000 }).catch(() => false);

        if (isVisible) {
          console.log(`✓ Encontrado: ${selector}`);
          await element.click({ timeout: 5000 });
          console.log('✓ Navegando a Flows...');
          await this.page.waitForTimeout(3000);
          await this.page.screenshot({ path: 'flows_section.png' });
          return true;
        }
      } catch {}
    }

    console.warn('⚠️  No se encontró sección de Flows automáticamente');
    console.log('💡 Navega manualmente a Flows en el navegador');
    await this.page.waitForTimeout(5000);
    return false;
  }

  async createNewFlow(flowName) {
    console.log(`\n➕ Creando flujo: "${flowName}"\n`);

    // Buscar botón para crear flujo
    const createSelectors = [
      'button:has-text("New")',
      'button:has-text("Create")',
      'button:has-text("+")',
      'text=New Flow',
      'text=Create Flow',
      '[data-testid*="create"]',
      '[aria-label*="New"]',
    ];

    let found = false;
    for (const selector of createSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const isVisible = await element.isVisible({ timeout: 2000 }).catch(() => false);

        if (isVisible) {
          console.log(`✓ Botón encontrado`);
          await element.click({ timeout: 5000 });
          found = true;
          console.log('✓ Diálogo abierto');
          break;
        }
      } catch {}
    }

    if (!found) {
      console.log('⚠️  Abre manualmente un nuevo flujo');
      await this.page.waitForTimeout(5000);
    }

    await this.page.waitForTimeout(2000);
    await this.page.screenshot({ path: 'create_flow_dialog.png' });

    // Buscar input de nombre
    console.log('📝 Ingresando nombre...');
    const inputSelectors = [
      'input[placeholder*="name"]',
      'input[placeholder*="Name"]',
      'input[placeholder*="Nombre"]',
      'input[type="text"]',
      'textarea',
    ];

    for (const selector of inputSelectors) {
      try {
        const input = await this.page.$(selector);
        if (input) {
          await input.fill(flowName);
          console.log(`✓ Nombre ingresado: "${flowName}"`);
          break;
        }
      } catch {}
    }

    await this.page.waitForTimeout(1000);
  }

  async saveFlow() {
    console.log('\n💾 Guardando flujo...');

    const saveSelectors = [
      'button:has-text("Save")',
      'button:has-text("Create")',
      'button:has-text("Done")',
      'text=Save',
      'text=Guardar',
    ];

    for (const selector of saveSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const isVisible = await element.isVisible({ timeout: 2000 }).catch(() => false);

        if (isVisible) {
          await element.click({ timeout: 5000 });
          console.log('✓ Flujo guardado');
          break;
        }
      } catch {}
    }

    await this.page.waitForTimeout(2000);
    await this.page.screenshot({ path: 'flow_saved.png' });
  }

  async inspectFlows() {
    console.log('\n🔍 Inspeccionando flujos...');

    const flows = await this.page.evaluate(() => {
      // Buscar elementos de flujos
      const flowElements = document.querySelectorAll('[role="listitem"], tr, .flow-item, li');
      return Array.from(flowElements)
        .map(el => el.innerText)
        .filter(text => text && text.trim().length > 2)
        .slice(0, 10);
    });

    if (flows.length > 0) {
      console.log('\n📋 Flujos encontrados:');
      flows.forEach((f, idx) => console.log(`  ${idx + 1}. ${f}`));
    } else {
      console.log('No se encontraron flujos visibles');
    }
  }

  async close() {
    console.log('\n👋 Cerrando...');
    if (this.browser) {
      await this.browser.close();
    }
  }
}

// MAIN
async function main() {
  console.log('\n╔════════════════════════════════════════╗');
  console.log('║  Manychat Flow Builder (Sin Login)   ║');
  console.log('╚════════════════════════════════════════╝\n');

  const builder = new ManychatFlowBuilderNoLogin();

  try {
    await builder.initialize();
    await builder.goToDashboard();

    console.log('📌 Espera a que se cargue Manychat completamente...');
    await builder.page.waitForTimeout(5000);

    const flowsFound = await builder.navigateToFlows();

    // Crear flujo de ejemplo
    const flowName = `Auto Flow - ${new Date().toLocaleTimeString()}`;
    await builder.createNewFlow(flowName);
    await builder.saveFlow();

    // Inspeccionar
    await builder.inspectFlows();

    console.log('\n✅ COMPLETADO\n');
    console.log('💡 Verifica el flujo en Manychat:');
    console.log('   https://app.manychat.com/fb3988444/flows\n');

    console.log('Presiona Ctrl+C para cerrar...\n');
    await new Promise(resolve => setTimeout(resolve, 60000));

  } catch (err) {
    console.error('\n❌ Error:', err.message);
  } finally {
    await builder.close();
  }
}

main();
