# 📝 Guía Completa de Shortcodes

Los shortcodes te permiten agregar contenido dinámico a cualquier página o entrada de WordPress sin escribir código.

## 🎯 Shortcodes Disponibles

### 1. 📧 Formulario de Contacto

**Shortcode:**
```
[agricultor_contact_form]
```

**Descripción:** Muestra un formulario de contacto completo con validación.

**Parámetros:** Ninguno

**Ejemplo:**
```
[agricultor_contact_form]
```

**Resultado:** Un formulario con campos para:
- Nombre (requerido)
- Email (requerido)
- Teléfono (opcional)
- Asunto (requerido)
- Mensaje (requerido)

---

### 2. ❓ Preguntas Frecuentes (FAQs)

**Shortcode:**
```
[agricultor_faq category="general" limit="10" title="Preguntas Frecuentes"]
```

**Parámetros:**
- `category` - Filtrar por categoría (slug) - opcional
- `limit` - Número máximo de FAQs a mostrar (default: 10)
- `title` - Título de la sección (default: "Frequently Asked Questions")

**Ejemplos:**

Mostrar todas las FAQs:
```
[agricultor_faq]
```

Mostrar solo categoría "productos" con límite de 5:
```
[agricultor_faq category="productos" limit="5"]
```

Con título personalizado:
```
[agricultor_faq title="Dudas Comunes"]
```

**Características:**
- Desplegables interactivos (click para abrir/cerrar)
- Estilo profesional y responsivo
- Animaciones suaves
- Iconos indicadores

---

### 3. 🗺️ Mapa con Ubicación

**Shortcode:**
```
[agricultor_map width="100%" height="400px" zoom="15"]
```

**Parámetros:**
- `width` - Ancho del mapa (default: 100%)
- `height` - Altura del mapa (default: 400px)
- `zoom` - Nivel de zoom (default: 15)

**Ejemplos:**

Mapa estándar:
```
[agricultor_map]
```

Mapa más grande con zoom personalizado:
```
[agricultor_map height="600px" zoom="12"]
```

Mapa en contenedor específico:
```
[agricultor_map width="80%" height="500px" zoom="16"]
```

**Requisitos:**
- ✅ Debe tener latitud y longitud configuradas en **Dashboard → Contact Info**
- ✅ Necesita API key de Google Maps (opcional para versión básica)

**Características:**
- Marcador automático con ubicación
- Controles de zoom y vista de calle
- Popup con información del negocio
- Totalmente responsivo

---

### 4. 📞 Información de Contacto

**Shortcode:**
```
[agricultor_contact_info layout="vertical" show_social="yes"]
```

**Parámetros:**
- `layout` - Opciones: "vertical", "horizontal", "grid" (default: vertical)
- `show_social` - Mostrar redes sociales: "yes", "no" (default: yes)

**Ejemplos:**

Diseño vertical (recomendado para sidebar):
```
[agricultor_contact_info layout="vertical"]
```

Diseño horizontal (recomendado para header/footer):
```
[agricultor_contact_info layout="horizontal"]
```

Diseño en grid sin redes sociales:
```
[agricultor_contact_info layout="grid" show_social="no"]
```

**Muestra:**
- ✅ Teléfono
- ✅ WhatsApp
- ✅ Email
- ✅ Dirección
- ✅ Redes sociales (opcional)

---

### 5. 💬 Botón Flotante de WhatsApp

**Shortcode:**
```
[agricultor_whatsapp_button position="right" message="¡Hola! Me gustaría saber más"]
```

**Parámetros:**
- `position` - Posición: "left" o "right" (default: right)
- `message` - Mensaje predefinido para WhatsApp (opcional)

**Ejemplos:**

Botón flotante simple en la derecha:
```
[agricultor_whatsapp_button]
```

Posición izquierda con mensaje:
```
[agricultor_whatsapp_button position="left" message="Hola, quisiera información sobre los productos"]
```

**Características:**
- ✅ Flota en la esquina de la pantalla
- ✅ Se oculta en móvil (solo muestra icono)
- ✅ Animación de entrada suave
- ✅ Abre WhatsApp directamente
- ✅ Mensaje predefinido opcional

---

## 🎨 Cómo Usar Shortcodes

### En el Editor de Páginas

1. Abre la página donde quieres agregar el shortcode
2. Click en **Editar**
3. Ubícate donde quieras insertar el contenido
4. Paste el shortcode deseado
5. Publica o actualiza

### Ejemplo Completo de Página

```
[agricultor_contact_info layout="horizontal" show_social="yes"]

[agricultor_contact_form]

[agricultor_map height="500px"]

[agricultor_faq title="Preguntas Frecuentes Sobre Nuestros Productos"]

[agricultor_whatsapp_button message="Hola, tengo una pregunta sobre los productos"]
```

---

## 📱 Ejemplos por Sección de Página

### HEADER (Encabezado)
```
[agricultor_contact_info layout="horizontal" show_social="yes"]
```

### MAIN (Contenido Principal)
```
[agricultor_faq title="Preguntas Frecuentes"]
```

### PÁGINA DE CONTACTO
```
<h2>Contáctanos</h2>
[agricultor_contact_info layout="vertical"]

<h3>Envía tu mensaje</h3>
[agricultor_contact_form]

<h3>Ubicación</h3>
[agricultor_map]
```

