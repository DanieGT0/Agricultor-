<?php
/**
 * Clase para registrar el menú de admin personalizado
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Admin_Menu {

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
     * Registrar menú de admin
     */
    public function register_menu() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    /**
     * Agregar menú de admin
     */
    public function add_admin_menu() {
        // Página principal del dashboard
        add_menu_page(
            __('Agricultor Dashboard', 'agricultor-custom-admin'),
            __('Dashboard', 'agricultor-custom-admin'),
            'edit_posts',
            'agricultor-dashboard',
            array($this, 'render_dashboard_page'),
            'dashicons-admin-home',
            2
        );

        // Subpáginas
        add_submenu_page(
            'agricultor-dashboard',
            __('Contact Information', 'agricultor-custom-admin'),
            __('Contact', 'agricultor-custom-admin'),
            'edit_posts',
            'agricultor-contact',
            array($this, 'render_placeholder')
        );

        add_submenu_page(
            'agricultor-dashboard',
            __('Theme Customizer', 'agricultor-custom-admin'),
            __('Customize Theme', 'agricultor-custom-admin'),
            'edit_posts',
            'agricultor-theme',
            array($this, 'render_placeholder')
        );

        add_submenu_page(
            'agricultor-dashboard',
            __('Manage Images', 'agricultor-custom-admin'),
            __('Images', 'agricultor-custom-admin'),
            'edit_posts',
            'agricultor-images',
            array($this, 'render_placeholder')
        );

        add_submenu_page(
            'agricultor-dashboard',
            __('Form Submissions', 'agricultor-custom-admin'),
            __('Submissions', 'agricultor-custom-admin'),
            'edit_posts',
            'agricultor-submissions',
            array($this, 'render_placeholder')
        );
    }

    /**
     * Renderizar página del dashboard
     */
    public function render_dashboard_page() {
        ?>
        <div id="agricultor-root" style="background: #f5f5f5; min-height: 100vh;"></div>
        <?php
    }

    /**
     * Renderizar página placeholder (para subpáginas)
     */
    public function render_placeholder() {
        ?>
        <div id="agricultor-root" style="background: #f5f5f5; min-height: 100vh;"></div>
        <?php
    }
}
