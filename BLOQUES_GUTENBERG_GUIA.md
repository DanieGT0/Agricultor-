# 🧱 Guía de Bloques Gutenberg - Crear Páginas Fácilmente

¡Hola Daniel! He creado una forma muy fácil de agregar funcionalidades a tus páginas sin escribir código. Aquí está cómo hacerlo:

---

## 🎯 ¿Qué son los Bloques Gutenberg?

Los bloques Gutenberg son **componentes visuales** que puedes agregar a tus páginas de WordPress mediante drag & drop (arrastrar y soltar).

**Antes (Código):**
```
[agricultor_faq category="productos"]
```

**Ahora (Visual):**
1. Haz clic en el botón **+**
2. Busca "FAQ"
3. ¡Listo! El bloque se agrega automáticamente

---

## 📋 Los 5 Bloques Disponibles

### 1️⃣ **Bloque de FAQs** ❓

Muestra preguntas frecuentes en formato acordeón.

**Dónde encontrarlo:**
- Haz clic en **+** en el editor
- Busca "Preguntas Frecuentes" o "FAQ"
- O busca en la categoría "Agricultor"

**Opciones de configuración:**
- **Categoría:** Filtra qué FAQs mostrar
  - Todas las categorías
  - General
  - Productos
  - Envíos
  - Devoluciones
  - Métodos de Pago
  - Mi Cuenta
- **Límite de preguntas:** Cuántas FAQs mostrar (1-50)
- **Título:** Título personalizado para la sección

**Ejemplo:**
```
Categoría: Productos
Límite: 5
Título: "Preguntas sobre Productos"
```

**Resultado en la página:**
Un acordeón con 5 preguntas sobre productos

---

### 2️⃣ **Bloque de Formulario de Contacto** 📧

Formulario completo para que clientes te envíen mensajes.

**Dónde encontrarlo:**
- Haz clic en **+**
- Busca "Formulario de Contacto"
- O en categoría "Agricultor"

**Campos que aparecen:**
- Nombre (requerido)
- Email (requerido)
- Teléfono (opcional)
- Asunto (requerido)
- Mensaje (requerido)

**No hay opciones de configuración** - Es plug and play

**Resultado en la página:**
Un formulario bonito que envía emails al admin automáticamente

---

### 3️⃣ **Bloque de Información de Contacto** 📞

Muestra teléfono, email, dirección y redes sociales.

**Dónde encontrarlo:**
- Haz clic en **+**
- Busca "Información de Contacto"
- O en categoría "Agricultor"

**Opciones de configuración:**
- **Diseño:**
  - Vertical (para sidebar o columna)
  - Horizontal (para header o fila)
  - Grid (para footer con múltiples columnas)
- **Mostrar redes sociales:** Activar o desactivar

**Ejemplo 1 - Sidebar:**
```
Diseño: Vertical
Redes: Activadas
```

**Ejemplo 2 - Footer:**
```
Diseño: Grid
Redes: Desactivadas
```

**Resultado en la página:**
Tu información de contacto en el diseño seleccionado

---

### 4️⃣ **Bloque de Mapa** 🗺️

Muestra tu ubicación en un mapa interactivo.

**Dónde encontrarlo:**
- Haz clic en **+**
- Busca "Mapa de Ubicación"
- O en categoría "Agricultor"

**Opciones de configuración:**
- **Ancho:** Qué tan ancho es el mapa (ej: 100%, 80%)
- **Alto:** Qué tan alto es el mapa (ej: 400px, 500px)
- **Zoom:** Nivel de zoom del mapa (1-21)

**Requisito importante:**
Debes configurar tu ubicación primero:
1. Ve a Dashboard → Contact Info
2. Ingresa "Latitud" y "Longitud"
3. Luego usa el bloque de mapa

**Ejemplo:**
```
Ancho: 100%
Alto: 500px
Zoom: 16 (más cerca)
```

**Resultado en la página:**
Un mapa interactivo con tu ubicación marcada

---

### 5️⃣ **Bloque de Botón WhatsApp** 💬

Botón flotante que abre WhatsApp automáticamente.

**Dónde encontrarlo:**
- Haz clic en **+**
- Busca "Botón WhatsApp" o "WhatsApp"
- O en categoría "Agricultor"

**Opciones de configuración:**
- **Posición:** Esquina derecha o izquierda
- **Mensaje predefinido:** Texto que aparece al abrir WhatsApp (opcional)

**Requisito importante:**
Debes configurar tu número de WhatsApp:
1. Ve a Dashboard → Contact Info
2. Ingresa tu número de WhatsApp
3. Luego usa el bloque

**Ejemplo:**
```
Posición: Derecha
Mensaje: "Hola, tengo una pregunta sobre los productos"
```

**Resultado en la página:**
Un botón flotante verde en la esquina que abre WhatsApp con tu mensaje

---

## 📖 Guía Paso a Paso: Crear una Página Completa

### Paso 1: Crear una Nueva Página
1. Ve a WordPress Admin → Páginas
2. Haz clic en "Agregar Nueva"
3. Dale un título (ej: "Contacto")

### Paso 2: Agregar el Primer Bloque
1. En el área de contenido, verás un **+**
2. Haz clic en el **+**
3. Se abrirá un menú de bloques

### Paso 3: Buscar un Bloque
- **Opción A:** Escribe en la búsqueda (ej: "FAQ")
- **Opción B:** Baja hasta "Agricultor" y mira todos los bloques

### Paso 4: Agregar el Bloque
1. Haz clic en el bloque que quieres
2. El bloque se agregará a la página
3. Verás una tarjeta de previsualización

