# 🤖 Manychat Flow Builder

Automatiza la creación de flujos en Manychat usando Playwright para simular la interfaz web.

## 📋 Archivos

- **`manychat_flow_builder.js`** - Clase principal que automatiza Manychat
- **`flows_config.json`** - Configuración declarativa de flujos
- **`build_flows_from_config.js`** - Constructor que lee JSON y crea flujos
- **`manychat_connector.js`** - Conector API para Manychat
- **`manychat_diagnose.js`** - Diagnóstico de endpoints API

## 🚀 Quick Start

### 1. Usar el Flow Builder directamente

```bash
node manychat_flow_builder.js
```

Esto:
- Abre Manychat en el navegador
- Te pide que inicies sesión (manual con contraseña)
- Crea un flujo de ejemplo: "Mi Primer Flujo Automático"
- Agrega un mensaje de bienvenida
- Guarda el flujo

### 2. Construir flujos desde configuración JSON

```bash
node build_flows_from_config.js
```

Esto:
- Lee `flows_config.json`
- Crea cada flujo automáticamente
- Agrega los pasos definidos en el JSON
- Muestra progreso y resultados

## 📝 Configurar flujos en JSON

Edita `flows_config.json` para definir tus flujos:

```json
{
  "flows": [
    {
      "name": "Mi Flujo",
      "description": "Descripción del flujo",
      "trigger": "welcome",
      "steps": [
        {
          "type": "message",
          "text": "Hola, ¿cómo estás?"
        },
        {
          "type": "delay",
          "time": 3600
        },
        {
          "type": "message",
          "text": "¿En qué puedo ayudarte?"
        }
      ]
    }
  ]
}
```

## 📦 Tipos de Pasos

### `message`
Envía un mensaje de texto

```json
{
  "type": "message",
  "text": "Tu mensaje aquí",
  "delay": 0
}
```

### `action`
Ejecuta una acción (set field, capture field, etc.)

```json
{
  "type": "action",
  "action": "set_custom_field",
  "field": "nombre_campo",
  "value": "valor"
}
```

### `delay`
Espera un tiempo (en segundos)

```json
{
  "type": "delay",
  "time": 3600
}
```

## 🎯 Triggers Disponibles

- `welcome` - Mensaje de bienvenida
- `button_click` - Click en botón
- `custom_event` - Evento personalizado
- `email_received` - Email recibido
- `user_action` - Acción de usuario

## 🔧 Personalización

### Cambiar email de login

En `build_flows_from_config.js` o `manychat_flow_builder.js`:

```javascript
const builder = new ManychatFlowBuilder('tu-email@example.com');
```

### Cambiar velocidad de automatización

En `manychat_flow_builder.js`, línea 15:

```javascript
// slowMo: 500 = 500ms entre acciones
this.browser = await chromium.launch({ headless: false, slowMo: 500 });

// Aumentar para más lentitud (debugging):
this.browser = await chromium.launch({ headless: false, slowMo: 2000 });
```

### Headless (sin navegador visual)

```javascript
this.browser = await chromium.launch({ headless: true });
```

## 📸 Screenshots

Cada ejecución guarda screenshots:

- `flow_creation_dialog.png` - Diálogo de creación
- `flow_builder_open.png` - Builder abierto
- `trigger_selection.png` - Selección de trigger
- `flow_saved.png` - Flujo guardado
- `flows_list.png` - Lista final de flujos

## 🐛 Debugging

### Ver qué está pasando
El script abre el navegador con `headless: false` y `slowMo: 500`. Puedes ver en tiempo real qué hace.

### Si falla el login
- Verifica que tengas acceso a Google OAuth
- Revisa el `.env` tiene tu email correcto
- Asegúrate de tener conectividad a internet

### Si no encuentra elementos
El script intenta varios selectores. Si falla:
1. Abre Manychat manualmente
2. Inspecciona el elemento (DevTools)
3. Agrega el selector a las listas en `manychat_flow_builder.js`

## 📊 Flujos de Ejemplo

En `flows_config.json` hay 3 ejemplos:

1. **Welcome Flow** - Mensaje de bienvenida + set field
2. **Lead Capture Flow** - Capturar nombre y email
3. **Email Sequence Flow** - Secuencia con delays

## ⚡ Próximas Mejoras

- [ ] Agregar más tipos de pasos (buttons, images, etc.)
- [ ] Soporte para conditions (if/else)
- [ ] Exportar flujos a JSON
- [ ] Validación de configuración
- [ ] Rollback automático en caso de error
- [ ] Logs más detallados

## 📚 Recursos

- Docs oficiales: https://api.manychat.com/swagger
- Centro de ayuda: https://help.manychat.com
- Playwright: https://playwright.dev

## 💡 Tips

1. Empieza con un flujo simple
2. Usa screenshots para validar
3. Prueba la automatización manualmente primero
4. Incrementa `slowMo` si hay problemas de timing
5. Revisa los screenshots si algo falla
