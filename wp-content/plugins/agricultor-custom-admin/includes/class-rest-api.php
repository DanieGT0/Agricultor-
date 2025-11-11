<?php
/**
 * Clase para manejar endpoints REST API
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_REST_API {

    private static $instance = null;
    private $namespace = 'agricultor/v1';

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
     * Registrar endpoints
     */
    public function register_endpoints() {
        // Endpoints de Contacto
        register_rest_route($this->namespace, '/contact', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_contact_config'),
                'permission_callback' => array($this, 'check_permission'),
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'update_contact_config'),
                'permission_callback' => array($this, 'check_permission'),
            ),
        ));

        // Endpoints de Tema
        register_rest_route($this->namespace, '/theme', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_theme_config'),
                'permission_callback' => array($this, 'check_permission'),
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'update_theme_config'),
                'permission_callback' => array($this, 'check_permission'),
            ),
        ));

        // Endpoints de Imágenes
        register_rest_route($this->namespace, '/images', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_images'),
                'permission_callback' => array($this, 'check_permission'),
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'create_image'),
                'permission_callback' => array($this, 'check_permission'),
            ),
        ));

        register_rest_route($this->namespace, '/images/(?P<id>\d+)', array(
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array($this, 'update_image'),
                'permission_callback' => array($this, 'check_permission'),
                'args' => array(
                    'id' => array(
                        'validate_callback' => function ($param) {
                            return is_numeric($param);
                        },
                    ),
                ),
            ),
            array(
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => array($this, 'delete_image'),
                'permission_callback' => array($this, 'check_permission'),
                'args' => array(
                    'id' => array(
                        'validate_callback' => function ($param) {
                            return is_numeric($param);
                        },
                    ),
                ),
            ),
        ));

        // Endpoints de Respuestas de Formulario
        register_rest_route($this->namespace, '/submissions', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_submissions'),
                'permission_callback' => array($this, 'check_permission'),
            ),
        ));

        register_rest_route($this->namespace, '/submissions/create', array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'create_submission'),
                'permission_callback' => '__return_true', // Público
            ),
        ));

        // Endpoint de Dashboard
        register_rest_route($this->namespace, '/dashboard/stats', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_dashboard_stats'),
                'permission_callback' => array($this, 'check_permission'),
            ),
        ));
    }

    /**
     * Verificar permiso para acceder a endpoints
     */
    public function check_permission() {
        return current_user_can('edit_posts');
    }

    /**
     * Obtener configuración de contacto
     */
    public function get_contact_config(WP_REST_Request $request) {
        $config = get_option('agricultor_contact_config', array());

        return rest_ensure_response(array(
            'success' => true,
            'data' => $config,
        ));
    }

    /**
     * Actualizar configuración de contacto
     */
    public function update_contact_config(WP_REST_Request $request) {
        $data = $request->get_json_params();

        // Validar datos
        $validated = Agricultor_Security::validate_contact_config($data);

        if (is_wp_error($validated)) {
            return rest_ensure_response(array(
                'success' => false,
                'errors' => $validated->get_error_messages(),
            ));
        }

        // Guardar en base de datos
        update_option('agricultor_contact_config', $validated);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Contact configuration updated successfully', 'agricultor-custom-admin'),
            'data' => $validated,
        ));
    }

    /**
     * Obtener configuración de tema
     */
    public function get_theme_config(WP_REST_Request $request) {
        $config = get_option('agricultor_theme_config', array());

        return rest_ensure_response(array(
            'success' => true,
            'data' => $config,
        ));
    }

    /**
     * Actualizar configuración de tema
     */
    public function update_theme_config(WP_REST_Request $request) {
        $data = $request->get_json_params();

        // Validar datos
        $validated = Agricultor_Security::validate_theme_config($data);

        if (is_wp_error($validated)) {
            return rest_ensure_response(array(
                'success' => false,
                'errors' => $validated->get_error_messages(),
            ));
        }

        // Guardar en base de datos
        update_option('agricultor_theme_config', $validated);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Theme configuration updated successfully', 'agricultor-custom-admin'),
            'data' => $validated,
        ));
    }

    /**
     * Obtener todas las imágenes
     */
    public function get_images(WP_REST_Request $request) {
        $args = array(
            'post_type' => 'site_images',
            'posts_per_page' => -1,
            'orderby' => 'meta_value_num',
            'meta_key' => '_image_order',
            'order' => 'ASC',
        );

        $images = get_posts($args);
        $data = array();

        foreach ($images as $image) {
            $data[] = $this->format_image_response($image);
        }

        return rest_ensure_response(array(
            'success' => true,
            'data' => $data,
        ));
    }

    /**
     * Crear imagen
     */
    public function create_image(WP_REST_Request $request) {
        $params = $request->get_json_params();

        // Validar URL de imagen
        $image_url = Agricultor_Security::validate_url($params['image_url'] ?? '');
        if (!$image_url) {
            return rest_ensure_response(array(
                'success' => false,
                'message' => __('Invalid image URL', 'agricultor-custom-admin'),
            ));
        }

        // Crear post
        $post_id = wp_insert_post(array(
            'post_type' => 'site_images',
            'post_title' => sanitize_text_field($params['title'] ?? 'Site Image'),
            'post_status' => 'publish',
        ));

        if (is_wp_error($post_id)) {
            return rest_ensure_response(array(
                'success' => false,
                'message' => __('Error creating image', 'agricultor-custom-admin'),
            ));
        }

        // Guardar metadatos
        update_post_meta($post_id, '_image_url', $image_url);
        update_post_meta($post_id, '_image_type', sanitize_text_field($params['type'] ?? 'gallery'));
        update_post_meta($post_id, '_image_alt', sanitize_text_field($params['alt'] ?? ''));
        update_post_meta($post_id, '_image_order', absint($params['order'] ?? 0));

        $image = get_post($post_id);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Image created successfully', 'agricultor-custom-admin'),
            'data' => $this->format_image_response($image),
        ));
    }

    /**
     * Actualizar imagen
     */
    public function update_image(WP_REST_Request $request) {
        $post_id = absint($request->get_param('id'));
        $params = $request->get_json_params();

        // Verificar que el post existe
        if (!get_post($post_id)) {
            return rest_ensure_response(array(
                'success' => false,
                'message' => __('Image not found', 'agricultor-custom-admin'),
            ));
        }

        // Actualizar título
        if (!empty($params['title'])) {
            wp_update_post(array(
                'ID' => $post_id,
                'post_title' => sanitize_text_field($params['title']),
            ));
        }

        // Actualizar metadatos
        if (!empty($params['image_url'])) {
            $image_url = Agricultor_Security::validate_url($params['image_url']);
            if ($image_url) {
                update_post_meta($post_id, '_image_url', $image_url);
            }
        }

        if (isset($params['type'])) {
            update_post_meta($post_id, '_image_type', sanitize_text_field($params['type']));
        }

        if (isset($params['alt'])) {
            update_post_meta($post_id, '_image_alt', sanitize_text_field($params['alt']));
        }

        if (isset($params['order'])) {
            update_post_meta($post_id, '_image_order', absint($params['order']));
        }

        $image = get_post($post_id);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Image updated successfully', 'agricultor-custom-admin'),
            'data' => $this->format_image_response($image),
        ));
    }

    /**
     * Eliminar imagen
     */
    public function delete_image(WP_REST_Request $request) {
        $post_id = absint($request->get_param('id'));

        if (!get_post($post_id)) {
            return rest_ensure_response(array(
                'success' => false,
                'message' => __('Image not found', 'agricultor-custom-admin'),
            ));
        }

        wp_delete_post($post_id, true);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Image deleted successfully', 'agricultor-custom-admin'),
        ));
    }

    /**
     * Obtener respuestas de formularios
     */
    public function get_submissions(WP_REST_Request $request) {
        $args = array(
            'post_type' => 'form_submissions',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $submissions = get_posts($args);
        $data = array();

        foreach ($submissions as $submission) {
            $data[] = $this->format_submission_response($submission);
        }

        return rest_ensure_response(array(
            'success' => true,
            'data' => $data,
        ));
    }

    /**
     * Crear respuesta de formulario
     */
    public function create_submission(WP_REST_Request $request) {
        $data = $request->get_json_params();

        // Validar datos
        $validated = Agricultor_Security::validate_form_submission($data);

        if (is_wp_error($validated)) {
            return rest_ensure_response(array(
                'success' => false,
                'errors' => $validated->get_error_messages(),
            ));
        }

        // Crear post
        $post_id = wp_insert_post(array(
            'post_type' => 'form_submissions',
            'post_title' => $validated['subject'],
            'post_status' => 'publish',
        ));

        if (is_wp_error($post_id)) {
            return rest_ensure_response(array(
                'success' => false,
                'message' => __('Error saving form submission', 'agricultor-custom-admin'),
            ));
        }

        // Guardar datos como postmeta en JSON
        update_post_meta($post_id, '_submission_data', wp_json_encode($validated));

        // Enviar email al admin
        $this->send_submission_email($validated);

        $submission = get_post($post_id);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Form submitted successfully', 'agricultor-custom-admin'),
            'data' => $this->format_submission_response($submission),
        ));
    }

    /**
     * Obtener estadísticas del dashboard
     */
    public function get_dashboard_stats(WP_REST_Request $request) {
        $stats = array(
            'total_submissions' => wp_count_posts('form_submissions')->publish,
            'total_images' => wp_count_posts('site_images')->publish,
            'recent_submissions' => $this->get_recent_submissions_count(),
        );

        return rest_ensure_response(array(
            'success' => true,
            'data' => $stats,
        ));
    }

    /**
     * Formatear respuesta de imagen
     */
    private function format_image_response($post) {
        return array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'image_url' => get_post_meta($post->ID, '_image_url', true),
            'type' => get_post_meta($post->ID, '_image_type', true),
            'alt' => get_post_meta($post->ID, '_image_alt', true),
            'order' => get_post_meta($post->ID, '_image_order', true),
            'created_at' => $post->post_date,
        );
    }

    /**
     * Formatear respuesta de submission
     */
    private function format_submission_response($post) {
        $data = json_decode(get_post_meta($post->ID, '_submission_data', true), true);

        return array(
            'id' => $post->ID,
            'subject' => $post->post_title,
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'message' => $data['message'] ?? '',
            'submitted_at' => $post->post_date,
        );
    }

    /**
     * Enviar email de notificación
     */
    private function send_submission_email($data) {
        $admin_email = get_option('admin_email');
        $subject = sprintf(__('[%s] New Contact Form Submission: %s', 'agricultor-custom-admin'), get_bloginfo('name'), $data['subject']);

        $message = sprintf(
            __("
New contact form submission received:

Name: %s
Email: %s
Phone: %s
Subject: %s
Message:
%s
            ", 'agricultor-custom-admin'),
            $data['name'],
            $data['email'],
            $data['phone'] ?? '-',
            $data['subject'],
            $data['message']
        );

        wp_mail($admin_email, $subject, $message);
    }

    /**
     * Obtener cantidad de submissions recientes (últimos 7 días)
     */
    private function get_recent_submissions_count() {
        $args = array(
            'post_type' => 'form_submissions',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'date_query' => array(
                array(
                    'after' => '7 days ago',
                ),
            ),
        );

        return count(get_posts($args));
    }
}
