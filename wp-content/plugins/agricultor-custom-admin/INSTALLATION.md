# 📖 Guía de Instalación - Agricultor Custom Admin

Esta guía te llevará paso a paso por la instalación y configuración del plugin Agricultor Custom Admin.

## 📋 Pre-requisitos

Antes de comenzar, asegúrate de tener:

- **WordPress 5.0 o superior** instalado y funcionando
- **PHP 8.0 o superior**
- **Node.js 16+** instalado en tu computadora
- **npm** (viene con Node.js) o **yarn**
- Acceso a la carpeta `wp-content/plugins` de tu instalación de WordPress

## ✅ Verificar Pre-requisitos

### Verificar la versión de WordPress

1. Accede a WordPress Admin
2. Ve a **Dashboard → About WordPress**
3. Busca el número de versión (debe ser 5.0 o superior)

### Verificar la versión de PHP

1. Ve a **Tools → Site Health** en WordPress Admin
2. Busca "PHP version" (debe ser 8.0 o superior)

Alternativa: Crea un archivo `phpinfo.php` en la raíz de WordPress con el contenido:
```php
<?php phpinfo(); ?>
```
Accede a `tudominio.com/phpinfo.php` y busca "PHP Version"

### Verificar Node.js y npm

Abre una terminal/consola y ejecuta:

```bash
node --version    # Debe mostrar v16 o superior
npm --version     # Debe mostrar versión 8 o superior
```

