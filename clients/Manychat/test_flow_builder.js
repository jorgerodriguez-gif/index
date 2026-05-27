#!/usr/bin/env node

/**
 * Test rápido del Flow Builder
 * Uso: node test_flow_builder.js
 */

const { ManychatFlowBuilder } = require('./manychat_flow_builder.js');

async function testBuilder() {
  console.log('\n🧪 TEST: Manychat Flow Builder\n');
  console.log('Este script probará la construcción básica de un flujo.\n');

  const builder = new ManychatFlowBuilder();

  try {
    // 1. Inicializar
    console.log('1️⃣  Inicializando builder...');
    await builder.initialize();
    console.log('   ✓ Builder listo\n');

    // 2. Navegar a flows
    console.log('2️⃣  Navegando a Flows...');
    await builder.navigateToFlows();
    console.log('   ✓ En sección Flows\n');

    // 3. Obtener lista actual
    console.log('3️⃣  Obteniendo flujos existentes...');
    const existingFlows = await builder.getFlowsList();
    console.log(`   ✓ Se encontraron ${existingFlows.length} flujos\n`);

    // 4. Crear nuevo flujo
    console.log('4️⃣  Creando flujo de prueba...');
    const testFlowName = `Test Flow - ${new Date().toLocaleTimeString()}`;
    await builder.createNewFlow(testFlowName);
    console.log('   ✓ Flujo creado\n');

    // 5. Agregar trigger
    console.log('5️⃣  Agregando trigger...');
    await builder.addTrigger('welcome');
    console.log('   ✓ Trigger agregado\n');

    // 6. Agregar mensaje
    console.log('6️⃣  Agregando mensaje...');
    await builder.addMessage('¡Hola! Este es un flujo de prueba automático.');
    console.log('   ✓ Mensaje agregado\n');

    // 7. Guardar
    console.log('7️⃣  Guardando flujo...');
    await builder.saveFlow();
    console.log('   ✓ Flujo guardado\n');

    // 8. Verificar
    console.log('8️⃣  Verificando flujos finales...');
    const finalFlows = await builder.getFlowsList();
    console.log(`   ✓ Total de flujos ahora: ${finalFlows.length}\n`);

    console.log('✅ TEST COMPLETADO EXITOSAMENTE\n');
    console.log('📋 Próximos pasos:');
    console.log('   1. Abre Manychat manualmente para verificar el flujo');
    console.log('   2. Edita flows_config.json con tus propios flujos');
    console.log('   3. Ejecuta: node build_flows_from_config.js\n');

  } catch (err) {
    console.error('\n❌ ERROR EN TEST:', err.message);
    console.error('\nDebugging info:');
    console.error('- ¿Iniciaste sesión correctamente?');
    console.error('- ¿El navegador se abrió?');
    console.error('- ¿Inspeccionaste los screenshots?');
    console.error(`\nArchivos de debug guardados:\n`);
    console.error('  - flow_creation_dialog.png');
    console.error('  - flow_builder_open.png');
    console.error('  - trigger_selection.png');
    console.error('  - flow_saved.png');
    console.error('  - flows_list.png\n');
  } finally {
    console.log('👋 Cerrando builder...\n');
    await builder.close();
  }
}

testBuilder();
