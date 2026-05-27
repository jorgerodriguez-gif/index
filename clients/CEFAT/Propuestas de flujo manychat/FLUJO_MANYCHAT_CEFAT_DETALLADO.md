# 🤖 FLUJO MANYCHAT CEFAT - DETALLADO Y SIMPLIFICADO

## 📋 ESTRUCTURA GENERAL

```
DISPARADOR (Palabras clave)
    ↓
VALIDACIÓN (¿Contacto conocido?)
    ↓
    ├─ SÍ → MENSAJE BIENVENIDA RETORNO
    └─ NO → MENSAJE BIENVENIDA NUEVO
    ↓
CATEGORIZACIÓN (¿Qué te interesa?)
    ↓
    ├─ CURSOS
    ├─ TALLERES
    ├─ CARRERAS
    └─ OTRO
    ↓
CAPTURA DE DATOS (Según categoría)
    ↓
ESCALADA O AGENDAMIENTO
```

---

## 1️⃣ DISPARADORES (Punto de Entrada)

### Palabras clave para activar el flujo:
```
• "hola"
• "buenas"
• "cursos"
• "taller"
• "carrera"
• "diplomado"
• "información"
• "precio"
• "horarios"
• "actuación"
• "cine"
• "tv"
• "formación"
```

**¿Cuándo se activa?** Cuando un usuario envía un mensaje inicial con estas palabras en WhatsApp/Facebook/Instagram que está vinculado a la página de CEFAT.

---

## 2️⃣ VALIDACIÓN INICIAL (¿Contacto Conocido?)

### Condición a Verificar:
- ¿Existe registro de email del contacto en HubSpot?
- ¿Ha interactuado antes con CEFAT?

### Rama SÍ: CONTACTO CONOCIDO
**Mensaje de Bienvenida Retorno:**

```
¡Hola [NOMBRE]! 👋

Nos alegra verte de vuelta por CEFAT.

¿En qué te podemos ayudar hoy?

1️⃣ Tengo duda sobre un curso
2️⃣ Quiero información de programas
3️⃣ Actualización de datos
4️⃣ Otra consulta
```

### Rama NO: CONTACTO NUEVO
**Mensaje de Bienvenida Nuevo:**

```
¡Hola! 👋 Bienvenido a CEFAT

Somos el Centro de Formación Actoral de TV Azteca.
Ofrecemos cursos, talleres y carreras profesionales en:
📽️ Actuación | 💡 Televisión | 🎬 Cine

¿Cuál es tu interés?

1️⃣ Cursos
2️⃣ Talleres
3️⃣ Carreras profesionales
4️⃣ Consultoría
```

---

## 3️⃣ RAMIFICACIÓN 1: CATEGORIZACIÓN (¿Qué quieres?)

### Opción 1️⃣: CURSOS
**Mensaje Automático:**

```
Excelente, te compartimos nuestros cursos 👇

📌 CURSOS DISPONIBLES:

📚 Actuación Básica (4 semanas)
Inicio: Próximo lunes | $2,500

📚 Técnica de Cámara (6 semanas)
Inicio: Próximo lunes | $3,000

📚 Guión para TV (8 semanas)
Inicio: 2 de Junio | $3,500

¿Cuál te interesa?
Responde con el número (1, 2, 3) o escribe "MÁS INFO"
```

**Datos a Capturar:**
- ✅ Nombre (ya existe)
- ✅ Email
- ✅ Teléfono
- ✅ Curso seleccionado
- ✅ Fecha de inicio preferida
- ✅ Presupuesto

---

### Opción 2️⃣: TALLERES
**Mensaje Automático:**

