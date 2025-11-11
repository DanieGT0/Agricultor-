<?php
/**
 * Clase para manejar formularios de contacto
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Forms {

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
     * Inicializar formularios
     */
    public function init() {
        // Los formularios se manejan a través de REST API
        // Aquí agregamos cualquier funcionalidad adicional que sea necesaria
        add_action('wp_footer', array($this, 'enqueue_contact_form_script'));
    }

    /**
     * Encolar script para manejo de formularios en frontend
     */
    public function enqueue_contact_form_script() {
        if (!is_admin()) {
            // Script para manejo de formularios de contacto
            wp_enqueue_script(
                'agricultor-contact-form',
                AGRICULTOR_PLUGIN_URL . 'assets/js/contact-form.js',
                array('jquery'),
                AGRICULTOR_PLUGIN_VERSION,
                true
            );

            // Pasar datos necesarios al script
            wp_localize_script('agricultor-contact-form', 'agricultorForm', array(
                'apiUrl' => rest_url('agricultor/v1'),
                'nonce' => wp_create_nonce('wp_rest'),
            ));
        }
    }

    /**
     * Procesar submisión de formulario (alternativa para procesamiento no-REST)
     */
    public function process_contact_form() {
        if (!isset($_POST['agricultor_contact_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['agricultor_contact_nonce'], 'agricultor_contact_form')) {
            wp_die('Security check failed');
        }

        $data = array(
            'name' => isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '',
            'email' => isset($_POST['email']) ? sanitize_email($_POST['email']) : '',
            'phone' => isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '',
            'subject' => isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '',
            'message' => isset($_POST['message']) ? wp_kses_post($_POST['message']) : '',
        );

        // Validar
        $validated = Agricultor_Security::validate_form_submission($data);

        if (is_wp_error($validated)) {
            return $validated;
        }

        // Crear post
        $post_id = wp_insert_post(array(
            'post_type' => 'form_submissions',
            'post_title' => $validated['subject'],
            'post_status' => 'publish',
        ));

        if (is_wp_error($post_id)) {
            return new WP_Error('insert_failed', __('Error saving form submission', 'agricultor-custom-admin'));
        }

        // Guardar datos
        update_post_meta($post_id, '_submission_data', wp_json_encode($validated));

        // Enviar email
        $this->send_admin_notification($validated);
        $this->send_user_confirmation($validated);

        return true;
    }

    /**
     * Enviar notificación al admin
     */
    private function send_admin_notification($data) {
        $admin_email = get_option('admin_email');
        $subject = sprintf(__('[%s] New Contact Form Submission', 'agricultor-custom-admin'), get_bloginfo('name'));

        $message = "
<h2>New Contact Form Submission</h2>
<p><strong>Name:</strong> " . esc_html($data['name']) . "</p>
<p><strong>Email:</strong> " . esc_html($data['email']) . "</p>
<p><strong>Phone:</strong> " . esc_html($data['phone'] ?? '-') . "</p>
<p><strong>Subject:</strong> " . esc_html($data['subject']) . "</p>
<p><strong>Message:</strong></p>
<p>" . nl2br(esc_html($data['message'])) . "</p>
        ";

        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($admin_email, $subject, $message, $headers);
    }

    /**
     * Enviar confirmación al usuario
     */
    private function send_user_confirmation($data) {
        $subject = sprintf(__('Thank you for contacting %s', 'agricultor-custom-admin'), get_bloginfo('name'));

        $message = "
<h2>Thank You!</h2>
<p>Dear " . esc_html($data['name']) . ",</p>
<p>Thank you for contacting us. We have received your message and will respond as soon as possible.</p>
<p><strong>Your Message Details:</strong></p>
<p><strong>Subject:</strong> " . esc_html($data['subject']) . "</p>
<p><strong>Message:</strong></p>
<p>" . nl2br(esc_html($data['message'])) . "</p>
<p>Best regards,<br>The " . esc_html(get_bloginfo('name')) . " Team</p>
        ";

        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($data['email'], $subject, $message, $headers);
    }

    /**
     * Obtener últimas submisiones
     *
     * @param int $limit
     * @return array
     */
    public function get_recent_submissions($limit = 10) {
        $args = array(
            'post_type' => 'form_submissions',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $submissions = get_posts($args);
        $result = array();

        foreach ($submissions as $submission) {
            $data = json_decode(get_post_meta($submission->ID, '_submission_data', true), true);
            $result[] = array(
                'id' => $submission->ID,
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'subject' => $submission->post_title,
                'date' => $submission->post_date,
            );
        }

        return $result;
    }

    /**
     * Contar submisiones sin leer
     *
     * @return int
     */
    public function count_unread_submissions() {
        $args = array(
            'post_type' => 'form_submissions',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_submission_read',
                    'compare' => 'NOT EXISTS',
                ),
            ),
        );

        return count(get_posts($args));
    }
}
