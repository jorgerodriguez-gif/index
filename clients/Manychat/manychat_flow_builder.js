const { chromium } = require('playwright');

/**
 * Manychat Flow Builder
 * Automatiza la creación de flujos en Manychat usando Playwright
 */

class ManychatFlowBuilder {
  constructor(email = 'jorge.rodriguez@freelan.com.mx') {
    this.email = email;
    this.browser = null;
    this.page = null;
  }

  async initialize() {
    console.log('🚀 Inicializando Manychat Flow Builder...\n');
    this.browser = await chromium.launch({ headless: false, slowMo: 500 });
    this.page = await this.browser.newPage();
    await this.login();
  }

  async login() {
    console.log('📧 Iniciando sesión en Manychat...');
    await this.page.goto('https://manychat.com/login', { waitUntil: 'networkidle' });

    // Esperar Cloudflare
    await this.page.waitForFunction(
      () => document.body.innerText.length > 100,
      { timeout: 20000 }
    ).catch(() => console.log('Página cargada.'));

    await this.page.waitForTimeout(3000);

    // Intentar varios selectores para el botón de Google
    const googleSelectors = [
      'text=Iniciar Sesión Con Google',
      'text=Sign in with Google',
      'button:has-text("Google")',
      'a:has-text("Google")',
      'button:has-text("Iniciar")',
      '[data-testid*="google"]',
    ];

    let googleClicked = false;
    for (const selector of googleSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        if (await element.isVisible({ timeout: 3000 }).catch(() => false)) {
          await element.click({ timeout: 5000 });
          googleClicked = true;
          console.log('✓ Botón de Google clickeado');
          break;
        }
      } catch {}
    }

    if (!googleClicked) {
      console.log('⚠️  No se encontró botón de Google automáticamente.');
      console.log('💡 Completa el login manualmente en el navegador.');
      console.log('   El script continuará después de que inicies sesión...\n');
    }

    await this.page.waitForTimeout(2000);

