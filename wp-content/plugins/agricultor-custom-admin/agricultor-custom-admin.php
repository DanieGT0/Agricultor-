<?php
/**
 * Plugin Name: Agricultor Custom Admin
 * Plugin URI: https://github.com/DanieGT0/Agricultor-
 * Description: Panel administrativo personalizado para Agricultor Verde - Reemplaza el admin de WordPress con una interfaz personalizada
 * Version: 1.0.0
 * Author: Daniel Development
 * Author URI: https://github.com/DanieGT0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: agricultor-custom-admin
 * Domain Path: /languages
 * Requires: 5.0
 * Requires PHP: 8.0
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes
define('AGRICULTOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AGRICULTOR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AGRICULTOR_PLUGIN_VERSION', '1.0.0');

/**
 * Clase principal del plugin
 */
class Agricultor_Custom_Admin {

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
     * Constructor
     */
    public function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    /**
     * Cargar clases necesarias
     */
    private function load_dependencies() {
        // Cargar clases principales
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-post-types.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-rest-api.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-metaboxes.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-theme-options.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-admin-menu.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-security.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-forms.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-frontend.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-faqs.php';
        require_once AGRICULTOR_PLUGIN_DIR . 'includes/class-shortcodes.php';
    }

    /**
     * Inicializar hooks de WordPress
     */
    private function init_hooks() {
        // Activación del plugin
        register_activation_hook(__FILE__, array($this, 'activate_plugin'));

        // Desactivación del plugin
        register_deactivation_hook(__FILE__, array($this, 'deactivate_plugin'));

        // Inicializar componentes en WordPress ready
        add_action('init', array($this, 'initialize'));
        add_action('rest_api_init', array($this, 'initialize_rest_api'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));

        // Redirigir al dashboard personalizado
        add_action('admin_init', array($this, 'redirect_to_custom_admin'));
    }

    /**
     * Inicializar el plugin
     */
    public function initialize() {
        // Post Types
        Agricultor_Post_Types::get_instance()->register_post_types();

        // Metaboxes
        Agricultor_Metaboxes::get_instance()->register_metaboxes();

        // Opciones de tema
        Agricultor_Theme_Options::get_instance()->init();

        // Menú admin
        Agricultor_Admin_Menu::get_instance()->register_menu();

        // Formularios
        Agricultor_Forms::get_instance()->init();

        // Frontend
        Agricultor_Frontend::get_instance()->init();

        // FAQs
        Agricultor_FAQs::get_instance()->init();

        // Shortcodes
        Agricultor_Shortcodes::get_instance()->init();
    }

    /**
     * Inicializar REST API
     */
    public function initialize_rest_api() {
        Agricultor_REST_API::get_instance()->register_endpoints();
    }

    /**
     * Cargar scripts del admin
     */
    public function enqueue_admin_scripts($hook) {
        // Solo en nuestro dashboard personalizado y sus subpáginas
        // El hook se pasa como: "toplevel_page_agricultor-dashboard", "admin_page_agricultor-contact", etc.
        if (strpos($hook, 'agricultor') === false) {
            return;
        }

        // React app - Load as module with defer
        wp_enqueue_script(
            'agricultor-admin-app',
            AGRICULTOR_PLUGIN_URL . 'admin/dist/index.js',
            array(),
            AGRICULTOR_PLUGIN_VERSION,
            false // Load in header
        );

        // Add module and defer attributes
        wp_script_add_data('agricultor-admin-app', 'type', 'module');
        wp_script_add_data('agricultor-admin-app', 'defer', true);

        // Estilos
        wp_enqueue_style(
            'agricultor-admin-styles',
            AGRICULTOR_PLUGIN_URL . 'admin/dist/index.css',
            array(),
            AGRICULTOR_PLUGIN_VERSION
        );

        // Pasar datos a React como window variable
        echo '<script>';
        echo 'window.agricultor = ' . wp_json_encode(array(
            'apiUrl' => rest_url('agricultor/v1'),
            'nonce' => wp_create_nonce('wp_rest'),
            'siteUrl' => site_url(),
            'userId' => get_current_user_id(),
            'userName' => wp_get_current_user()->display_name,
            'userCan' => array(
                'manage_options' => current_user_can('manage_options'),
                'edit_posts' => current_user_can('edit_posts'),
            ),
        )) . ';';
        echo '</script>';
    }

