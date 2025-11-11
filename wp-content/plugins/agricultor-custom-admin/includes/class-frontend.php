<?php
/**
 * Clase para manejar integración en el frontend
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Frontend {

    private static $instance = null;

    /**
     * Obtener instancia única (Singleton)
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Inicializar frontend
     */
    public function init() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_styles'));
        add_action('wp_head', array($this, 'add_theme_css'));
        add_filter('body_class', array($this, 'add_agricultor_body_class'));
    }

    /**
     * Encolar estilos del frontend
     */
    public function enqueue_frontend_styles() {
        // Cargar hoja de estilos principal
        wp_enqueue_style(
            'agricultor-frontend',
            AGRICULTOR_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            AGRICULTOR_PLUGIN_VERSION
        );
    }

    /**
     * Agregar CSS dinámico con variables de tema
     */
    public function add_theme_css() {
        $css = Agricultor_Theme_Options::get_instance()->generate_css();
        echo '<style id="agricultor-theme-vars">' . $css . '</style>';
    }

    /**
     * Agregar clase al body
     */
    public function add_agricultor_body_class($classes) {
        $classes[] = 'agricultor-theme-active';
        return $classes;
    }

    /**
     * Obtener información de contacto para usar en templates
     *
     * @return array
     */
    public static function get_contact_info() {
        return get_option('agricultor_contact_config', array());
    }

    /**
     * Obtener URL de WhatsApp para contacto
     *
     * @return string
     */
    public static function get_whatsapp_url() {
        $contact = self::get_contact_info();
        $phone = $contact['whatsapp'] ?? '';

        if (empty($phone)) {
            return '';
        }

        // Limpiar número (solo dígitos)
        $phone = preg_replace('/[^\d]/', '', $phone);

        return 'https://wa.me/' . $phone;
    }

    /**
     * Obtener enlace de contacto por email
     *
     * @return string
     */
    public static function get_email_link() {
        $contact = self::get_contact_info();
        $email = $contact['email'] ?? '';

        if (empty($email)) {
            return '';
        }

        return 'mailto:' . esc_attr($email);
    }

    /**
     * Obtener URL de red social
     *
     * @param string $platform
     * @return string
     */
    public static function get_social_url($platform) {
        $contact = self::get_contact_info();
        $social_media = $contact['social_media'] ?? array();

        return $social_media[$platform] ?? '';
    }

    /**
     * Obtener todas las redes sociales configuradas
     *
     * @return array
     */
    public static function get_social_media() {
        $contact = self::get_contact_info();
        $social_media = $contact['social_media'] ?? array();

        $configured = array();
        foreach ($social_media as $platform => $url) {
            if (!empty($url)) {
                $configured[$platform] = $url;
            }
        }

        return $configured;
    }

    /**
     * Obtener imágenes del sitio
     *
     * @param string $type Filtrar por tipo (hero, logo, gallery)
     * @return array
     */
    public static function get_site_images($type = null) {
        $args = array(
            'post_type' => 'site_images',
            'posts_per_page' => -1,
            'orderby' => 'meta_value_num',
            'meta_key' => '_image_order',
            'order' => 'ASC',
        );

        if (!empty($type)) {
            $args['meta_query'] = array(
                array(
                    'key' => '_image_type',
                    'value' => $type,
                ),
            );
        }

        $images = get_posts($args);
        $result = array();

        foreach ($images as $image) {
            $result[] = array(
                'id' => $image->ID,
                'title' => $image->post_title,
                'url' => get_post_meta($image->ID, '_image_url', true),
                'type' => get_post_meta($image->ID, '_image_type', true),
                'alt' => get_post_meta($image->ID, '_image_alt', true),
                'order' => get_post_meta($image->ID, '_image_order', true),
            );
        }

        return $result;
    }

    /**
     * Obtener imagen de hero
     *
     * @return string|null URL de la imagen o null
     */
    public static function get_hero_image() {
        $images = self::get_site_images('hero');
        return !empty($images) ? $images[0]['url'] : null;
    }

    /**
     * Obtener logo del sitio
     *
     * @return string|null URL del logo o null
     */
    public static function get_logo_image() {
        $images = self::get_site_images('logo');
        return !empty($images) ? $images[0]['url'] : null;
    }

    /**
     * Obtener galería de imágenes
     *
     * @return array
     */
    public static function get_gallery_images() {
        return self::get_site_images('gallery');
    }

    /**
     * Obtener configuración de tema
     *
     * @return array
     */
    public static function get_theme_config() {
        return get_option('agricultor_theme_config', array());
    }

    /**
     * Obtener color primario del tema
     *
     * @return string
     */
    public static function get_primary_color() {
        $config = self::get_theme_config();
        return $config['primary_color'] ?? '#2D5016';
    }

    /**
     * Obtener color secundario del tema
     *
     * @return string
     */
    public static function get_secondary_color() {
        $config = self::get_theme_config();
        return $config['secondary_color'] ?? '#7CB342';
    }

    /**
     * Renderizar formulario de contacto
     */
    public static function render_contact_form() {
        ?>
        <form id="agricultor-contact-form" class="agricultor-contact-form">
            <div class="form-group">
                <label for="contact-name">Name *</label>
                <input type="text" id="contact-name" name="name" required>
            </div>

            <div class="form-group">
                <label for="contact-email">Email *</label>
                <input type="email" id="contact-email" name="email" required>
            </div>

            <div class="form-group">
                <label for="contact-phone">Phone</label>
                <input type="tel" id="contact-phone" name="phone">
            </div>

            <div class="form-group">
                <label for="contact-subject">Subject *</label>
                <input type="text" id="contact-subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="contact-message">Message *</label>
                <textarea id="contact-message" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
            <div class="form-status" style="display: none;"></div>
        </form>
        <?php
    }
}
