<?php
/**
 * Clase para gestionar FAQs (Preguntas Frecuentes)
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_FAQs {

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
     * Inicializar FAQs
     */
    public function init() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomy'));
        add_action('add_meta_boxes', array($this, 'add_faq_metaboxes'));
        add_action('save_post_faq', array($this, 'save_faq_metadata'));
    }

    /**
     * Registrar Custom Post Type para FAQs
     */
    public function register_post_type() {
        $args = array(
            'labels' => array(
                'name' => __('FAQs', 'agricultor-custom-admin'),
                'singular_name' => __('FAQ', 'agricultor-custom-admin'),
                'add_new' => __('Add New FAQ', 'agricultor-custom-admin'),
                'add_new_item' => __('Add New FAQ', 'agricultor-custom-admin'),
                'edit_item' => __('Edit FAQ', 'agricultor-custom-admin'),
                'new_item' => __('New FAQ', 'agricultor-custom-admin'),
                'view_item' => __('View FAQ', 'agricultor-custom-admin'),
                'search_items' => __('Search FAQs', 'agricultor-custom-admin'),
                'not_found' => __('No FAQs found', 'agricultor-custom-admin'),
                'not_found_in_trash' => __('No FAQs found in trash', 'agricultor-custom-admin'),
            ),
            'public' => false,
            'show_ui' => false, // Lo manejará el dashboard
            'show_in_rest' => true,
            'rest_base' => 'faqs',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title', 'editor'),
            'has_archive' => false,
            'rewrite' => false,
            'menu_position' => 22,
            'show_in_menu' => false,
        );

        register_post_type('faq', $args);
    }

    /**
     * Registrar taxonomía para categorizar FAQs
     */
    public function register_taxonomy() {
        $args = array(
            'labels' => array(
                'name' => __('FAQ Categories', 'agricultor-custom-admin'),
                'singular_name' => __('FAQ Category', 'agricultor-custom-admin'),
            ),
            'public' => false,
            'show_in_rest' => true,
            'rest_base' => 'faq-categories',
        );

        register_taxonomy('faq_category', 'faq', $args);
    }

    /**
     * Agregar metaboxes
     */
    public function add_faq_metaboxes() {
        add_meta_box(
            'faq_answer',
            __('Answer (Editor below contains the Question as title)', 'agricultor-custom-admin'),
            array($this, 'render_answer_metabox'),
            'faq',
            'normal',
            'default'
        );
    }

    /**
     * Renderizar metabox de respuesta
     */
    public function render_answer_metabox($post) {
        echo '<p>' . __('The main editor (below) already contains your answer. Use the title for the question.', 'agricultor-custom-admin') . '</p>';
    }

    /**
     * Guardar metadata de FAQ
     */
    public function save_faq_metadata($post_id) {
        // Los metadatos se guardan automáticamente con el contenido
    }

    /**
     * Obtener todas las FAQs
     *
     * @param string $category Filtrar por categoría (opcional)
     * @return array
     */
    public static function get_all_faqs($category = null) {
        $args = array(
            'post_type' => 'faq',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );

        if (!empty($category)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'faq_category',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            );
        }

        $faqs = get_posts($args);
        $result = array();

        foreach ($faqs as $faq) {
            $result[] = array(
                'id' => $faq->ID,
                'question' => $faq->post_title,
                'answer' => wp_kses_post($faq->post_content),
                'excerpt' => wp_trim_excerpt('', $faq->ID),
            );
        }

        return $result;
    }

    /**
     * Obtener categorías de FAQs
     */
    public static function get_faq_categories() {
        $terms = get_terms(array(
            'taxonomy' => 'faq_category',
            'hide_empty' => false,
        ));

        $categories = array();
        foreach ($terms as $term) {
            $categories[] = array(
                'id' => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
                'count' => $term->count,
            );
        }

        return $categories;
    }
}
