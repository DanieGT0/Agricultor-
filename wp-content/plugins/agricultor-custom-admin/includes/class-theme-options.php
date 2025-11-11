<?php
/**
 * Clase para manejar opciones de tema
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Theme_Options {

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
     * Inicializar opciones de tema
     */
    public function init() {
        // Asegurar que existen las opciones por defecto
        $this->ensure_defaults();
    }

    /**
     * Asegurar que existen las opciones por defecto
     */
    private function ensure_defaults() {
        if (!get_option('agricultor_theme_config')) {
            update_option('agricultor_theme_config', $this->get_default_config());
        }
    }

    /**
     * Obtener configuración por defecto
     */
    private function get_default_config() {
        return array(
            'primary_color' => '#2D5016',      // Verde principal de Agricultor
            'secondary_color' => '#7CB342',    // Verde secundario
            'text_color' => '#333333',         // Gris oscuro
            'bg_color' => '#FFFFFF',           // Blanco
            'font_family' => "'Inter', 'Segoe UI', sans-serif",
        );
    }

    /**
     * Obtener configuración actual de tema
     */
    public function get_config() {
        return get_option('agricultor_theme_config', $this->get_default_config());
    }

    /**
     * Obtener un valor específico de configuración
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null) {
        $config = $this->get_config();
        return $config[$key] ?? $default;
    }

    /**
     * Actualizar configuración de tema
     *
     * @param array $config
     * @return bool|WP_Error
     */
    public function update($config) {
        // Validar
        $validated = Agricultor_Security::validate_theme_config($config);

        if (is_wp_error($validated)) {
            return $validated;
        }

        // Guardar
        return update_option('agricultor_theme_config', $validated);
    }

    /**
     * Resetear a configuración por defecto
     */
    public function reset_to_defaults() {
        return update_option('agricultor_theme_config', $this->get_default_config());
    }

    /**
     * Generar CSS con variables de tema
     *
     * @return string
     */
    public function generate_css() {
        $config = $this->get_config();

        $css = ':root {';
        $css .= '--agricultor-primary-color: ' . esc_attr($config['primary_color']) . ';';
        $css .= '--agricultor-secondary-color: ' . esc_attr($config['secondary_color']) . ';';
        $css .= '--agricultor-text-color: ' . esc_attr($config['text_color']) . ';';
        $css .= '--agricultor-bg-color: ' . esc_attr($config['bg_color']) . ';';
        $css .= '--agricultor-font-family: ' . esc_attr($config['font_family']) . ';';
        $css .= '}';

        return $css;
    }
}
