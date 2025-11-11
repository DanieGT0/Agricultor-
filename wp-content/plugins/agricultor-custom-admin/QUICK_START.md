# ⚡ Quick Start Guide - Agricultor Custom Admin

Comienza con el plugin en 5 minutos.

## 📥 Instalación Rápida

### 1️⃣ Descargar y Ubicar el Plugin

```bash
cd wp-content/plugins
git clone https://github.com/DanieGT0/Agricultor-.git agricultor-custom-admin
cd agricultor-custom-admin
```

### 2️⃣ Instalar Dependencias

```bash
cd admin
npm install
npm run build
```

### 3️⃣ Activar el Plugin

- WordPress Admin → Plugins
- Busca "Agricultor Custom Admin"
- Click "Activate"

## 🚀 Primeros Pasos

### Acceder al Dashboard

1. En el menú lateral de WordPress, verás "Dashboard"
2. Click para acceder al panel personalizado
3. ¡Ya estás dentro!

### Configurar Contacto (2 minutos)

1. Click en "Contact Info"
2. Llena:
   - Email (requerido)
   - Teléfono
   - WhatsApp
   - Dirección
   - Redes sociales

3. Click "Save Changes"

### Personalizar Colores (1 minuto)

1. Click en "Customize Theme"
2. Selecciona colores con los botones de color
3. Visualiza cambios en el panel derecho
4. Click "Save Changes"

### Agregar Primera Imagen (2 minutos)

1. Click en "Manage Images"
2. Click "+ Add Image"
3. Llena:
   - Título
   - URL de la imagen (debe estar en internet)
   - Tipo (Hero, Logo o Gallery)
   - Alt Text

4. Click "Add Image"

## 📱 Usar en Tu Tema

En tu theme, obtén datos así:

```php
<?php
// Obtener información de contacto
$contact = Agricultor_Frontend::get_contact_info();
echo $contact['email'];

// Obtener logo
$logo = Agricultor_Frontend::get_logo_image();
echo '<img src="' . $logo . '">';

// Obtener galería
$gallery = Agricultor_Frontend::get_gallery_images();
foreach ($gallery as $img) {
    echo '<img src="' . $img['url'] . '" alt="' . $img['alt'] . '">';
}

// Formulario de contacto
Agricultor_Frontend::render_contact_form();
?>
```

## 🎨 Personalizar Dashboard

### Cambiar Colores del Dashboard

En `admin/tailwind.config.js`:

```js
colors: {
    primary: {
        500: '#2D5016',  // Cambia esto
    },
    secondary: {
        500: '#7CB342',  // O esto
    },
}
```

Luego recompila:

```bash
cd admin
npm run build
```

## 🐛 Si Algo Falla

| Problema | Solución |
|----------|----------|
| Dashboard no carga | `npm run build` en carpeta `admin/` |
| Cambios no se guardan | Verifica permisos (debe ser Admin) |
| Imágenes rotas | Verifica que URL sea accesible en el navegador |
| npm install falla | `npm cache clean --force` y vuelve a intentar |

## 📚 Documentación Completa

- **[README.md](README.md)** - Guía completa del plugin
- **[INSTALLATION.md](INSTALLATION.md)** - Instalación detallada
- **[TEMPLATE_EXAMPLES.md](TEMPLATE_EXAMPLES.md)** - Ejemplos de código para themes

## 🎯 Checklist de Configuración

- [ ] Plugin activado
- [ ] Información de contacto configurada
- [ ] Tema personalizado (colores)
- [ ] Al menos una imagen agregada
- [ ] Formulario de contacto en una página
- [ ] Probado en mobile

## ✨ Tips

- 💡 Las URLs de imágenes deben estar en internet (no locales)
- 💡 El formulario envía emails automáticamente
- 💡 Los cambios de tema se aplican al instante
- 💡 Todos los datos se guardan en WordPress automáticamente

## 🆘 Necesitas Ayuda?

1. Revisa el [README.md](README.md)
2. Abre un [Issue en GitHub](https://github.com/DanieGT0/Agricultor-/issues)
3. Revisa `/wp-content/debug.log` para errores

---

¡Listo! Ahora tienes un dashboard personalizado para tu sitio WordPress.

**Siguiente**: Lee el [README.md](README.md) para más información.