### FOOTER (Pie de página)
```
<h3>Información de Contacto</h3>
[agricultor_contact_info layout="grid" show_social="yes"]

[agricultor_whatsapp_button]
```

### PÁGINA DE PREGUNTAS FRECUENTES
```
[agricultor_faq title="Centro de Ayuda" limit="20"]
```

---

## 🎯 Gestionar FAQs

### Crear una FAQ

1. Ve a **Dashboard** (en WordPress Admin)
2. (Pronto) Habrá un menú para gestionar FAQs
3. Click en **+ Add New FAQ**
4. Completa:
   - **Título**: La pregunta
   - **Contenido**: La respuesta
   - **Categoría**: Agrupa preguntas relacionadas
5. Publica

### Gestionar Categorías

Las categorías te ayudan a organizar FAQs por tema:
- Productos
- Envíos
- Devoluciones
- Generales
- etc.

Luego filtra con el shortcode:
```
[agricultor_faq category="productos"]
```

---

## 🔧 Personalización CSS

Todos los shortcodes incluyen clases CSS que puedes personalizar:

### FAQs
```css
.agricultor-faq-container { /* Contenedor principal */ }
.agricultor-faq-title { /* Título */ }
.agricultor-faq-item { /* Cada pregunta */ }
.agricultor-faq-toggle { /* Botón de pregunta */ }
.agricultor-faq-answer { /* Respuesta expandida */ }
```

### Formulario de Contacto
```css
.agricultor-contact-form { /* Formulario principal */ }
.form-group { /* Cada campo */ }
.form-input { /* Inputs */ }
.form-textarea { /* Textarea */ }
```

### Información de Contacto
```css
.agricultor-contact-info-wrapper { /* Contenedor */ }
.agricultor-contact-item { /* Cada item */ }
.social-icons { /* Iconos sociales */ }
```

### Mapa
```css
.agricultor-map-container { /* Contenedor del mapa */ }
.agricultor-map { /* El mapa en sí */ }
```

### Botón WhatsApp
```css
#agricultor-whatsapp-floating { /* Contenedor flotante */ }
.whatsapp-button { /* El botón */ }
```

---

## 💡 Tips Útiles

### 1. Combina Shortcodes
Crea una página completa de contacto:
```
[agricultor_contact_info layout="vertical"]
[agricultor_contact_form]
[agricultor_map]
[agricultor_whatsapp_button]
```

### 2. Personaliza Mensajes
Usa un mensaje en WhatsApp específico por página:
```
Página de Productos:
[agricultor_whatsapp_button message="Hola, tengo dudas sobre los productos de agricultura"]

Página de Envíos:
[agricultor_whatsapp_button message="Quisiera saber sobre el envío a mi zona"]
```

### 3. Múltiples FAQs por Categoría
```
[agricultor_faq category="productos" title="Preguntas Sobre Productos"]
[agricultor_faq category="envios" title="Preguntas Sobre Envíos"]
[agricultor_faq category="devolucion" title="Preguntas Sobre Devoluciones"]
```

### 4. Responsivo Automáticamente
Todos los shortcodes se adaptan automáticamente a:
- 📱 Móvil (teléfonos)
- 📱 Tablet
- 💻 Desktop (computadora)

---

## ⚙️ Configuración Requerida

Antes de usar los shortcodes, asegúrate de:

### Para Google Maps
- ✅ Configura latitud y longitud en **Dashboard → Contact Info**
- ℹ️ (Opcional) Obtén una API key en Google Cloud Console

### Para Formulario de Contacto
- ✅ Email del admin debe estar configurado
- ✅ El servidor debe permitir envío de emails (SMTP)

### Para WhatsApp
- ✅ Configura tu número de WhatsApp en **Dashboard → Contact Info**

### Para Información de Contacto
- ✅ Llena al menos uno de: teléfono, email, dirección o redes sociales

---

## 🆘 Troubleshooting

### El shortcode no se muestra
- **Solución**: Asegúrate de que el plugin esté activado
- **Solución**: Usa el shortcode exactamente como se muestra

### El formulario no envía emails
- **Solución**: Ve a **Tools → Site Health** para verificar SMTP
- **Solución**: Revisa `/wp-content/debug.log` para errores

### El mapa no muestra ubicación
- **Solución**: Configura latitud y longitud en el Dashboard
- **Solución**: Verifica que sean números válidos

### WhatsApp no funciona
- **Solución**: Configura el número en **Dashboard → Contact Info**
- **Solución**: Usa formato internacional: +503 2234 5678

### Los estilos no se aplican correctamente
- **Solución**: Limpia la caché del navegador (Ctrl+Shift+Del)
- **Solución**: Desactiva plugins de caché temporalmente

---

## 📚 Más Información

- **Documentación Principal**: [README.md](README.md)
- **Ejemplos de Tema**: [TEMPLATE_EXAMPLES.md](TEMPLATE_EXAMPLES.md)
- **Guía de Instalación**: [INSTALLATION.md](INSTALLATION.md)

---

¡Ahora tu sitio tiene todos los elementos que necesitas! 🚀
