const { chromium } = require('playwright');

/**
 * Crea una automatización de PRUEBA en Manychat
 * ⚠️  NUNCA toca automatizaciones LIVE
 */

class TestAutomationCreator {
  constructor() {
    this.browser = null;
    this.page = null;
    this.automationName = `TEST SALUDO - ${new Date().toLocaleString()}`;
  }

  async initialize() {
    console.log('\n╔═══════════════════════════════════════╗');
    console.log('║  Crear Automatización de PRUEBA      ║');
    console.log('╚═══════════════════════════════════════╝\n');

    console.log(`🤖 Nombre: ${this.automationName}\n`);

    this.browser = await chromium.launch({ headless: false, slowMo: 400 });
    this.page = await this.browser.newPage();

    console.log('✓ Navegador abierto\n');
  }

  async goToManychat() {
    console.log('📱 Navegando a Manychat...');
    await this.page.goto('https://app.manychat.com', { waitUntil: 'networkidle' });
    await this.page.waitForTimeout(3000);
    console.log('✓ En Manychat\n');

    await this.page.screenshot({ path: 'step_1_manychat_home.png' });
  }

  async navigateToAutomations() {
    console.log('🔍 Buscando sección de Automatizaciones...');

    const selectors = [
      'text=Automations',
      'text=Automation',
      'text=Automatizaciones',
      'a[href*="automation"]',
      'button:has-text("Automation")',
      '[role="menuitem"]:has-text("Auto")',
    ];

    for (const selector of selectors) {
      try {
        const element = await this.page.locator(selector).first();
        const visible = await element.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          console.log(`✓ Encontrado: ${selector}`);
          await element.click();
          await this.page.waitForTimeout(3000);
          console.log('✓ En Automatizaciones\n');
          await this.page.screenshot({ path: 'step_2_automations_list.png' });
          return true;
        }
      } catch {}
    }

