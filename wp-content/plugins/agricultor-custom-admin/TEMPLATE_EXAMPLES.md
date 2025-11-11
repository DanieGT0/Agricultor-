# 📝 Ejemplos de Uso en Temas de WordPress

Esta guía muestra cómo usar las funciones y datos del plugin Agricultor Custom Admin en tu tema de WordPress.

## 🌍 Información de Contacto

### Obtener Información Completa

```php
<?php
$contact = Agricultor_Frontend::get_contact_info();
?>

<div class="contact-info">
    <p>Teléfono: <?php echo esc_html($contact['phone']); ?></p>
    <p>Email: <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
        <?php echo esc_html($contact['email']); ?>
    </a></p>
    <p>Dirección: <?php echo esc_html($contact['address']); ?></p>
</div>
```

### Crear Link de WhatsApp

```php
<?php
$whatsapp_url = Agricultor_Frontend::get_whatsapp_url();
if (!empty($whatsapp_url)) {
    ?>
    <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" class="whatsapp-btn">
        💬 Contactar por WhatsApp
    </a>
    <?php
}
?>
```

### Email de Contacto

```php
<?php
$contact = Agricultor_Frontend::get_contact_info();
$email = $contact['email'];
?>

<a href="mailto:<?php echo esc_attr($email); ?>" class="email-link">
    📧 Enviar Email
</a>
```

### Ubicación en Google Maps

```php
<?php
$contact = Agricultor_Frontend::get_contact_info();
$lat = $contact['latitude'];
$lng = $contact['longitude'];
$address = $contact['address'];

if (!empty($lat) && !empty($lng)) {
    $maps_url = "https://maps.google.com/?q={$lat},{$lng}";
    ?>
    <div class="location-map">
        <h3><?php echo esc_html($address); ?></h3>
        <a href="<?php echo esc_url($maps_url); ?>" target="_blank">
            📍 Ver en Google Maps
        </a>
        <iframe
            width="100%"
            height="400"
            frameborder="0"
            src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=<?php echo urlencode($address); ?>"
        ></iframe>
    </div>
    <?php
}
?>
```

## 📱 Redes Sociales

### Mostrar Todos los Enlaces Sociales

```php
<?php
$social = Agricultor_Frontend::get_social_media();
?>

<div class="social-links">
    <?php foreach ($social as $platform => $url) : ?>
        <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-link social-<?php echo esc_attr($platform); ?>">
            <?php echo ucfirst($platform); ?>
        </a>
    <?php endforeach; ?>
</div>
```

### Mostrar Redes Específicas

```php
<?php
$facebook = Agricultor_Frontend::get_social_url('facebook');
$instagram = Agricultor_Frontend::get_social_url('instagram');
?>

<?php if (!empty($facebook)) : ?>
    <a href="<?php echo esc_url($facebook); ?>" class="facebook">
        <i class="fab fa-facebook"></i> Facebook
    </a>
<?php endif; ?>

<?php if (!empty($instagram)) : ?>
    <a href="<?php echo esc_url($instagram); ?>" class="instagram">
        <i class="fab fa-instagram"></i> Instagram
    </a>
<?php endif; ?>
```

## 🖼️ Gestión de Imágenes

### Mostrar Imagen Hero

```php
<?php
$hero = Agricultor_Frontend::get_hero_image();
if (!empty($hero)) {
    ?>
    <section class="hero" style="background-image: url('<?php echo esc_url($hero); ?>')">
        <div class="hero-content">
            <h1><?php bloginfo('name'); ?></h1>
        </div>
    </section>
    <?php
}
?>
```

### Mostrar Logo

```php
<?php
$logo = Agricultor_Frontend::get_logo_image();
if (!empty($logo)) {
    ?>
    <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo">
    <?php
}
?>
```

### Mostrar Galería

```php
<?php
$gallery = Agricultor_Frontend::get_gallery_images();
if (!empty($gallery)) {
    ?>
    <div class="gallery">
        <?php foreach ($gallery as $image) : ?>
            <div class="gallery-item">
                <img
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt']); ?>"
                    class="gallery-image"
                >
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
?>
```

