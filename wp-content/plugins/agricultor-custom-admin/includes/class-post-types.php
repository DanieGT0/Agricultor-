<?php
/**
 * Clase para registrar Custom Post Types
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Post_Types {

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
     * Registrar todos los post types
     */
    public function register_post_types() {
        $this->register_site_images();
        $this->register_form_submissions();
    }

    /**
     * Registrar Custom Post Type para imágenes del sitio
     */
    private function register_site_images() {
        $args = array(
            'labels' => array(
                'name' => __('Site Images', 'agricultor-custom-admin'),
                'singular_name' => __('Site Image', 'agricultor-custom-admin'),
                'add_new' => __('Add New Image', 'agricultor-custom-admin'),
                'add_new_item' => __('Add New Site Image', 'agricultor-custom-admin'),
                'edit_item' => __('Edit Site Image', 'agricultor-custom-admin'),
                'new_item' => __('New Site Image', 'agricultor-custom-admin'),
                'view_item' => __('View Site Image', 'agricultor-custom-admin'),
                'search_items' => __('Search Site Images', 'agricultor-custom-admin'),
                'not_found' => __('No site images found', 'agricultor-custom-admin'),
                'not_found_in_trash' => __('No site images found in trash', 'agricultor-custom-admin'),
                'all_items' => __('All Site Images', 'agricultor-custom-admin'),
            ),
            'public' => false,
            'show_ui' => false, // Lo manejará nuestro dashboard
            'show_in_rest' => true,
            'rest_base' => 'site-images',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title', 'thumbnail', 'editor'),
            'has_archive' => false,
            'rewrite' => false,
            'menu_position' => 20,
            'show_in_menu' => false,
        );

        register_post_type('site_images', $args);
    }

    /**
     * Registrar Custom Post Type para respuestas de formularios
     */
    private function register_form_submissions() {
        $args = array(
            'labels' => array(
                'name' => __('Form Submissions', 'agricultor-custom-admin'),
                'singular_name' => __('Form Submission', 'agricultor-custom-admin'),
                'add_new' => __('Add New Submission', 'agricultor-custom-admin'),
                'add_new_item' => __('Add New Form Submission', 'agricultor-custom-admin'),
                'edit_item' => __('Edit Submission', 'agricultor-custom-admin'),
                'new_item' => __('New Submission', 'agricultor-custom-admin'),
                'view_item' => __('View Submission', 'agricultor-custom-admin'),
                'search_items' => __('Search Submissions', 'agricultor-custom-admin'),
                'not_found' => __('No submissions found', 'agricultor-custom-admin'),
                'not_found_in_trash' => __('No submissions found in trash', 'agricultor-custom-admin'),
                'all_items' => __('All Submissions', 'agricultor-custom-admin'),
            ),
            'public' => false,
            'show_ui' => false, // Lo manejará nuestro dashboard
            'show_in_rest' => true,
            'rest_base' => 'form-submissions',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title'),
            'has_archive' => false,
            'rewrite' => false,
            'menu_position' => 21,
            'show_in_menu' => false,
        );

        register_post_type('form_submissions', $args);
    }
}
