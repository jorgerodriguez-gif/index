#!/usr/bin/env node

/**
 * GUÍA MANUAL para crear la automatización de PRUEBA
 * Sigue los pasos que te proporciona el script
 */

const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function question(prompt) {
  return new Promise(resolve => rl.question(prompt, resolve));
}

async function main() {
  console.log('\n╔════════════════════════════════════════════╗');
  console.log('║  CREAR AUTOMATIZACIÓN DE PRUEBA - MANUAL  ║');
  console.log('╚════════════════════════════════════════════╝\n');

  console.log('📋 INSTRUCCIONES PASO A PASO:\n');

  // PASO 1
  console.log('🔵 PASO 1: Localizar "Automations" o "Automatizaciones"');
  console.log('   └─ Busca en el menú LEFT side (izquierda)');
  console.log('   └─ O busca el ícono de engranaje ⚙️\n');
  await question('   ✓ Presiona ENTER cuando llegues a la sección...');

  // PASO 2
  console.log('\n🟢 PASO 2: Buscar botón "New" o "Create"');
  console.log('   └─ Debería estar en la esquina superior derecha o izquierda');
  console.log('   └─ Puede decir "New Automation", "Create", o "+"');
  console.log('   └─ Si no lo ves, intenta hacer scroll\n');
  await question('   ✓ Click en el botón NUEVO...');

  // PASO 3
  console.log('\n🟡 PASO 3: Deberías ver un DIÁLOGO para crear');
  console.log('   └─ Generalmente pide el nombre de la automatización');
  console.log('   └─ Input de texto: "What will this automation do?"\n');
  const name = await question('   Ingresa el nombre (o presiona ENTER para "TEST PRUEBA"): ');
  const automationName = name.trim() || 'TEST PRUEBA - ' + new Date().toLocaleString();
  console.log(`\n   ✓ Usando nombre: "${automationName}"`);

  // PASO 4
  console.log('\n🟠 PASO 4: Busca un botón "Create", "Next" o "Start"');
  console.log('   └─ Click en ese botón para crear la automatización\n');
  await question('   ✓ Click cuando esté listo...');

  // PASO 5
  console.log('\n🔴 PASO 5: Debería abrirse el BUILDER (editor visual)');
  console.log('   └─ Verás bloques, flujos, mensajes');
  console.log('   └─ Busca algo como "Welcome Message" o "Add Block"\n');
  await question('   ✓ Presiona ENTER cuando veas el editor...');

  // PASO 6
  console.log('\n🟣 PASO 6: Agregar MENSAJE de saludo');
  console.log('   └─ Busca botón "Add Message" o "Add Block"');
  console.log('   └─ O haz click en un bloque existente\n');
  const message = await question('   Mensaje de saludo (presiona ENTER para default): ');
  const greetingMsg = message.trim() || '¡Hola! 👋 Este es un mensaje de PRUEBA automático.';
  console.log(`\n   ✓ Mensaje: "${greetingMsg}"`);

  // PASO 7
  console.log('\n🎯 PASO 7: GUARDAR la automatización');
  console.log('   └─ Busca botón "Save" o "Save as Draft"');
  console.log('   └─ ⚠️  NO hagas click en "Publish" (eso la haría LIVE)\n');
  await question('   ✓ Click en SAVE...');

  // PASO 8
  console.log('\n✅ PASO 8: VERIFICACIÓN');
  console.log('   └─ La automatización debería estar guardada');
  console.log('   └─ Debería aparecer en la lista de Automatizaciones\n');
  await question('   ✓ Presiona ENTER cuando veas que está creada...');

  // RESUMEN
  console.log('\n╔════════════════════════════════════════════╗');
  console.log('║  ✅ AUTOMATIZACIÓN DE PRUEBA CREADA      ║');
  console.log('╚════════════════════════════════════════════╝\n');

  console.log(`📌 Nombre: "${automationName}"`);
  console.log(`💬 Mensaje: "${greetingMsg}"`);
  console.log('📍 Estado: DRAFT (no publicada)\n');

  console.log('🎯 Próximos pasos:');
  console.log('   1. Pruébala enviando un mensaje en tu chat');
  console.log('   2. Si funciona bien, publícala manualmente');
  console.log('   3. Si quieres cambios, edítala desde aquí\n');

  console.log('💡 Para crear más automatizaciones:');
  console.log('   $ node create_automation_manual_guide.js\n');

  rl.close();
}

main().catch(console.error);