    try {
      // Esperar campo de email si apareció
      const emailField = await this.page.$('input[type="email"]').catch(() => null);
      if (emailField) {
        await this.page.fill('input[type="email"]', this.email);
        await this.page.keyboard.press('Enter');
        console.log('✓ Email ingresado');
        await this.page.waitForTimeout(2000);
      }

      console.log('\n⏳ Completa el login en el navegador...\n');

      // Esperar a dashboard (más tolerante)
      await this.page.waitForURL(/manychat\.com\/(dashboard|flow|automation|fb)/, { timeout: 120000 });
      console.log('✓ Sesión iniciada\n');
    } catch (err) {
      console.log('⚠️  Login manual completado');
    }
  }

  async navigateToFlows() {
    console.log('📂 Navegando a Flows...');
    const selectors = [
      'text=Flows',
      'text=Automation',
      'text=Automatización',
      'a[href*="flow"]',
      'a[href*="automation"]',
      'button:has-text("Flow")',
      '[data-testid*="flow"]',
    ];

    for (const selector of selectors) {
      try {
        const element = await this.page.locator(selector).first();
        if (await element.isVisible({ timeout: 2000 }).catch(() => false)) {
          await element.click({ timeout: 3000 });
          console.log(`✓ Navegado a Flows`);
          await this.page.waitForTimeout(2000);
          return;
        }
      } catch {}
    }
    console.warn('⚠️  No se pudo navegar a Flows automáticamente.');
    console.log('   Navega manualmente a la sección de Flows en el navegador.');
    await this.page.waitForTimeout(5000);
  }

  async createNewFlow(flowName) {
    console.log(`\n➕ Creando nuevo flujo: "${flowName}"\n`);

    // Buscar botón "New Flow" o "Create Flow"
    const newFlowSelectors = [
      'text=New Flow',
      'text=Create Flow',
      'text=Nuevo Flujo',
      'text=Crear Flujo',
      'button:has-text("New")',
      'button:has-text("Create")',
      '[data-testid*="new"]',
      'button:has-text("+")',
    ];

    let found = false;
    for (const selector of newFlowSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        if (await element.isVisible({ timeout: 2000 }).catch(() => false)) {
          await element.click({ timeout: 3000 });
          found = true;
          console.log('✓ Botón de nuevo flujo clickeado');
          break;
        }
      } catch {}
    }

    if (!found) {
      console.warn('⚠️  No se encontró botón para crear nuevo flujo.');
      console.log('   Crea un flujo manualmente en el navegador.');
      await this.page.waitForTimeout(10000);
    }

    await this.page.waitForTimeout(2000);
    await this.page.screenshot({ path: 'flow_creation_dialog.png' });

    // Llenar nombre del flujo
    console.log('📝 Ingresando nombre del flujo...');
    const nameInputSelectors = [
      'input[placeholder*="Flow name"]',
      'input[placeholder*="Nombre"]',
      'input[type="text"]',
      'input[placeholder*="flow"]',
    ];

    let nameInputFound = false;
    for (const selector of nameInputSelectors) {
      try {
        const input = await this.page.$(selector);
        if (input) {
          await input.fill(flowName);
          nameInputFound = true;
          console.log(`✓ Nombre "${flowName}" ingresado`);
          break;
        }
      } catch {}
    }

    if (!nameInputFound) {
      console.warn('⚠️  No se encontró input de nombre, continuando...');
    }

    // Click create/save
    const createButtonSelectors = [
      'text=Create',
      'text=Save',
      'text=Crear',
      'text=Guardar',
      'button:has-text("Create")',
      'button:has-text("Save")',
      'button:has-text("OK")',
    ];

    for (const selector of createButtonSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        if (await element.isVisible({ timeout: 2000 }).catch(() => false)) {
          await element.click({ timeout: 3000 });
          console.log('✓ Flujo creado');
          break;
        }
      } catch {}
    }

    await this.page.waitForTimeout(3000);
    await this.page.screenshot({ path: 'flow_builder_open.png' });
  }

  async addTrigger(triggerType = 'welcome') {
    console.log(`\n🔔 Agregando trigger: ${triggerType}\n`);

    // Buscar botón para agregar trigger
    const triggerSelectors = [
      'text=Add Trigger',
      'text=Agregar Trigger',
      'button:has-text("Trigger")',
      'text=Welcome Message',
      'text=Mensaje de Bienvenida',
    ];

    for (const selector of triggerSelectors) {
      try {
        await this.page.click(selector, { timeout: 3000 });
        console.log(`✓ Trigger selector clickeado`);
        break;
      } catch {}
    }

    await this.page.waitForTimeout(2000);
    await this.page.screenshot({ path: 'trigger_selection.png' });
  }

  async addMessage(messageText) {
    console.log(`\n💬 Agregando mensaje: "${messageText}"\n`);

    // Buscar área de texto para mensaje
    const messageSelectors = [
      'textarea[placeholder*="message"]',
      'textarea[placeholder*="Message"]',
      'textarea[placeholder*="Mensaje"]',
      'div[contenteditable="true"]',
      'textarea',
    ];

    for (const selector of messageSelectors) {
      const element = await this.page.$(selector);
      if (element) {
        await element.fill(messageText);
        console.log('✓ Mensaje agregado');
        await this.page.waitForTimeout(1000);
        return;
      }
    }

    console.warn('⚠️  No se encontró area de texto para mensaje');
  }

  async saveFlow() {
    console.log('\n💾 Guardando flujo...\n');

    const saveSelectors = [
      'text=Save',
      'text=Guardar',
      'button:has-text("Save")',
      'text=Done',
      'text=Listo',
    ];

    for (const selector of saveSelectors) {
      try {
        await this.page.click(selector, { timeout: 3000 });
        console.log('✓ Flujo guardado');
        break;
      } catch {}
    }

    await this.page.waitForTimeout(2000);
    await this.page.screenshot({ path: 'flow_saved.png' });
  }

  async getFlowsList() {
    console.log('\n📋 Obteniendo lista de flujos...\n');

    await this.navigateToFlows();

    // Capturar texto visible
    const flowsText = await this.page.evaluate(() => {
      const elements = document.querySelectorAll('[role="listitem"], li, tr, .flow-item, [data-testid*="flow"]');
      return Array.from(elements).map(el => el.innerText).filter(text => text.trim());
    });

    console.log('Flujos encontrados:');
    flowsText.forEach((flow, idx) => {
      console.log(`  ${idx + 1}. ${flow}`);
    });

    await this.page.screenshot({ path: 'flows_list.png' });
    return flowsText;
  }

  async close() {
    console.log('\n👋 Cerrando navegador...');
    if (this.browser) {
      await this.browser.close();
    }
  }
}

// Uso del builder
async function main() {
  const builder = new ManychatFlowBuilder();

  try {
    await builder.initialize();
    await builder.navigateToFlows();

    // Crear un flujo de ejemplo
    await builder.createNewFlow('Mi Primer Flujo Automático');

    // Agregar componentes
    await builder.addTrigger('welcome');
    await builder.addMessage('¡Hola! Bienvenido a mi bot.');

    // Guardar
    await builder.saveFlow();

    // Obtener lista de flujos
    await builder.getFlowsList();

    console.log('\n✅ Flujo creado exitosamente!\n');
    console.log('🔗 Abre Manychat en el navegador para verificar el nuevo flujo.');
    console.log('Presiona Ctrl+C para cerrar.');

    // Mantener abierto para que veas el resultado
    await new Promise(resolve => setTimeout(resolve, 30000));
  } catch (err) {
    console.error('❌ Error:', err.message);
  } finally {
    await builder.close();
  }
}

// Exportar para uso en otros archivos
module.exports = { ManychatFlowBuilder };

// Si se ejecuta directamente
if (require.main === module) {
  main();
}