```
¡Perfecto! Te compartimos nuestros talleres 👇

🎯 TALLERES INTENSIVOS (4 horas)

🎬 Taller: Composición de Escenas
📅 Sábado 25 de Mayo | 10:00 AM
💰 $500 por asistente
👥 Máx. 12 personas

🎬 Taller: Manejo de Cámara 4K
📅 Domingo 26 de Mayo | 2:00 PM
💰 $500 por asistente
👥 Máx. 12 personas

🎬 Taller: Producción Audiovisual
📅 Próximo Martes | 6:00 PM
💰 $800 por asistente
👥 Máx. 15 personas

¿Cuál te llama más la atención?
Responde: "Composición", "Cámara 4K" o "Producción"
```

**Datos a Capturar:**
- ✅ Nombre
- ✅ Email
- ✅ Teléfono
- ✅ Taller seleccionado
- ✅ Número de asistentes
- ✅ Experiencia previa (¿Tienes experiencia?)

---

### Opción 3️⃣: CARRERAS PROFESIONALES
**Mensaje Automático:**

```
¡Excelente opción! Aquí nuestras carreras 👇

🎓 CARRERAS PROFESIONALES (1-2 años)

👉 Carrera: Actuación para Cine y TV
Duración: 18 meses
Inversión: $18,000 (18 meses)
Próximo inicio: 1 de Julio

👉 Carrera: Producción Audiovisual
Duración: 12 meses
Inversión: $12,000 (12 meses)
Próximo inicio: 15 de Junio

👉 Carrera: Dirección de Fotografía
Duración: 18 meses
Inversión: $20,000 (18 meses)
Próximo inicio: 1 de Julio

¿Cuál carrera te interesa?
Responde: "Actuación", "Producción" o "Fotografía"
```

**Datos a Capturar:**
- ✅ Nombre
- ✅ Email
- ✅ Teléfono
- ✅ Carrera seleccionada
- ✅ Experiencia actual (¿Nivel?)
- ✅ Disponibilidad de tiempo (Tiempo completo/parcial)
- ✅ Modalidad (Presencial/Híbrida)

---

### Opción 4️⃣: CONSULTORÍA
**Mensaje Automático:**

```
¡Interesante! Servicios de consultoría 👇

💼 SERVICIOS DE CONSULTORÍA

🎯 Asesoría en Proyectos Audiovisuales
Duración: Variable (1-3 meses)
Inversión: Consultar
Incluye: Evaluación + Plan de acción

🎯 Mentoría Personalizada
Duración: 3-6 meses (sesiones semanales)
Inversión: $3,500 por mes
Incluye: 4 sesiones/mes + seguimiento

¿Qué tipo de consultoría necesitas?
Responde: "Proyectos" o "Mentoría"

O cuéntanos brevemente tu necesidad 👇
```

**Datos a Capturar:**
- ✅ Nombre
- ✅ Email
- ✅ Teléfono
- ✅ Tipo de consultoría
- ✅ Breve descripción del proyecto/necesidad
- ✅ Presupuesto estimado
- ✅ Timeline (cuándo necesitas ayuda)

---

## 4️⃣ FLUJO SIMPLIFICADO POR CATEGORÍA

### 📚 FLUJO CURSOS (MÁS SIMPLE)

```
Usuario selecciona: CURSOS
        ↓
Mostrar opciones (3 cursos principales)
        ↓
¿Usuario selecciona uno?
        ↓
SÍ → Preguntar: ¿Nombre completo?
        ↓
    Preguntar: ¿Correo?
        ↓
    Preguntar: ¿Teléfono?
        ↓
    Preguntar: ¿Cuándo inicias? (Próximo lunes / después)
        ↓
    ✅ CONFIRMACIÓN:
    "Perfecto, [NOMBRE]. Hemos registrado tu interés en 
    [CURSO]. Nuestro asesor se contactará en 24 hrs.
    
    Mientras tanto, descarga nuestro catálogo:
    [LINK PDF]"
        ↓
    TAG: "prospecto-curso"
    ↓
    NOTIFICACIÓN AL EQUIPO CEFAT
    ↓
    FIN DEL FLUJO
```

---

### 🎯 FLUJO TALLERES (MÁS SIMPLE)