### Paso 5: Configurar el Bloque
1. Haz clic en el bloque
2. En el panel derecho (Inspector), aparecerán las opciones
3. Ajusta según necesites

### Paso 6: Agregar Más Bloques
1. Haz clic en el **+** entre bloques o al final
2. Repite los pasos 3-5

### Paso 7: Publicar
1. Haz clic en "Publicar"
2. ¡Tu página está lista!

---

## 🎨 Ejemplos de Páginas Completas

### Ejemplo 1: Página de Inicio
```
Título: Inicio

[Bloque Información de Contacto]
  Diseño: Horizontal
  Redes: Sí

[Bloque WhatsApp]
  Posición: Derecha

[Bloque de FAQs]
  Categoría: General
  Límite: 3
  Título: "Preguntas Frecuentes"
```

### Ejemplo 2: Página de Contacto
```
Título: Contacto

Párrafo: "Te podemos ayudar de varias formas..."

[Bloque Información de Contacto]
  Diseño: Vertical
  Redes: Sí

[Bloque Formulario de Contacto]

[Bloque Mapa]
  Alto: 500px
  Zoom: 16

[Bloque WhatsApp]
  Mensaje: "Prefiero contactar por WhatsApp"
```

### Ejemplo 3: Página de Productos
```
Título: Productos

[Bloque Información de Contacto]
  Diseño: Horizontal
  Redes: No

Párrafo: "Conoce nuestros productos..."

[Bloque de FAQs]
  Categoría: Productos
  Límite: 5
  Título: "Preguntas sobre Productos"

Párrafo: "¿Más dudas? Contactate con nosotros"

[Bloque Formulario de Contacto]
```

---

## 🔍 Cómo se Ven en el Editor

Cuando agregas un bloque, verás una **tarjeta colorida** que muestra:

**Ejemplo - Bloque de FAQs:**
```
┌─────────────────────────────────┐
│ ❓ Preguntas Frecuentes         │
│                                 │
│ Mostrará 10 preguntas          │
│ de todas las categorías         │
└─────────────────────────────────┘
```

**Ejemplo - Bloque de Contacto:**
```
┌─────────────────────────────────┐
│ 📞 Información de Contacto      │
│                                 │
│ Diseño: Vertical               │
│ (con redes sociales)           │
└─────────────────────────────────┘
```

Estas tarjetas son solo para el editor. En la página publicada, verás el contenido real formateado bonito.

---

## ⚙️ Requisitos Previos

Antes de usar los bloques, asegúrate de haber configurado:

### Para FAQs
- [ ] Ve a Dashboard → FAQs
- [ ] Crea al menos una FAQ de prueba

### Para Mapa
- [ ] Ve a Dashboard → Contact Info
- [ ] Ingresa tu Latitud
- [ ] Ingresa tu Longitud

### Para WhatsApp
- [ ] Ve a Dashboard → Contact Info
- [ ] Ingresa tu número de WhatsApp (formato: +503XXXX5678)

### Para Información de Contacto
- [ ] Ve a Dashboard → Contact Info
- [ ] Ingresa al menos uno: Teléfono, Email o Dirección

### Para Formulario
- [ ] Tu email admin debe estar configurado en WordPress
- [ ] (Esto es automático)

---

## 🎓 Consejos Prácticos

### 💡 Uso de Bloques
1. **No necesitas escribir código** - Todo es visual
2. **Puedes ver cambios en tiempo real** - El editor muestra las opciones
3. **Puedes reordenar bloques** - Arrastra y suelta
4. **Puedes duplicar bloques** - Haz clic en las 3 opciones (⋯)
5. **Puedes eliminar bloques** - Botón rojo con X

### 🎯 Mejores Prácticas
1. Configura todo en Dashboard primero
2. Usa títulos descriptivos en los bloques
3. Combina bloques para crear experiencias completas
4. Prueba la página en móvil antes de publicar
5. Usa max 2-3 categorías de FAQs por página

### 📱 Responsive
Todos los bloques se adaptan automáticamente a:
- Celular (móvil)
- Tablet
- Computadora

---

## ❓ Preguntas Frecuentes

**P: ¿Puedo usar el mismo bloque varias veces?**
R: Sí, puedes agregar múltiples bloques iguales en la misma página.

**P: ¿Se necesita internet para ver los bloques?**
R: Sí, los bloques funcionan solo en el editor. La página publicada sí funciona sin internet (datos guardados en BD).

**P: ¿Dónde se guardan los cambios?**
R: Todo se guarda en la base de datos de WordPress automáticamente cuando haces clic en "Actualizar".

**P: ¿Puedo cambiar el orden de los bloques?**
R: Sí, usa el menú ⋯ de cada bloque o simplemente arrastra.

**P: ¿Qué pasa si olvido configurar algo?**
R: Los bloques mostrarán valores por defecto. Vuelve a Dashboard y configura lo que falta.

---

## 🚀 Próximas Funcionalidades

Próximamente podré agregar:
- [ ] Bloques para galerías de imágenes
- [ ] Bloque de testimonios
- [ ] Bloque de precios
- [ ] Bloque de equipo
- [ ] Bloques personalizados adicionales

---

## 📞 ¿Necesitas Ayuda?

Si tienes problemas:
1. Verifica que el plugin esté activado
2. Recarga la página (F5)
3. Limpia el caché del navegador
4. Verifica que hayas configurado todo en Dashboard

---

**Resumen: Ahora es mucho más fácil crear páginas en WordPress sin escribir código. ¡Solo arrastra y suelta bloques! 🎉**

---

**Última actualización:** 2025-11-11
**Versión:** 1.0.0 bloques
