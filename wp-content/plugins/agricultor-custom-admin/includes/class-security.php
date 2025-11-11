<?php
/**
 * Clase para seguridad y validaciones
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Security {

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
     * Validar email
     *
     * @param string $email
     * @return bool|string Email si es válido, false si no
     */
    public static function validate_email($email) {
        if (empty($email)) {
            return false;
        }

        if (!is_email($email)) {
            return false;
        }

        return sanitize_email($email);
    }

    /**
     * Validar teléfono
     *
     * @param string $phone
     * @return bool|string Teléfono si es válido, false si no
     */
    public static function validate_phone($phone) {
        if (empty($phone)) {
            return false;
        }

        // Permitir solo números, +, -, paréntesis y espacios
        if (!preg_match('/^[\+\-\(\)\s\d]+$/', $phone)) {
            return false;
        }

        return sanitize_text_field($phone);
    }

    /**
     * Validar URL
     *
     * @param string $url
     * @return bool|string URL si es válida, false si no
     */
    public static function validate_url($url) {
        if (empty($url)) {
            return false;
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        return esc_url_raw($url);
    }

    /**
     * Validar color hexadecimal
     *
     * @param string $color
     * @return bool|string Color si es válido, false si no
     */
    public static function validate_hex_color($color) {
        if (empty($color)) {
            return false;
        }

        if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return false;
        }

        return sanitize_hex_color($color);
    }

    /**
     * Validar coordenada geográfica (latitud/longitud)
     *
     * @param float $value
     * @param string $type 'latitude' o 'longitude'
     * @return bool|float Valor si es válido, false si no
     */
    public static function validate_coordinate($value, $type = 'latitude') {
        if (empty($value) || !is_numeric($value)) {
            return false;
        }

        $value = floatval($value);

        if ($type === 'latitude') {
            // Latitud: -90 a 90
            if ($value < -90 || $value > 90) {
                return false;
            }
        } elseif ($type === 'longitude') {
            // Longitud: -180 a 180
            if ($value < -180 || $value > 180) {
                return false;
            }
        }

        return $value;
    }

    /**
     * Sanitizar texto general
     *
     * @param string $text
     * @return string
     */
    public static function sanitize_text($text) {
        return sanitize_text_field($text);
    }

    /**
     * Sanitizar HTML/textarea
     *
     * @param string $html
     * @return string
     */
    public static function sanitize_html($html) {
        return wp_kses_post($html);
    }

    /**
     * Validar y sanitizar configuración de contacto
     *
     * @param array $config
     * @return array|WP_Error
     */
    public static function validate_contact_config($config) {
        $validated = array();
        $errors = new WP_Error();

        // Teléfono
        if (!empty($config['phone'])) {
            $validated['phone'] = self::validate_phone($config['phone']);
            if (!$validated['phone']) {
                $errors->add('invalid_phone', __('Invalid phone number format', 'agricultor-custom-admin'));
            }
        } else {
            $validated['phone'] = '';
        }

        // WhatsApp
        if (!empty($config['whatsapp'])) {
            $validated['whatsapp'] = self::validate_phone($config['whatsapp']);
            if (!$validated['whatsapp']) {
                $errors->add('invalid_whatsapp', __('Invalid WhatsApp number format', 'agricultor-custom-admin'));
            }
        } else {
            $validated['whatsapp'] = '';
        }

        // Email
        if (!empty($config['email'])) {
            $validated['email'] = self::validate_email($config['email']);
            if (!$validated['email']) {
                $errors->add('invalid_email', __('Invalid email address', 'agricultor-custom-admin'));
            }
        } else {
            $validated['email'] = '';
        }

        // Dirección
        if (!empty($config['address'])) {
            $validated['address'] = self::sanitize_text($config['address']);
        } else {
            $validated['address'] = '';
        }

        // Latitud
        if (!empty($config['latitude'])) {
            $validated['latitude'] = self::validate_coordinate($config['latitude'], 'latitude');
            if ($validated['latitude'] === false) {
                $errors->add('invalid_latitude', __('Invalid latitude', 'agricultor-custom-admin'));
            }
        } else {
            $validated['latitude'] = '';
        }

        // Longitud
        if (!empty($config['longitude'])) {
            $validated['longitude'] = self::validate_coordinate($config['longitude'], 'longitude');
            if ($validated['longitude'] === false) {
                $errors->add('invalid_longitude', __('Invalid longitude', 'agricultor-custom-admin'));
            }
        } else {
            $validated['longitude'] = '';
        }

        // Redes sociales
        $validated['social_media'] = array();
        $social_platforms = array('facebook', 'instagram', 'linkedin', 'twitter');

        foreach ($social_platforms as $platform) {
            if (!empty($config['social_media'][$platform])) {
                $validated['social_media'][$platform] = self::validate_url($config['social_media'][$platform]);
                if (!$validated['social_media'][$platform]) {
                    $errors->add(
                        'invalid_' . $platform,
                        sprintf(__('Invalid %s URL', 'agricultor-custom-admin'), ucfirst($platform))
                    );
                }
            } else {
                $validated['social_media'][$platform] = '';
            }
        }

        if ($errors->has_errors()) {
            return $errors;
        }

        return $validated;
    }

    /**
     * Validar y sanitizar configuración de tema
     *
     * @param array $config
     * @return array|WP_Error
     */
    public static function validate_theme_config($config) {
        $validated = array();
        $errors = new WP_Error();

        // Color primario
        if (!empty($config['primary_color'])) {
            $validated['primary_color'] = self::validate_hex_color($config['primary_color']);
            if (!$validated['primary_color']) {
                $errors->add('invalid_primary_color', __('Invalid primary color', 'agricultor-custom-admin'));
            }
        } else {
            $validated['primary_color'] = '#2D5016';
        }

        // Color secundario
        if (!empty($config['secondary_color'])) {
            $validated['secondary_color'] = self::validate_hex_color($config['secondary_color']);
            if (!$validated['secondary_color']) {
                $errors->add('invalid_secondary_color', __('Invalid secondary color', 'agricultor-custom-admin'));
            }
        } else {
            $validated['secondary_color'] = '#7CB342';
        }

        // Color de texto
        if (!empty($config['text_color'])) {
            $validated['text_color'] = self::validate_hex_color($config['text_color']);
            if (!$validated['text_color']) {
                $errors->add('invalid_text_color', __('Invalid text color', 'agricultor-custom-admin'));
            }
        } else {
            $validated['text_color'] = '#333333';
        }

        // Color de fondo
        if (!empty($config['bg_color'])) {
            $validated['bg_color'] = self::validate_hex_color($config['bg_color']);
            if (!$validated['bg_color']) {
                $errors->add('invalid_bg_color', __('Invalid background color', 'agricultor-custom-admin'));
            }
        } else {
            $validated['bg_color'] = '#FFFFFF';
        }

        // Font family
        if (!empty($config['font_family'])) {
            $validated['font_family'] = self::sanitize_text($config['font_family']);
        } else {
            $validated['font_family'] = "'Inter', sans-serif";
        }

        if ($errors->has_errors()) {
            return $errors;
        }

        return $validated;
    }

    /**
     * Validar submission de formulario de contacto
     *
     * @param array $data
     * @return array|WP_Error
     */
    public static function validate_form_submission($data) {
        $validated = array();
        $errors = new WP_Error();

        // Nombre - requerido
        if (empty($data['name'])) {
            $errors->add('empty_name', __('Name is required', 'agricultor-custom-admin'));
        } else {
            $validated['name'] = self::sanitize_text($data['name']);
        }

        // Email - requerido y válido
        if (empty($data['email'])) {
            $errors->add('empty_email', __('Email is required', 'agricultor-custom-admin'));
        } else {
            $validated['email'] = self::validate_email($data['email']);
            if (!$validated['email']) {
                $errors->add('invalid_email', __('Invalid email address', 'agricultor-custom-admin'));
            }
        }

        // Teléfono - opcional pero si se proporciona debe ser válido
        if (!empty($data['phone'])) {
            $validated['phone'] = self::validate_phone($data['phone']);
            if (!$validated['phone']) {
                $errors->add('invalid_phone', __('Invalid phone number format', 'agricultor-custom-admin'));
            }
        } else {
            $validated['phone'] = '';
        }

        // Asunto - requerido
        if (empty($data['subject'])) {
            $errors->add('empty_subject', __('Subject is required', 'agricultor-custom-admin'));
        } else {
            $validated['subject'] = self::sanitize_text($data['subject']);
        }

        // Mensaje - requerido
        if (empty($data['message'])) {
            $errors->add('empty_message', __('Message is required', 'agricultor-custom-admin'));
        } else {
            $validated['message'] = self::sanitize_html($data['message']);
        }

        if ($errors->has_errors()) {
            return $errors;
        }

        return $validated;
    }

    /**
     * Verificar nonce
     *
     * @param string $nonce
     * @param string $action
     * @return bool
     */
    public static function verify_nonce($nonce, $action = 'wp_rest') {
        return wp_verify_nonce($nonce, $action) !== false;
    }

    /**
     * Obtener nonce para AJAX/REST
     *
     * @param string $action
     * @return string
     */
    public static function get_nonce($action = 'wp_rest') {
        return wp_create_nonce($action);
    }
}