```
Usuario selecciona: TALLERES
        ↓
Mostrar opciones (3 talleres)
        ↓
¿Usuario selecciona?
        ↓
SÍ → Preguntar: ¿Eres principiante o tienes experiencia?
        ↓
    Opciones:
    1️⃣ Principiante
    2️⃣ Tengo algo de experiencia
    3️⃣ Avanzado
        ↓
    Preguntar: ¿Nombre completo?
        ↓
    Preguntar: ¿Correo?
        ↓
    Preguntar: ¿Cuántos asistentes van? (1, 2, 3+)
        ↓
    ✅ CONFIRMACIÓN:
    "¡Perfecto! Te hemos registrado para:
    
    📌 Taller: [NOMBRE TALLER]
    📅 Fecha: [FECHA Y HORA]
    💰 Precio: $500 x [CANTIDAD] = $[TOTAL]
    
    En 2 horas recibirás enlace de confirmación
    y detalles de ubicación.
    
    ¿Preguntas? Escribe 'AYUDA' 👇"
        ↓
    TAG: "prospecto-taller"
    ↓
    NOTIFICACIÓN AL EQUIPO
    ↓
    FIN
```

---

### 🎓 FLUJO CARRERAS (MÁS DETALLADO)

```
Usuario selecciona: CARRERA
        ↓
Mostrar 3 opciones principales
        ↓
¿Usuario selecciona?
        ↓
SÍ → Preguntar: ¿Cuál es tu experiencia actual?
        ↓
    Opciones:
    1️⃣ Sin experiencia (quiero aprender)
    2️⃣ Tengo cursos básicos
    3️⃣ Experiencia laboral en el área
        ↓
    Preguntar: ¿Disponibilidad de tiempo?
        ↓
    Opciones:
    1️⃣ Tiempo completo (lunes a viernes)
    2️⃣ Tiempo parcial (noches/fines de semana)
    3️⃣ Flexible (a definir)
        ↓
    Preguntar: ¿Modalidad?
        ↓
    Opciones:
    1️⃣ Presencial
    2️⃣ Híbrida (presencial + online)
        ↓
    Preguntar: ¿Nombre completo?
        ↓
    Preguntar: ¿Correo?
        ↓
    Preguntar: ¿Teléfono?
        ↓
    ✅ CONFIRMACIÓN:
    "¡Excelente, [NOMBRE]! 🎓
    
    Hemos registrado tu interés en:
    📌 Carrera: [CARRERA]
    📊 Nivel: [NIVEL]
    ⏰ Modalidad: [MODALIDAD]
    🕐 Disponibilidad: [DISPONIBILIDAD]
    
    Nuestro coordinador académico se contactará
    en 24 hrs para:
    ✅ Aclarar dudas
    ✅ Agendar entrevista personal
    ✅ Enviar plan de estudios
    
    Descarga especificaciones:
    [LINK PDF CARRERA]"
        ↓
    TAG: "prospecto-carrera-[CARRERA]"
    ↓
    CREAR TAREA EN HUBSPOT:
    Asignar a: Coordinador académico
    Prioridad: Alta
    ↓
    NOTIFICACIÓN AL EQUIPO (VÍA SLACK/EMAIL)
    ↓
    ENVIAR EMAIL DE CONFIRMACIÓN
    ↓
    FIN
```

---

## 5️⃣ DATOS A CAPTURAR (RESUMEN)

### DATOS BÁSICOS (Todo prospecto)
```
✅ Nombre completo
✅ Correo electrónico
✅ Teléfono WhatsApp
✅ Categoría de interés (Curso/Taller/Carrera/Consultoría)
```

### DATOS ESPECÍFICOS POR CATEGORÍA

**CURSOS:**
```
✅ Curso seleccionado
✅ Fecha de inicio preferida
✅ Presupuesto disponible
```

**TALLERES:**
```
✅ Taller seleccionado
✅ Nivel de experiencia
✅ Número de asistentes
```

