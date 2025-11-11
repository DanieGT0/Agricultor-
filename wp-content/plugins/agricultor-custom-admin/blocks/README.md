# 🧱 Bloques Gutenberg Personalizados

Los bloques Gutenberg de Agricultor te permiten insertar componentes dinámicos directamente en el editor de páginas de WordPress sin escribir código.

---

## 🎯 Bloques Disponibles

### 1. ❓ **Preguntas Frecuentes (FAQs)**

**Ubicación en editor:** Agricultor → Preguntas Frecuentes (FAQs)

**Configuración:**
- **Categoría:** Filtra FAQs por categoría (Todas, General, Productos, Envíos, etc.)
- **Límite de preguntas:** Número máximo de FAQs a mostrar (1-50)
- **Título:** Título personalizado para la sección

**Ejemplo:**
```
Título: "Centro de Ayuda"
Categoría: Productos
Límite: 10
```

**Resultado en página:**
Un acordeón interactivo con preguntas que se expanden al hacer clic.

---

### 2. 📧 **Formulario de Contacto**

**Ubicación en editor:** Agricultor → Formulario de Contacto

**Configuración:** No requiere configuración

**Campos del formulario:**
- Nombre (requerido)
- Email (requerido)
- Teléfono (opcional)
- Asunto (requerido)
- Mensaje (requerido)

**Resultado en página:**
Un formulario completo con validación automática que envía emails al admin.

---

### 3. 📞 **Información de Contacto**

**Ubicación en editor:** Agricultor → Información de Contacto

**Configuración:**
- **Diseño:**
  - Vertical (para sidebar)
  - Horizontal (para header)
  - Grid (para footer)
- **Mostrar redes sociales:** Sí/No

**Información que muestra:**
- Teléfono
- WhatsApp
- Email
- Dirección
- Redes sociales (Facebook, Instagram, LinkedIn, Twitter)

**Resultado en página:**
Información de contacto en el diseño seleccionado.

---

### 4. 🗺️ **Mapa de Ubicación**

**Ubicación en editor:** Agricultor → Mapa de Ubicación

**Configuración:**
- **Ancho:** Ancho del mapa (ej: 100%, 80%, 400px)
- **Alto:** Altura del mapa (ej: 400px, 500px)
- **Zoom:** Nivel de zoom (1-21, recomendado 15)

**Requisitos:**
- Debes configurar latitud y longitud en **Dashboard → Contact Info**

**Resultado en página:**
Mapa interactivo con tu ubicación marcada.

---

### 5. 💬 **Botón WhatsApp Flotante**

**Ubicación en editor:** Agricultor → Botón WhatsApp Flotante

**Configuración:**
- **Posición:** Esquina derecha o izquierda
- **Mensaje predefinido:** Texto que aparecerá al abrir WhatsApp (opcional)

**Requisitos:**
- Debes configurar tu número de WhatsApp en **Dashboard → Contact Info**

**Resultado en página:**
Botón flotante que abre WhatsApp directamente.

---

## 🚀 Cómo Usar los Bloques

### Paso 1: Ir al Editor de Páginas
1. En WordPress, ve a **Páginas**
2. Abre o crea una página
3. Haz clic en **Editar** (si es página existente) o espera a que se abra el editor

### Paso 2: Agregar Bloque
1. En el editor visual, haz clic en el **+** (Agregar bloque)
2. Busca **Agricultor** en la categoría
3. O escribe en la búsqueda: "FAQ", "Contacto", "Mapa", "WhatsApp"

### Paso 3: Configurar Bloque
1. Haz clic en el bloque que agregaste
2. En el panel derecho (Inspeccionar), aparecerán las opciones de configuración
3. Ajusta según tus necesidades

### Paso 4: Publicar
1. Haz clic en **Publicar** o **Actualizar**
2. Visita la página para ver el resultado

---

## 📋 Ejemplos de Páginas Completas

### Página de Contacto
```
Título: Contacto

[FAQ Block - Categoría: General]

[Información de Contacto - Layout: Vertical]

[Formulario de Contacto]

[Mapa]

[Botón WhatsApp]
```

### Página de Productos
```
Título: Productos

[Información de Contacto - Layout: Horizontal, sin redes]

[FAQ Block - Categoría: Productos, Límite: 5]

[Formulario de Contacto]
```

### Página de Inicio
```
Título: Inicio

[Información de Contacto - Layout: Horizontal]

[Botón WhatsApp - Mensaje: "Hola, quisiera información"]

[FAQ Block - Categoría: General, Límite: 3]
```

---

## 🎨 Personalización Visual

Los bloques usan estilos predefinidos, pero puedes personalizarlos con CSS:

```css
/* FAQs */
.agricultor-faq-container { }
.agricultor-faq-toggle { }
.agricultor-faq-answer { }

/* Contacto */
.agricultor-contact-info-wrapper { }
.agricultor-contact-item { }

/* Formulario */
.agricultor-contact-form { }
.form-input { }

/* Mapa */
.agricultor-map-container { }

/* WhatsApp */
#agricultor-whatsapp-floating { }
```

---

## ❓ Preguntas Frecuentes

**P: ¿Dónde aparecen los bloques en el editor?**
R: Al hacer clic en "+", busca "Agricultor" en la categoría de bloques.

**P: ¿Puedo usar el mismo bloque varias veces?**
R: Sí, puedes agregar múltiples bloques en la misma página.

**P: ¿Se necesita guardar en el dashboard primero?**
R: Sí, antes de usar los bloques, configura la información en tu Dashboard (Contacto, FAQs, etc.).

**P: ¿Qué pasa si no configuro algo?**
R: Los bloques mostrarán valores por defecto. Configura en el Dashboard para información personalizada.

**P: ¿Se puede previsualizar los bloques en el editor?**
R: Sí, el editor muestra una previsualización. Para ver el resultado final, publica y visita la página.

---

## 🔧 Requisitos Previos

1. **FAQs:** Crear al menos una FAQ en Dashboard → FAQs
2. **Contacto:** Configurar información en Dashboard → Contact Info
3. **Mapa:** Configurar latitud/longitud en Dashboard → Contact Info
4. **WhatsApp:** Configurar número en Dashboard → Contact Info
5. **Formulario:** Email del admin debe estar configurado en WordPress

---

## 📊 Vista Previa del Editor

Cuando agregues un bloque, verás una tarjeta de previsualización que muestra:
- Icono del bloque
- Nombre del bloque
- Configuración actual
- Color distintivo para identificarlo fácilmente

Ejemplo de tarjeta FAQ:
```
❓ Preguntas Frecuentes
Mostrará 10 preguntas de todas las categorías
```

---

## 🚀 Próximos Pasos

1. Abre una página existente o crea una nueva
2. Haz clic en el **+** para agregar bloques
3. Busca y añade los bloques que necesites
4. Configura cada uno en el panel derecho
5. Publica la página

¡Ahora crear páginas es mucho más fácil! 🎉

---

**Última actualización:** 2025-11-11
