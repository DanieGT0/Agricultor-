<?php
/**
 * Clase para registrar bloques Gutenberg personalizados
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Gutenberg_Blocks {

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
     * Inicializar bloques
     */
    public function init() {
        add_action('init', array($this, 'register_blocks'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
        add_action('enqueue_block_assets', array($this, 'enqueue_block_assets'));
    }

    /**
     * Registrar bloques Gutenberg
     * Nota: Los bloques se registran desde blocks.js, aquí solo registramos la categoría
     */
    public function register_blocks() {
        // Registrar categoría personalizada de Agricultor
        if ( function_exists( 'register_block_category' ) ) {
            register_block_category( 'agricultor', array(
                'title' => __( 'Agricultor', 'agricultor-custom-admin' ),
                'icon' => null,
            ) );
        }

        // Registrar bloques como dinámicos para que usen los render callbacks
        register_block_type( 'agricultor/faq', array(
            'render_callback' => array( $this, 'render_faq_block' ),
            'attributes' => array(
                'category' => array( 'type' => 'string', 'default' => '' ),
                'limit' => array( 'type' => 'number', 'default' => 10 ),
                'title' => array( 'type' => 'string', 'default' => 'Preguntas Frecuentes' ),
            ),
        ) );

        register_block_type( 'agricultor/contact-form', array(
            'render_callback' => array( $this, 'render_contact_form_block' ),
        ) );

        register_block_type( 'agricultor/contact-info', array(
            'render_callback' => array( $this, 'render_contact_info_block' ),
            'attributes' => array(
                'layout' => array( 'type' => 'string', 'default' => 'vertical' ),
                'showSocial' => array( 'type' => 'boolean', 'default' => true ),
            ),
        ) );

        register_block_type( 'agricultor/map', array(
            'render_callback' => array( $this, 'render_map_block' ),
            'attributes' => array(
                'width' => array( 'type' => 'string', 'default' => '100%' ),
                'height' => array( 'type' => 'string', 'default' => '400px' ),
                'zoom' => array( 'type' => 'number', 'default' => 15 ),
            ),
        ) );

        register_block_type( 'agricultor/whatsapp', array(
            'render_callback' => array( $this, 'render_whatsapp_block' ),
            'attributes' => array(
                'position' => array( 'type' => 'string', 'default' => 'right' ),
                'message' => array( 'type' => 'string', 'default' => '' ),
            ),
        ) );
    }

    /**
     * Cargar assets de bloques en el editor
     */
    public function enqueue_block_editor_assets() {
        // Cargar el script de bloques
        wp_enqueue_script(
            'agricultor-blocks-editor',
            AGRICULTOR_PLUGIN_URL . 'blocks/blocks.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
            AGRICULTOR_PLUGIN_VERSION,
            true
        );
    }

    /**
     * Cargar assets en el front-end también
     */
    public function enqueue_block_assets() {
        // Cargar CSS del bloque en el frontend
        wp_enqueue_style(
            'agricultor-blocks-style',
            AGRICULTOR_PLUGIN_URL . 'blocks/style.css',
            array(),
            AGRICULTOR_PLUGIN_VERSION
        );
    }


    /**
     * Renderizar bloque FAQ
     */
    public function render_faq_block($attributes) {
        $category = isset($attributes['category']) ? sanitize_text_field($attributes['category']) : '';
        $limit = isset($attributes['limit']) ? absint($attributes['limit']) : 10;
        $title = isset($attributes['title']) ? sanitize_text_field($attributes['title']) : 'Preguntas Frecuentes';

        $shortcode = sprintf(
            '[agricultor_faq category="%s" limit="%d" title="%s"]',
            $category,
            $limit,
            $title
        );

        return do_shortcode($shortcode);
    }

    /**
     * Renderizar bloque Formulario de Contacto
     */
    public function render_contact_form_block($attributes) {
        return do_shortcode('[agricultor_contact_form]');
    }

    /**
     * Renderizar bloque Información de Contacto
     */
    public function render_contact_info_block($attributes) {
        $layout = isset($attributes['layout']) ? sanitize_text_field($attributes['layout']) : 'vertical';
        $show_social = isset($attributes['showSocial']) ? ($attributes['showSocial'] ? 'yes' : 'no') : 'yes';

        $shortcode = sprintf(
            '[agricultor_contact_info layout="%s" show_social="%s"]',
            $layout,
            $show_social
        );

        return do_shortcode($shortcode);
    }

    /**
     * Renderizar bloque Mapa
     */
    public function render_map_block($attributes) {
        $width = isset($attributes['width']) ? sanitize_text_field($attributes['width']) : '100%';
        $height = isset($attributes['height']) ? sanitize_text_field($attributes['height']) : '400px';
        $zoom = isset($attributes['zoom']) ? absint($attributes['zoom']) : 15;

        $shortcode = sprintf(
            '[agricultor_map width="%s" height="%s" zoom="%d"]',
            $width,
            $height,
            $zoom
        );

        return do_shortcode($shortcode);
    }

    /**
     * Renderizar bloque WhatsApp
     */
    public function render_whatsapp_block($attributes) {
        $position = isset($attributes['position']) ? sanitize_text_field($attributes['position']) : 'right';
        $message = isset($attributes['message']) ? sanitize_text_field($attributes['message']) : '';

        if (!empty($message)) {
            $shortcode = sprintf(
                '[agricultor_whatsapp_button position="%s" message="%s"]',
                $position,
                $message
            );
        } else {
            $shortcode = sprintf(
                '[agricultor_whatsapp_button position="%s"]',
                $position
            );
        }

        return do_shortcode($shortcode);
    }
}