**CARRERAS:**
```
✅ Carrera seleccionada
✅ Nivel de experiencia
✅ Disponibilidad de tiempo
✅ Modalidad preferida (presencial/híbrida)
✅ Edad (opcional)
```

**CONSULTORÍA:**
```
✅ Tipo de consultoría
✅ Descripción de necesidad
✅ Presupuesto estimado
✅ Timeline/Urgencia
```

---

## 6️⃣ AUTOMACIONES Y NOTIFICACIONES

### 📬 Cuando se completa el flujo:

1. **CREAR CONTACTO EN HUBSPOT**
   - Nombre
   - Email
   - Teléfono
   - Fuente: WhatsApp/Facebook
   - Tags automáticos (prospecto-[categoría])

2. **ENVIAR EMAIL DE CONFIRMACIÓN**
   ```
   Asunto: "¡Bienvenido a CEFAT, [NOMBRE]!"
   
   Contenido:
   - Resumen de lo registrado
   - Links a resources (PDF, video, etc.)
   - Próximos pasos
   - Contacto directo
   ```

3. **NOTIFICAR AL EQUIPO**
   - Slack: "Nuevo prospecto en [CATEGORÍA]"
   - Crear tarea en HubSpot
   - Asignar al asesor correspondiente

4. **SEGUIMIENTO AUTOMÁTICO**
   - 24 hrs después: Si no hay respuesta, enviar mensaje
   - 48 hrs después: Ofrecimiento de llamada
   - Tagging automático para campaña de nurture

---

## 7️⃣ SIMPLIFICACIONES RECOMENDADAS

### ❌ NO HACER (Reduce conversión):
- Preguntar más de 5 datos por sesión
- Saltos condicionales complejos
- Preguntas abiertas (usar siempre opciones)
- Esperar demasiado entre mensajes

### ✅ HACER (Aumenta conversión):
- Máximo 1-2 preguntas por mensaje
- Opciones claras (1, 2, 3, 4)
- Mensajes cortos y directos
- Respuesta rápida (menos de 10 segundos)
- Emojis para claridad
- Ofrecer alternativa "HABLAR CON ASESOR"

---

## 8️⃣ VARIANTE: OPCIÓN "HABLAR CON ASESOR"

En cualquier momento, si el usuario responde algo no contemplado, mostrar:

```
¿Prefieres hablar directamente con un asesor?

Disponibilidad:
📞 Lunes a Viernes: 9:00 AM - 6:00 PM
📞 Sábados: 10:00 AM - 2:00 PM

Puedes:
👉 Hacer clic para llamada directa
👉 Dejar tu teléfono y te llamamos en 30 min
👉 Agendar videollamada

¿Cuál prefieres?
```

---

## 9️⃣ MÉTRICAS A MEDIR

```
📊 Tasa de entrada (cuántos inician flujo)
📊 Tasa de abandono por nivel
📊 Categoría más popular
📊 Tasa de conversión a datos capturados
📊 Tiempo promedio en flujo
📊 Tasa de escalada a asesor
📊 Tasa de agendamiento exitoso
```

---

## 🔟 RESUMEN: FLUJO ULTRA SIMPLIFICADO

```
1. ENTRADA: Palabras clave activan flujo
2. VALIDACIÓN: ¿Contacto nuevo o conocido?
3. MENSAJE BIENVENIDA: Personalizado
4. MENÚ PRINCIPAL: 4 opciones (Cursos/Talleres/Carreras/Otro)
5. FLUJO ESPECÍFICO: Según opción seleccionada
6. CAPTURA DATOS: Max 5 preguntas
7. CONFIRMACIÓN: Resumen y próximos pasos
8. NOTIFICACIÓN: Equipo CEFAT
9. SEGUIMIENTO: Automático a las 24/48 hrs
10. FIN: Prospecto en pipeline
```

---

**Tiempo estimado por flujo:** 3-5 minutos  
**Objetivo de conversión:** 60%+ de captura de datos  
**Implementación:** 2 semanas en Manychat  
**Mantenimiento:** Actualizar contenidos mensualmente
