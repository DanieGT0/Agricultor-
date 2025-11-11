# Agricultor Custom Admin Dashboard

Un plugin WordPress completamente personalizado que reemplaza el admin por defecto con un panel administrativo moderno y user-friendly para la gestión de sitios web.

## 🌱 Características

- ✅ **Dashboard Personalizado**: Interfaz intuitiva sin acceso al admin de WordPress
- ✅ **Gestión de Contacto**: Editar teléfono, email, WhatsApp, ubicación y redes sociales
- ✅ **Personalización de Tema**: Cambiar colores y tipografía en tiempo real
- ✅ **Gestión de Imágenes**: Subir, organizar y editar imágenes del sitio
- ✅ **Formularios de Contacto**: Ver y gestionar respuestas de formularios
- ✅ **Sin Plugins de Terceros**: 100% código personalizado
- ✅ **REST API**: Endpoints personalizados para todas las funcionalidades
- ✅ **Responsive Design**: Funciona en desktop, tablet y móvil
- ✅ **Seguridad**: Validación, sanitización y verificación de nonces

## 📋 Requisitos

- WordPress 5.0+
- PHP 8.0+
- Node.js 16+ (para compilar el frontend React)
- npm o yarn

## 🚀 Instalación

### Paso 1: Descargar el plugin

```bash
cd wp-content/plugins
git clone https://github.com/DanieGT0/Agricultor-.git agricultor-custom-admin
cd agricultor-custom-admin
```

### Paso 2: Compilar el frontend React

```bash
cd admin
npm install
npm run build
cd ..
```

### Paso 3: Activar el plugin

1. Ve a WordPress Admin → Plugins
2. Busca "Agricultor Custom Admin"
3. Haz click en "Activate"

## 📖 Uso

### Acceder al Dashboard

Una vez activado el plugin:
- Los usuarios con permiso `edit_posts` verán un nuevo menú "Dashboard" en el admin
- Haz click en "Dashboard" para acceder al panel personalizado
- El dashboard es la nueva página de inicio del admin

### Dashboard Principal

La página principal muestra:
- **Estadísticas**: Total de imágenes, respuestas de formularios, etc.
- **Acciones Rápidas**: Enlaces directos a las principales funcionalidades
- **Información**: Tips y ayuda

### Gestionar Información de Contacto

1. Click en "Contact Info" en el menú lateral
2. Edita los siguientes campos:
   - **Teléfono Principal**: Número de contacto
   - **WhatsApp**: Número para links de WhatsApp
   - **Email**: Correo de contacto
   - **Dirección**: Ubicación física
   - **Coordenadas**: Latitud y longitud (para mapas)
   - **Redes Sociales**: Facebook, Instagram, LinkedIn, Twitter

3. Click en "Save Changes"

### Personalizar Tema

1. Click en "Customize Theme"
2. Selecciona los colores:
   - **Color Primario**: Color principal de la marca
   - **Color Secundario**: Color de soporte
   - **Color de Texto**: Color del texto
   - **Color de Fondo**: Color de fondo
3. Selecciona la familia tipográfica
4. Visualiza los cambios en tiempo real en el panel lateral
5. Click en "Save Changes"

Los cambios se aplicarán automáticamente en el frontend del sitio.

### Gestionar Imágenes

1. Click en "Manage Images"
2. Click en "+ Add Image"
3. Completa el formulario:
   - **Título**: Nombre descriptivo
   - **URL**: Link directo a la imagen
   - **Tipo**: Hero, Logo o Gallery
   - **Alt Text**: Descripción para accesibilidad
   - **Orden**: Número para ordenar las imágenes
4. Click en "Add Image"

Para eliminar una imagen:
- Localiza la imagen en la lista
- Click en "Delete"
- Confirma la eliminación

### Ver Respuestas de Formularios

1. Click en "Form Submissions"
2. Verás una tabla con todas las respuestas
3. Click en "View" para ver los detalles completos
4. Click en "Reply via Email" para responder al visitante

## 🔧 Configuración Técnica

### Estructura de Carpetas

```
agricultor-custom-admin/
├── agricultor-custom-admin.php       # Archivo principal del plugin
├── includes/
│   ├── class-post-types.php          # Custom Post Types
│   ├── class-rest-api.php            # Endpoints REST API
│   ├── class-metaboxes.php           # Metaboxes personalizados
│   ├── class-theme-options.php       # Opciones de tema
│   ├── class-admin-menu.php          # Menú de admin
│   ├── class-security.php            # Validación y seguridad
│   ├── class-forms.php               # Gestión de formularios
│   └── class-frontend.php            # Integración frontend
├── admin/
│   ├── src/
│   │   ├── main.jsx                  # Punto de entrada React
│   │   ├── App.jsx                   # Componente raíz
│   │   ├── index.css                 # Estilos globales
│   │   ├── components/               # Componentes React
│   │   ├── hooks/                    # Hooks personalizados
│   │   └── services/                 # Servicios API
│   ├── dist/                         # Build compilado
│   ├── package.json
│   ├── vite.config.js
│   ├── tailwind.config.js
│   └── postcss.config.js
├── assets/
│   ├── css/
│   │   ├── frontend.css              # Estilos del frontend
│   │   └── frontend-vars.css         # Variables CSS dinámicas
│   └── js/
│       └── contact-form.js           # Script de formularios
└── README.md
```

### Endpoints REST API

Todos los endpoints requieren autenticación y verificación de nonce.

