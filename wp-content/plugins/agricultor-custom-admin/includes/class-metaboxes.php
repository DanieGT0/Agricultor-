<?php
/**
 * Clase para registrar metaboxes personalizados
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Metaboxes {

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
     * Registrar metaboxes
     */
    public function register_metaboxes() {
        // Los metaboxes se manejan a través de REST API
        // Este archivo está aquí para futuras extensiones
        add_action('add_meta_boxes', array($this, 'add_image_metaboxes'));
    }

    /**
     * Agregar metabox para imágenes
     */
    public function add_image_metaboxes() {
        add_meta_box(
            'agricultor_image_meta',
            __('Image Details', 'agricultor-custom-admin'),
            array($this, 'render_image_metabox'),
            'site_images',
            'normal',
            'default'
        );
    }

    /**
     * Renderizar metabox de imágenes
     */
    public function render_image_metabox($post) {
        $image_url = get_post_meta($post->ID, '_image_url', true);
        $image_type = get_post_meta($post->ID, '_image_type', true);
        $image_alt = get_post_meta($post->ID, '_image_alt', true);
        $image_order = get_post_meta($post->ID, '_image_order', true);

        wp_nonce_field('agricultor_image_nonce', 'agricultor_image_nonce');

        echo '<div style="padding: 10px;">';

        // URL de imagen
        echo '<div style="margin-bottom: 15px;">';
        echo '<label for="image_url"><strong>' . esc_html__('Image URL', 'agricultor-custom-admin') . '</strong></label><br>';
        echo '<input type="url" id="image_url" name="image_url" value="' . esc_attr($image_url) . '" style="width: 100%; padding: 8px;" />';
        echo '</div>';

        // Tipo de imagen
        echo '<div style="margin-bottom: 15px;">';
        echo '<label for="image_type"><strong>' . esc_html__('Image Type', 'agricultor-custom-admin') . '</strong></label><br>';
        echo '<select id="image_type" name="image_type" style="width: 100%; padding: 8px;">';
        echo '<option value="hero" ' . selected($image_type, 'hero', false) . '>' . esc_html__('Hero', 'agricultor-custom-admin') . '</option>';
        echo '<option value="logo" ' . selected($image_type, 'logo', false) . '>' . esc_html__('Logo', 'agricultor-custom-admin') . '</option>';
        echo '<option value="gallery" ' . selected($image_type, 'gallery', false) . '>' . esc_html__('Gallery', 'agricultor-custom-admin') . '</option>';
        echo '</select>';
        echo '</div>';

        // Alt text
        echo '<div style="margin-bottom: 15px;">';
        echo '<label for="image_alt"><strong>' . esc_html__('Alt Text', 'agricultor-custom-admin') . '</strong></label><br>';
        echo '<input type="text" id="image_alt" name="image_alt" value="' . esc_attr($image_alt) . '" style="width: 100%; padding: 8px;" />';
        echo '</div>';

        // Orden
        echo '<div style="margin-bottom: 15px;">';
        echo '<label for="image_order"><strong>' . esc_html__('Display Order', 'agricultor-custom-admin') . '</strong></label><br>';
        echo '<input type="number" id="image_order" name="image_order" value="' . esc_attr($image_order) . '" style="width: 100%; padding: 8px;" />';
        echo '</div>';

        echo '</div>';
    }
}