Si no tienes Node.js instalado, descárgalo desde [nodejs.org](https://nodejs.org/)

## 🚀 Pasos de Instalación

### Paso 1: Descargar el Plugin

#### Opción A: Usar Git (Recomendado)

Si tienes git instalado:

```bash
cd wp-content/plugins
git clone https://github.com/DanieGT0/Agricultor-.git agricultor-custom-admin
cd agricultor-custom-admin
```

#### Opción B: Descargar como ZIP

1. Ve a [GitHub Repository](https://github.com/DanieGT0/Agricultor-)
2. Click en **Code → Download ZIP**
3. Extrae el archivo ZIP en `wp-content/plugins/`
4. Renombra la carpeta a `agricultor-custom-admin`

### Paso 2: Instalar Dependencias de Node.js

Abre una terminal en la carpeta del plugin y navega a la subcarpeta `admin`:

```bash
cd admin
npm install
```

Esto descargará todas las dependencias necesarias de React, Vite, Tailwind CSS, etc.

Este proceso puede tomar varios minutos. Espera a que termine.

### Paso 3: Compilar el Frontend React

Una vez instaladas las dependencias, compila el frontend:

```bash
npm run build
```

Verás un output similar a:

```
vite v5.0.0 building for production...
✓ 234 modules transformed.
dist/index.js    125.34 kB │ gzip: 34.55 kB
dist/index.css   45.67 kB │ gzip: 8.23 kB
✓ build complete in 3.45s.
```

Si ves un checkmark (✓), ¡la compilación fue exitosa!

### Paso 4: Activar el Plugin en WordPress

1. Accede a **WordPress Admin**
2. Ve a **Plugins → Installed Plugins**
3. Busca "Agricultor Custom Admin" en la lista
4. Haz click en **Activate**

Verás un mensaje de confirmación: "Plugin activated successfully."

### Paso 5: Verificar la Instalación

1. En el menú lateral de WordPress, deberías ver un nuevo elemento: **Dashboard**
2. Haz click en **Dashboard**
3. Deberías ver el dashboard personalizado con estadísticas y opciones de menú

¡Si ves esto, ¡la instalación fue exitosa! 🎉

## 🔧 Configuración Post-Instalación

### Configurar Información de Contacto

1. En el Dashboard personalizado, click en **Contact Info**
2. Completa los campos:
   - Email de contacto (requerido)
   - Número de teléfono
   - Número de WhatsApp
   - Dirección física
   - Coordenadas (latitud/longitud) - opcional para mapas
   - Enlaces a redes sociales

3. Click en **Save Changes**

### Configurar Tema

1. Click en **Customize Theme**
2. Selecciona:
   - Color primario (usa el selector de color)
   - Color secundario
   - Color de texto
   - Color de fondo
   - Familia de fuentes

3. Visualiza los cambios en el panel de vista previa
4. Click en **Save Changes**

Los cambios se aplicarán automáticamente en todo tu sitio.

### Agregar Primeras Imágenes

1. Click en **Manage Images**
2. Click en **+ Add Image**
3. Completa:
   - **Título**: Nombre descriptivo
   - **Image URL**: Link directo a la imagen (debe estar alojada en internet)
   - **Type**: Selecciona Hero, Logo o Gallery
   - **Alt Text**: Descripción para accesibilidad
   - **Order**: Número para ordenar

4. Click en **Add Image**

## 🖼️ Preparar Imágenes

Antes de agregar imágenes al dashboard, necesitas alojarlas en un servidor externo:

### Opciones para alojar imágenes:

1. **WordPress Media Library** (Recomendado)
   - Ve a Media → Library
   - Sube la imagen
   - Copy la URL en "File URL"

2. **Servicios gratuitos**
   - Imgur.com
   - Imgbb.com
   - Cloudinary.com (con plan gratuito)

3. **CDN**
   - Cloudflare
   - Amazon S3
   - Google Cloud Storage

## 🐛 Solución de Problemas

### El dashboard no carga o muestra errores

**Problema**: Ves un error blanco o la página no carga correctamente

**Solución**:

1. Asegúrate de haber corrido `npm run build` en la carpeta `admin/`
2. Verifica que exista la carpeta `admin/dist/` con los archivos compilados
3. Abre la consola del navegador (F12) y busca errores
4. Revisa los logs de WordPress:
   - Habilita Debug Mode en `wp-config.php`:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   ```
   - Revisa `/wp-content/debug.log`

### Los cambios no se guardan

**Problema**: Al hacer click en "Save Changes", nada ocurre

**Solución**:

1. Verifica que tengas permisos suficientes (debe ser Admin o Editor)
2. Abre la consola (F12 → Network) y busca errores en las peticiones
3. Verifica que la REST API esté habilitada:
   - Ve a **Settings → Permalinks**
   - Asegúrate de que no esté usando "Plain"
4. Intenta desactivar plugins de caché temporalmente

### Las imágenes no cargan

**Problema**: Las imágenes mostradas aparecen rotas o con icono de error

**Solución**:

1. Verifica que la URL sea correcta accediendo a ella en una nueva pestaña
2. Revisa que no haya problema de CORS (si es de otro dominio)
3. Intenta con una imagen desde WordPress Media Library
4. Abre F12 (Consola) y busca errores CORS

### El formulario de contacto no funciona

**Problema**: Las respuestas del formulario no se envían

**Solución**:

1. Verifica que el servidor permita envío de emails
2. Revisa que el email configurado sea válido
3. Revisa `/wp-content/debug.log` para errores

### npm install falla

**Problema**: Error durante `npm install`

**Solución**:

1. Limpia la caché de npm:
   ```bash
   npm cache clean --force
   ```

2. Intenta de nuevo:
   ```bash
   npm install
   ```

3. Si persiste, intenta con yarn:
   ```bash
   npm install -g yarn
   yarn install
   ```

### npm run build falla

**Problema**: Error durante la compilación

**Solución**:

1. Asegúrate de estar en la carpeta `admin/`:
   ```bash
   cd wp-content/plugins/agricultor-custom-admin/admin
   ```

2. Verifica que package.json exista

3. Intenta limpiar y reinstalar:
   ```bash
   rm -rf node_modules package-lock.json
   npm install
   npm run build
   ```

## 📚 Próximos Pasos

Después de la instalación:

1. **Integra con tu Tema**: Consulta la documentación en README.md sobre cómo usar las funciones del plugin en tu tema
2. **Prueba el Formulario**: Crea un formulario de contacto en una página
3. **Personaliza**: Ajusta colores, fuentes y contenido según tu marca
4. **Capacita a Usuarios**: Enséñale a tu cliente/equipo cómo usar el dashboard

## 🆘 Necesitas Ayuda?

Si encuentras problemas:

1. **Revisa el README.md**: Contiene información detallada sobre todas las características
2. **Abre un Issue**: En el [repositorio de GitHub](https://github.com/DanieGT0/Agricultor-/issues)
3. **Verifica los Logs**: Revisa `/wp-content/debug.log`
4. **Contacta al Desarrollador**: Daniel Development

## ✨ Actualizar el Plugin en el Futuro

Si hay actualizaciones:

1. Ve a la carpeta del plugin:
   ```bash
   cd wp-content/plugins/agricultor-custom-admin
   ```

2. Si usaste Git:
   ```bash
   git pull origin main
   ```

3. Actualiza las dependencias:
   ```bash
   cd admin
   npm install
   npm run build
   ```

4. En WordPress Admin, desactiva y reactiva el plugin

---

**¿Listo?** Ahora puedes [acceder al Dashboard](README.md) y comenzar a configurar tu sitio.

**Fecha de creación**: 2024
**Versión del plugin**: 1.0.0