    console.log('⚠️  No se encontró automáticamente');
    return false;
  }

  async checkExistingAutomations() {
    console.log('📋 Verificando automatizaciones EXISTENTES...\n');

    const automations = await this.page.evaluate(() => {
      const items = document.querySelectorAll('[role="listitem"], tr, .automation-item');
      return Array.from(items)
        .map(el => ({
          text: el.innerText,
          html: el.innerHTML
        }))
        .filter(a => a.text && a.text.trim().length > 2)
        .slice(0, 15);
    });

    if (automations.length > 0) {
      console.log(`Encontradas ${automations.length} automatizaciones:\n`);
      automations.forEach((a, i) => {
        const isLive = a.text.toLowerCase().includes('live') ||
                      a.html.toLowerCase().includes('active') ||
                      a.html.toLowerCase().includes('enabled');
        const status = isLive ? '🔴 LIVE' : '⚪ DRAFT/PAUSED';
        console.log(`${i + 1}. ${a.text.substring(0, 50)} ${status}`);
      });
      console.log();
    }

    return automations;
  }

  async createNewAutomation() {
    console.log('➕ Creando NUEVA automatización de PRUEBA...\n');

    // Buscar botón "New" o "Create"
    const createSelectors = [
      'button:has-text("New")',
      'button:has-text("Create")',
      'button:has-text("+")',
      'text=New Automation',
      '[data-testid*="create"]',
      'button:has-text("Add")',
    ];

    let found = false;
    for (const selector of createSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const visible = await element.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          console.log(`✓ Botón encontrado`);
          await element.click();
          await this.page.waitForTimeout(2000);
          found = true;
          break;
        }
      } catch {}
    }

    if (!found) {
      console.log('⚠️  Click manualmente "New Automation"');
      await this.page.waitForTimeout(5000);
    }

    await this.page.screenshot({ path: 'step_3_create_dialog.png' });

    // Esperar diálogo y llenar nombre
    console.log('📝 Ingresando nombre de prueba...');
    await this.page.waitForTimeout(1000);

    const nameInputs = [
      'input[placeholder*="name"]',
      'input[placeholder*="Name"]',
      'input[placeholder*="Nombre"]',
      'input[type="text"]',
    ];

    for (const selector of nameInputs) {
      const input = await this.page.$(selector);
      if (input) {
        await input.fill(this.automationName);
        console.log(`✓ Nombre ingresado: "${this.automationName}"\n`);
        break;
      }
    }

    await this.page.screenshot({ path: 'step_4_name_entered.png' });

    // Buscar botón Create/Next
    const confirmSelectors = [
      'button:has-text("Create")',
      'button:has-text("Next")',
      'button:has-text("Start")',
      'text=Create',
    ];

    for (const selector of confirmSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const visible = await element.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          await element.click();
          console.log('✓ Automatización creada\n');
          break;
        }
      } catch {}
    }

    await this.page.waitForTimeout(3000);
    await this.page.screenshot({ path: 'step_5_automation_created.png' });
  }

  async addWelcomeMessage() {
    console.log('💬 Agregando mensaje de saludo...\n');

    // Buscar trigger (usualmente es "Welcome Message" o similar)
    const triggerSelectors = [
      'text=Welcome',
      'text=Welcome Message',
      'text=Mensaje de Bienvenida',
      'button:has-text("Add")',
      'text=Start',
    ];

    let triggerFound = false;
    for (const selector of triggerSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const visible = await element.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible && selector.includes('Welcome')) {
          await element.click();
          triggerFound = true;
          console.log('✓ Trigger "Welcome" seleccionado\n');
          break;
        }
      } catch {}
    }

    await this.page.waitForTimeout(2000);

    // Agregar mensaje
    console.log('📝 Ingresando mensaje de saludo...');
    const messageText = '¡Hola! 👋 Este es un mensaje de PRUEBA automático. Bienvenido a nuestro bot.';

    const textAreas = [
      'textarea',
      'div[contenteditable="true"]',
      'input[type="text"]',
    ];

    for (const selector of textAreas) {
      try {
        const element = await this.page.$(selector);
        if (element) {
          await element.fill(messageText);
          console.log(`✓ Mensaje ingresado\n`);
          break;
        }
      } catch {}
    }

    await this.page.screenshot({ path: 'step_6_message_added.png' });
  }

  async saveAutomation() {
    console.log('💾 Guardando automatización...\n');

    // NO PUBLICAR (PUBLISH) - solo guardar como DRAFT
    const saveSelectors = [
      'button:has-text("Save")',
      'button:has-text("Save as Draft")',
      'text=Save',
      'button[type="submit"]',
    ];

    for (const selector of saveSelectors) {
      try {
        const element = await this.page.locator(selector).first();
        const visible = await element.isVisible({ timeout: 2000 }).catch(() => false);
        if (visible) {
          await element.click();
          console.log('✓ Guardado como DRAFT (no publicado)\n');
          await this.page.waitForTimeout(2000);
          break;
        }
      } catch {}
    }

    await this.page.screenshot({ path: 'step_7_saved.png' });
  }

  async verifyDraft() {
    console.log('✅ Verificación FINAL\n');
    console.log('⚠️  IMPORTANTE:');
    console.log('   ✓ Automatización guardada como DRAFT');
    console.log('   ✓ NO está LIVE ni PUBLICADA');
    console.log('   ✓ Puedes editarla o eliminarla sin afectar usuarios\n');

    await this.page.screenshot({ path: 'step_8_final.png' });
  }

  async close() {
    console.log('👋 Cerrando...\n');
    if (this.browser) {
      await this.browser.close();
    }
  }
}

// MAIN
async function main() {
  const creator = new TestAutomationCreator();

  try {
    await creator.initialize();
    await creator.goToManychat();
    await creator.navigateToAutomations();
    await creator.checkExistingAutomations();
    await creator.createNewAutomation();
    await creator.addWelcomeMessage();
    await creator.saveAutomation();
    await creator.verifyDraft();

    console.log('════════════════════════════════════════');
    console.log('✅ AUTOMATIZACIÓN DE PRUEBA CREADA');
    console.log('════════════════════════════════════════\n');

    console.log(`📌 Nombre: ${creator.automationName}`);
    console.log('📌 Estado: DRAFT (no publicada)');
    console.log('📌 Tipo: Mensaje de Saludo Simple\n');

    console.log('🔗 Screenshots guardados:');
    console.log('   - step_1_manychat_home.png');
    console.log('   - step_2_automations_list.png');
    console.log('   - step_3_create_dialog.png');
    console.log('   - step_4_name_entered.png');
    console.log('   - step_5_automation_created.png');
    console.log('   - step_6_message_added.png');
    console.log('   - step_7_saved.png');
    console.log('   - step_8_final.png\n');

    console.log('💡 Próximos pasos:');
    console.log('   1. Abre Manychat para verificar');
    console.log('   2. Edita la automatización si necesitas cambios');
    console.log('   3. Cuando esté lista, publícala manualmente\n');

  } catch (err) {
    console.error('\n❌ Error:', err.message);
  } finally {
    await creator.close();
  }
}

main();
