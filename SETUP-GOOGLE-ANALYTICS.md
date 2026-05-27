# 🔐 Configuración Google Analytics MCP

## Paso 1: Crear/Usar un Proyecto Google Cloud

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Si no tienes un proyecto, crea uno:
   - Click en "Seleccionar un proyecto" (arriba)
   - Click en "NUEVO PROYECTO"
   - Nombre: `Analytics Clients` (o tu preferencia)
   - Click "CREAR"

3. **Copia tu Project ID** (lo necesitarás después)

---

## Paso 2: Habilitar APIs

En Google Cloud Console, habilita estas 2 APIs:

### API 1: Google Analytics Admin API
1. Ve a https://console.cloud.google.com/apis/library/analyticsadmin.googleapis.com
2. Click en "HABILITAR"

### API 2: Google Analytics Data API
1. Ve a https://console.cloud.google.com/apis/library/analyticsdata.googleapis.com
2. Click en "HABILITAR"

---

## Paso 3: Crear Credenciales OAuth

1. En Google Cloud Console, ve a **"APIs & Services"** → **"Credenciales"**
2. Click en **"+ CREAR CREDENCIALES"** → **"OAuth client ID"**
3. Si aparece un aviso, primero configura la "pantalla de consentimiento":
   - Click en **"Configurar pantalla de consentimiento"**
   - Selecciona **"Externo"** (para acceso personal)
   - Click en **"CREAR"**
   - Rellena:
     - **App name**: `Analytics Clients`
     - **User support email**: `jorge.rodriguez@freelan.com.mx`
     - Click en **"GUARDAR Y CONTINUAR"**
   - En "Scopes", click en **"AÑADIR O QUITAR SCOPES"**
   - Busca y selecciona: `https://www.googleapis.com/auth/analytics.readonly`
   - Click en **"ACTUALIZAR"** y **"GUARDAR Y CONTINUAR"**
   - En "Usuarios de prueba", agrega tu correo: `jorge.rodriguez@freelan.com.mx`
   - Click en **"GUARDAR Y CONTINUAR"** → **"VOLVER AL PANEL"**

4. Ahora crea la credencial OAuth:
   - Click en **"+ CREAR CREDENCIALES"** → **"OAuth client ID"**
   - Tipo: **"Aplicación de escritorio"**
   - Nombre: `Analytics MCP`
   - Click en **"CREAR"**

5. **DESCARGA el archivo JSON**:
   - Click en el botón descargar (ícono ⬇️)
   - Guarda el archivo como: `~/google-analytics-credentials.json`

---

## Paso 4: Configurar Credenciales en tu Sistema

Ejecuta esto en terminal:

```bash
/opt/homebrew/bin/python3.12 -m venv ~/analytics-env
source ~/analytics-env/bin/activate
gcloud auth application-default login \
  --scopes https://www.googleapis.com/auth/analytics.readonly,https://www.googleapis.com/auth/cloud-platform \
  --client-id-file=~/google-analytics-credentials.json
```

El navegador se abrirá. Sigue los pasos de autorización.

---

## Paso 5: Verificar la Conexión

Ejecuta:

```bash
source ~/analytics-env/bin/activate
analytics-mcp
```

Si ves un mensaje similar a este, ¡está funcionando!:
```
MCP Server running on stdio
```

---

## Paso 6: Integración con Claude Code

Una vez que la autenticación funcione, necesitaremos integrar esto en Claude Code.

**Guarda tu Project ID para el siguiente paso:**
- Project ID: `YOUR_PROJECT_ID` (cópialo de Google Cloud Console)

---

## ¿Problemas?

- **Error "The user has not granted the Cloud SDK permission to access their Google Account"**: Vuelve al Paso 3 y asegúrate de haber dado el consentimiento
- **Error "analytics.readonly scope not found"**: Verifica que el scope esté exactamente como: `https://www.googleapis.com/auth/analytics.readonly`
- **Error de permisos**: Asegúrate de que tu correo tiene acceso a las cuentas de Google Analytics que quieres analizar

---

## Próximos Pasos

Una vez que la autenticación funcione, podemos:
1. Conectar tus propiedades de Google Analytics
2. Crear consultas personalizadas para análisis de clientes
3. Integrar esto en tus proyectos (Agentes, Datavision, Manychat)
