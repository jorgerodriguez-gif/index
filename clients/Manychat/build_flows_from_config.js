const fs = require('fs');
const path = require('path');
const { ManychatFlowBuilder } = require('./manychat_flow_builder.js');

/**
 * Lee flows_config.json y construye los flujos automáticamente
 */

class FlowConfigBuilder {
  constructor(configPath = './flows_config.json') {
    this.configPath = configPath;
    this.config = null;
    this.builder = null;
  }

  loadConfig() {
    console.log(`📖 Leyendo configuración: ${this.configPath}\n`);
    const rawData = fs.readFileSync(this.configPath, 'utf8');
    this.config = JSON.parse(rawData);
    console.log(`✓ Configuración cargada`);
    console.log(`  - ${this.config.flows.length} flujos definidos`);
    console.log(`  - Idioma: ${this.config.settings.language}`);
    console.log(`  - Timezone: ${this.config.settings.timezone}\n`);
  }

  async buildAllFlows() {
    this.loadConfig();
    this.builder = new ManychatFlowBuilder();

    try {
      await this.builder.initialize();

      for (let i = 0; i < this.config.flows.length; i++) {
        const flow = this.config.flows[i];
        console.log(`\n${'='.repeat(60)}`);
        console.log(`FLUJO ${i + 1}/${this.config.flows.length}: ${flow.name}`);
        console.log(`${'='.repeat(60)}`);
        console.log(`Descripción: ${flow.description}`);
        console.log(`Trigger: ${flow.trigger}`);
        console.log(`Pasos: ${flow.steps.length}\n`);

        try {
          await this.buildSingleFlow(flow);
          console.log(`✅ Flujo "${flow.name}" completado`);
        } catch (err) {
          console.error(`❌ Error en flujo "${flow.name}":`, err.message);
        }
      }

      console.log(`\n${'='.repeat(60)}`);
      console.log(`✅ CONSTRUCCIÓN COMPLETADA`);
      console.log(`${'='.repeat(60)}`);
      console.log(`Se construyeron ${this.config.flows.length} flujos.\n`);

      // Mostrar lista final de flujos
      const flows = await this.builder.getFlowsList();
      console.log('\n📋 FLUJOS FINALES:');
      flows.forEach((f, idx) => console.log(`  ${idx + 1}. ${f}`));

    } catch (err) {
      console.error('❌ Error crítico:', err.message);
    } finally {
      await this.builder.close();
    }
  }

  async buildSingleFlow(flowConfig) {
    // Crear flujo
    await this.builder.navigateToFlows();
    await this.builder.createNewFlow(flowConfig.name);

    // Agregar trigger
    if (flowConfig.trigger) {
      await this.builder.addTrigger(flowConfig.trigger);
    }

    // Agregar pasos
    console.log(`\nAgregando ${flowConfig.steps.length} pasos:`);
    for (let i = 0; i < flowConfig.steps.length; i++) {
      const step = flowConfig.steps[i];
      console.log(`  ${i + 1}. [${step.type.toUpperCase()}]`, step.text || step.action || '');

      switch (step.type) {
        case 'message':
          await this.builder.addMessage(step.text);
          if (step.delay) await new Promise(r => setTimeout(r, Math.min(step.delay, 3000)));
          break;

        case 'action':
          console.log(`     → Acción: ${step.action}`);
          break;

        case 'delay':
          console.log(`     → Espera: ${step.time / 60} minutos`);
          break;

        default:
          console.log(`     → Tipo no reconocido: ${step.type}`);
      }
    }

    // Guardar flujo
    await this.builder.saveFlow();
    console.log('✓ Flujo guardado');
  }
}

// Ejecutar
async function main() {
  console.log('🤖 Manychat Flow Config Builder\n');

  const builder = new FlowConfigBuilder('./flows_config.json');

  try {
    await builder.buildAllFlows();
  } catch (err) {
    console.error('Error fatal:', err);
    process.exit(1);
  }
}

main();