### Galería con Lightbox

```php
<?php
$gallery = Agricultor_Frontend::get_gallery_images();
if (!empty($gallery)) {
    ?>
    <div class="gallery-lightbox">
        <?php foreach ($gallery as $image) : ?>
            <a href="<?php echo esc_url($image['url']); ?>" class="lightbox-link" data-lightbox="gallery">
                <img
                    src="<?php echo esc_url($image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt']); ?>"
                >
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}
?>
```

## 🎨 Personalización de Tema

### Obtener Colores del Tema

```php
<?php
$primary = Agricultor_Frontend::get_primary_color();
$secondary = Agricultor_Frontend::get_secondary_color();
?>

<style>
    :root {
        --color-primary: <?php echo esc_attr($primary); ?>;
        --color-secondary: <?php echo esc_attr($secondary); ?>;
    }
</style>
```

### Obtener Configuración Completa

```php
<?php
$theme = Agricultor_Frontend::get_theme_config();
?>

<style>
    :root {
        --primary-color: <?php echo esc_attr($theme['primary_color']); ?>;
        --secondary-color: <?php echo esc_attr($theme['secondary_color']); ?>;
        --text-color: <?php echo esc_attr($theme['text_color']); ?>;
        --bg-color: <?php echo esc_attr($theme['bg_color']); ?>;
        --font-family: <?php echo esc_attr($theme['font_family']); ?>;
    }

    body {
        color: var(--text-color);
        background-color: var(--bg-color);
        font-family: var(--font-family);
    }

    .btn-primary {
        background-color: var(--primary-color);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
    }
</style>
```

## 📧 Formularios de Contacto

### Render el Formulario incluido

```php
<?php
Agricultor_Frontend::render_contact_form();
?>
```

### Formulario Personalizado

```php
<form id="contact-form" class="agricultor-contact-form">
    <div class="form-group">
        <label for="name">Nombre *</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="phone">Teléfono</label>
        <input type="tel" id="phone" name="phone">
    </div>

    <div class="form-group">
        <label for="subject">Asunto *</label>
        <input type="text" id="subject" name="subject" required>
    </div>

    <div class="form-group">
        <label for="message">Mensaje *</label>
        <textarea id="message" name="message" rows="5" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
    <div class="form-status" style="display: none;"></div>
</form>
```

## 📋 Casos de Uso Completos

### Header con Logo, Menú y Contacto

```php
<?php
$logo = Agricultor_Frontend::get_logo_image();
$contact = Agricultor_Frontend::get_contact_info();
$social = Agricultor_Frontend::get_social_media();
?>

<header class="site-header">
    <div class="header-container">
        <!-- Logo -->
        <?php if (!empty($logo)) : ?>
            <div class="header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>
        <?php endif; ?>

        <!-- Main Navigation -->
        <nav class="main-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'fallback_cb' => '',
            ));
            ?>
        </nav>

        <!-- Contact Info -->
        <div class="header-contact">
            <?php if (!empty($contact['phone'])) : ?>
                <a href="tel:<?php echo esc_attr(str_replace(array(' ', '-', '(', ')'), '', $contact['phone'])); ?>" class="phone">
                    📞 <?php echo esc_html($contact['phone']); ?>
                </a>
            <?php endif; ?>

            <?php if (!empty($contact['whatsapp'])) : ?>
                <a href="<?php echo esc_url(Agricultor_Frontend::get_whatsapp_url()); ?>" class="whatsapp">
                    💬 WhatsApp
                </a>
            <?php endif; ?>

            <!-- Social Media -->
            <?php if (!empty($social)) : ?>
                <div class="social-icons">
                    <?php foreach ($social as $platform => $url) : ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" class="<?php echo esc_attr($platform); ?>">
                            <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
```

### Footer con Contacto y Redes Sociales