    /**
     * Cargar scripts del frontend
     */
    public function enqueue_frontend_scripts() {
        // Cargar variables CSS dinámicas
        wp_enqueue_style(
            'agricultor-frontend-vars',
            AGRICULTOR_PLUGIN_URL . 'assets/css/frontend-vars.css',
            array(),
            AGRICULTOR_PLUGIN_VERSION
        );

        // Inline CSS con variables dinámicas
        $this->enqueue_dynamic_css();
    }

    /**
     * Generar y encolar CSS dinámico
     */
    private function enqueue_dynamic_css() {
        $theme_config = get_option('agricultor_theme_config', array());

        $css = ':root {';
        $css .= '--agricultor-color-primary: ' . esc_attr($theme_config['primary_color'] ?? '#2D5016') . ';';
        $css .= '--agricultor-color-secondary: ' . esc_attr($theme_config['secondary_color'] ?? '#7CB342') . ';';
        $css .= '--agricultor-color-text: ' . esc_attr($theme_config['text_color'] ?? '#333333') . ';';
        $css .= '--agricultor-color-bg: ' . esc_attr($theme_config['bg_color'] ?? '#FFFFFF') . ';';
        $css .= '--agricultor-font-family: ' . esc_attr($theme_config['font_family'] ?? "'Inter', sans-serif") . ';';
        $css .= '}';

        wp_add_inline_style('agricultor-frontend-vars', $css);
    }

    /**
     * Redirigir al dashboard personalizado
     */
    public function redirect_to_custom_admin() {
        if (!current_user_can('edit_posts')) {
            return;
        }

        // Si está en el admin pero no es nuestro dashboard
        if (is_admin() && !isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] !== 'agricultor-dashboard')) {
            // Permitir acceso solo a ciertos usuarios o roles específicos
            if (!current_user_can('manage_options')) {
                // Los editores y autores van al dashboard personalizado
                wp_redirect(admin_url('admin.php?page=agricultor-dashboard'));
                exit;
            }
        }
    }

    /**
     * Activar plugin
     */
    public function activate_plugin() {
        // Crear opciones por defecto
        if (!get_option('agricultor_contact_config')) {
            update_option('agricultor_contact_config', $this->get_default_contact_config());
        }

        if (!get_option('agricultor_theme_config')) {
            update_option('agricultor_theme_config', $this->get_default_theme_config());
        }

        // Flush rewrite rules para Custom Post Types
        flush_rewrite_rules();
    }

    /**
     * Desactivar plugin
     */
    public function deactivate_plugin() {
        flush_rewrite_rules();
    }

    /**
     * Configuración por defecto de contacto
     */
    private function get_default_contact_config() {
        return array(
            'phone' => '',
            'whatsapp' => '',
            'email' => get_option('admin_email'),
            'address' => '',
            'latitude' => '',
            'longitude' => '',
            'social_media' => array(
                'facebook' => '',
                'instagram' => '',
                'linkedin' => '',
                'twitter' => '',
            ),
        );
    }

    /**
     * Configuración por defecto del tema
     */
    private function get_default_theme_config() {
        return array(
            'primary_color' => '#2D5016',
            'secondary_color' => '#7CB342',
            'text_color' => '#333333',
            'bg_color' => '#FFFFFF',
            'font_family' => "'Inter', sans-serif",
        );
    }
}

// Inicializar plugin
Agricultor_Custom_Admin::get_instance();