#### Contacto
- `GET /wp-json/agricultor/v1/contact` - Obtener configuración
- `POST /wp-json/agricultor/v1/contact` - Actualizar configuración

#### Tema
- `GET /wp-json/agricultor/v1/theme` - Obtener configuración
- `POST /wp-json/agricultor/v1/theme` - Actualizar configuración

#### Imágenes
- `GET /wp-json/agricultor/v1/images` - Obtener todas
- `POST /wp-json/agricultor/v1/images` - Crear imagen
- `POST /wp-json/agricultor/v1/images/{id}` - Actualizar imagen
- `DELETE /wp-json/agricultor/v1/images/{id}` - Eliminar imagen

#### Formularios
- `GET /wp-json/agricultor/v1/submissions` - Obtener respuestas
- `POST /wp-json/agricultor/v1/submissions/create` - Crear respuesta (público)

#### Dashboard
- `GET /wp-json/agricultor/v1/dashboard/stats` - Obtener estadísticas

### Custom Post Types

- `site_images` - Imágenes del sitio
- `form_submissions` - Respuestas de formularios

### Opciones (wp_options)

- `agricultor_contact_config` - Configuración de contacto (JSON)
- `agricultor_theme_config` - Configuración de tema (JSON)

## 🎨 Usar Datos en tu Tema

El plugin proporciona funciones para acceder a los datos desde tu tema:

```php
<?php
// Obtener información de contacto
$contact = Agricultor_Frontend::get_contact_info();
echo $contact['email'];

// Obtener URL de WhatsApp
$whatsapp = Agricultor_Frontend::get_whatsapp_url();

// Obtener redes sociales
$social = Agricultor_Frontend::get_social_media();

// Obtener imágenes
$hero = Agricultor_Frontend::get_hero_image();
$logo = Agricultor_Frontend::get_logo_image();
$gallery = Agricultor_Frontend::get_gallery_images();

// Obtener configuración de tema
$colors = Agricultor_Frontend::get_theme_config();
?>
```

## 🔒 Seguridad

El plugin implementa múltiples capas de seguridad:

1. **Validación de Inputs**: Todos los datos se validan en cliente y servidor
2. **Sanitización**: Limpieza de datos con funciones de WordPress
3. **Verificación de Nonces**: Protección contra CSRF
4. **Verificación de Permisos**: Solo usuarios autorizados pueden acceder
5. **Protección XSS**: Escapeo de datos en salidas

### Validaciones Incluidas

- ✅ Email válido
- ✅ URLs válidas
- ✅ Teléfono con formato correcto
- ✅ Coordenadas geográficas válidas
- ✅ Colores hexadecimales válidos
- ✅ Nonces de seguridad

## 📱 Características de Frontend

### Componentes Reutilizables

El plugin incluye CSS classes para usar en tu tema:

```html
<!-- Botones -->
<button class="btn btn-primary">Click me</button>
<button class="btn btn-secondary">Click me</button>
<button class="btn btn-outline">Click me</button>

<!-- Cards -->
<div class="agricultor-card">Card content</div>

<!-- Grids -->
<div class="agricultor-grid agricultor-grid-2">
  <div>Item 1</div>
  <div>Item 2</div>
</div>

<!-- Formularios -->
<form class="agricultor-contact-form">
  <div class="form-group">
    <label>Name</label>
    <input type="text">
  </div>
</form>

<!-- Alertas -->
<div class="alert alert-success">Message</div>
<div class="alert alert-error">Error</div>
```

## 🛠️ Desarrollo

### Editar el Backend (PHP)

Edita los archivos en `/includes/` y haz cambios según sea necesario.

### Editar el Frontend (React)

```bash
cd admin
npm run dev  # Inicia servidor de desarrollo
```

Edita los archivos en `/admin/src/` y los cambios se recargarán automáticamente.

### Compilar para Producción

```bash
cd admin
npm run build
```

Esto generará los archivos optimizados en `/admin/dist/`.

## 🐛 Troubleshooting

### El dashboard no carga

1. Verifica que hayas corrido `npm run build` en la carpeta `admin/`
2. Abre la consola del navegador (F12) y busca errores
3. Revisa los logs de WordPress en `/wp-content/debug.log`

### Los cambios no se guardan

1. Verifica que tengas permiso `edit_posts`
2. Revisa la consola del navegador para errores de AJAX
3. Asegúrate que el nonce es válido

### Las imágenes no cargan

1. Verifica que la URL de la imagen sea válida
2. Intenta acceder a la URL en el navegador
3. Revisa la política CORS si es desde un dominio diferente

### Los colores del tema no cambian

1. Limpia la caché del navegador (Ctrl+Shift+Del)
2. Limpia la caché del plugin si tienes uno instalado
3. Verifica que CSS esté siendo inyectado en el `<head>`

## 📚 Documentación Adicional

Para más información y ejemplos, visita:
- [GitHub Repository](https://github.com/DanieGT0/Agricultor-)
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [WordPress REST API Documentation](https://developer.wordpress.org/rest-api/)

## 📝 Licencia

Este proyecto está bajo licencia GPL v2 o posterior.

## 👨‍💻 Autor

Desarrollado para **Agricultor Verde** - Suministros Agrícolas en El Salvador

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:
1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📧 Soporte

Para reportar bugs o solicitar features, abre un issue en el [repositorio de GitHub](https://github.com/DanieGT0/Agricultor-/issues).

---

**Versión**: 1.0.0
**Última actualización**: 2024