```php
<?php
$contact = Agricultor_Frontend::get_contact_info();
$social = Agricultor_Frontend::get_social_media();
?>

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Contacto</h3>
            <ul>
                <?php if (!empty($contact['phone'])) : ?>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:<?php echo esc_attr(str_replace(array(' ', '-', '(', ')'), '', $contact['phone'])); ?>">
                            <?php echo esc_html($contact['phone']); ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($contact['email'])) : ?>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                            <?php echo esc_html($contact['email']); ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($contact['address'])) : ?>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo esc_html($contact['address']); ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Síguenos</h3>
            <div class="social-links">
                <?php foreach ($social as $platform => $url) : ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-link <?php echo esc_attr($platform); ?>">
                        <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.</p>
    </div>
</footer>
```

### Página de Contacto Completa

```php
<?php get_header(); ?>

<main class="main-content">
    <section class="contact-section">
        <div class="container">
            <h1><?php the_title(); ?></h1>

            <div class="contact-layout">
                <!-- Formulario -->
                <div class="contact-form-wrapper">
                    <h2>Envíanos un Mensaje</h2>
                    <?php Agricultor_Frontend::render_contact_form(); ?>
                </div>

                <!-- Información de Contacto -->
                <aside class="contact-info-wrapper">
                    <h2>Información de Contacto</h2>

                    <?php
                    $contact = Agricultor_Frontend::get_contact_info();
                    $social = Agricultor_Frontend::get_social_media();
                    ?>

                    <div class="contact-details">
                        <?php if (!empty($contact['phone'])) : ?>
                            <div class="contact-item">
                                <h3>📞 Teléfono</h3>
                                <a href="tel:<?php echo esc_attr(str_replace(array(' ', '-', '(', ')'), '', $contact['phone'])); ?>">
                                    <?php echo esc_html($contact['phone']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['whatsapp'])) : ?>
                            <div class="contact-item">
                                <h3>💬 WhatsApp</h3>
                                <a href="<?php echo esc_url(Agricultor_Frontend::get_whatsapp_url()); ?>" target="_blank">
                                    Contactar por WhatsApp
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['email'])) : ?>
                            <div class="contact-item">
                                <h3>📧 Email</h3>
                                <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                                    <?php echo esc_html($contact['email']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact['address'])) : ?>
                            <div class="contact-item">
                                <h3>📍 Ubicación</h3>
                                <p><?php echo esc_html($contact['address']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Redes Sociales -->
                    <?php if (!empty($social)) : ?>
                        <div class="social-media">
                            <h3>Síguenos</h3>
                            <div class="social-links">
                                <?php foreach ($social as $platform => $url) : ?>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-link">
                                        <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                                        <?php echo ucfirst($platform); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
```

## 🎯 Tips y Mejores Prácticas

### Siempre Escapear Variables

```php
<!-- ✅ Correcto -->
<?php echo esc_html($contact['phone']); ?>
<?php echo esc_url($social['facebook']); ?>
<?php echo esc_attr($contact['email']); ?>

<!-- ❌ Incorrecto -->
<?php echo $contact['phone']; ?>
<?php echo $social['facebook']; ?>
<?php echo $contact['email']; ?>
```

### Verificar si los Datos Existen

```php
<!-- ✅ Correcto -->
<?php if (!empty($contact['phone'])) : ?>
    <?php echo esc_html($contact['phone']); ?>
<?php endif; ?>

<!-- ❌ Incorrecto -->
<?php echo esc_html($contact['phone']); ?>
```

### Usar Caché para Mejor Rendimiento

```php
<?php
$contact = wp_cache_get('agricultor_contact');
if (false === $contact) {
    $contact = Agricultor_Frontend::get_contact_info();
    wp_cache_set('agricultor_contact', $contact, '', 3600); // 1 hora
}
?>
```

### Crear Funciones Helper en tu Tema

En `functions.php`:

```php
<?php
function my_theme_get_contact_phone() {
    $contact = Agricultor_Frontend::get_contact_info();
    return $contact['phone'] ?? '';
}

function my_theme_get_contact_email() {
    $contact = Agricultor_Frontend::get_contact_info();
    return $contact['email'] ?? '';
}

// Usar en templates
<?php echo esc_html(my_theme_get_contact_phone()); ?>
```

---

¡Ahora ya puedes integrar completamente el plugin Agricultor Custom Admin en tu tema de WordPress!

Para más ejemplos y documentación, visita el [README principal](README.md).
