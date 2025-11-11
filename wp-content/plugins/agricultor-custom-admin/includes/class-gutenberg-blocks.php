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
    }

    /**
     * Registrar bloques Gutenberg
     */
    public function register_blocks() {
        // Registrar bloque FAQ
        register_block_type(
            AGRICULTOR_PLUGIN_DIR . 'blocks/faq/block.json',
            array(
                'render_callback' => array($this, 'render_faq_block'),
            )
        );

        // Registrar bloque Formulario de Contacto
        register_block_type(
            AGRICULTOR_PLUGIN_DIR . 'blocks/contact-form/block.json',
            array(
                'render_callback' => array($this, 'render_contact_form_block'),
            )
        );

        // Registrar bloque Información de Contacto
        register_block_type(
            AGRICULTOR_PLUGIN_DIR . 'blocks/contact-info/block.json',
            array(
                'render_callback' => array($this, 'render_contact_info_block'),
            )
        );

        // Registrar bloque Mapa
        register_block_type(
            AGRICULTOR_PLUGIN_DIR . 'blocks/map/block.json',
            array(
                'render_callback' => array($this, 'render_map_block'),
            )
        );

        // Registrar bloque WhatsApp
        register_block_type(
            AGRICULTOR_PLUGIN_DIR . 'blocks/whatsapp/block.json',
            array(
                'render_callback' => array($this, 'render_whatsapp_block'),
            )
        );
    }

    /**
     * Cargar assets de bloques en el editor
     */
    public function enqueue_block_editor_assets() {
        wp_enqueue_style(
            'agricultor-blocks-editor-style',
            AGRICULTOR_PLUGIN_URL . 'blocks/style.css',
            array(),
            AGRICULTOR_PLUGIN_VERSION
        );

        // Cargar bloques con JavaScript inline
        $this->load_block_editor_script();
    }

    /**
     * Cargar script del editor de bloques inline
     */
    private function load_block_editor_script() {
        wp_register_script(
            'agricultor-blocks-editor',
            '',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
            AGRICULTOR_PLUGIN_VERSION
        );

        wp_enqueue_script('agricultor-blocks-editor');

        // Inline script para registrar bloques
        wp_add_inline_script('agricultor-blocks-editor', $this->get_block_editor_script());
    }

    /**
     * Obtener script de editor de bloques
     */
    private function get_block_editor_script() {
        ob_start();
        ?>
(function() {
    const { registerBlockType } = wp.blocks;
    const { InspectorControls, useBlockProps } = wp.blockEditor;
    const { PanelBody, TextControl, SelectControl, NumberControl, ToggleControl, TextareaControl } = wp.components;

    // FAQs Block
    registerBlockType('agricultor/faq', {
        edit: function({ attributes, setAttributes }) {
            const blockProps = useBlockProps();
            const categories = [
                { label: 'Todas', value: '' },
                { label: 'General', value: 'general' },
                { label: 'Productos', value: 'productos' },
                { label: 'Envíos', value: 'envios' },
                { label: 'Devoluciones', value: 'devolucion' },
                { label: 'Métodos de Pago', value: 'pago' },
                { label: 'Mi Cuenta', value: 'cuenta' },
            ];

            return wp.element.createElement(
                wp.element.Fragment,
                null,
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        { title: 'Configuración de FAQs', initialOpen: true },
                        wp.element.createElement(SelectControl, {
                            label: 'Categoría',
                            value: attributes.category || '',
                            options: categories,
                            onChange: (value) => setAttributes({ category: value }),
                        }),
                        wp.element.createElement(NumberControl, {
                            label: 'Límite de preguntas',
                            value: attributes.limit || 10,
                            onChange: (value) => setAttributes({ limit: value }),
                            min: 1,
                            max: 50,
                        }),
                        wp.element.createElement(TextControl, {
                            label: 'Título',
                            value: attributes.title || 'Preguntas Frecuentes',
                            onChange: (value) => setAttributes({ title: value }),
                            placeholder: 'Preguntas Frecuentes',
                        })
                    )
                ),
                wp.element.createElement(
                    'div',
                    blockProps,
                    wp.element.createElement(
                        'div',
                        {
                            style: {
                                padding: '20px',
                                backgroundColor: '#f0f9ff',
                                border: '2px solid #0ea5e9',
                                borderRadius: '8px',
                                textAlign: 'center'
                            }
                        },
                        wp.element.createElement('h3', { style: { margin: '0 0 10px 0', color: '#0c4a6e' } }, '❓ Preguntas Frecuentes'),
                        wp.element.createElement(
                            'p',
                            { style: { margin: '0', color: '#0c4a6e', fontSize: '14px' } },
                            'Mostrará ' + (attributes.limit || 10) + ' preguntas' + (attributes.category ? ' de la categoría "' + attributes.category + '"' : ' de todas las categorías')
                        )
                    )
                )
            );
        },
        save: function() {
            return null;
        }
    });

    // Contact Form Block
    registerBlockType('agricultor/contact-form', {
        edit: function({ attributes }) {
            const blockProps = useBlockProps();

            return wp.element.createElement(
                'div',
                blockProps,
                wp.element.createElement(
                    'div',
                    {
                        style: {
                            padding: '20px',
                            backgroundColor: '#fef3c7',
                            border: '2px solid #f59e0b',
                            borderRadius: '8px',
                            textAlign: 'center'
                        }
                    },
                    wp.element.createElement('h3', { style: { margin: '0 0 10px 0', color: '#92400e' } }, '📧 Formulario de Contacto'),
                    wp.element.createElement(
                        'p',
                        { style: { margin: '0', color: '#92400e', fontSize: '14px' } },
                        'Formulario con validación automática y envío de emails'
                    )
                )
            );
        },
        save: function() {
            return null;
        }
    });

    // Contact Info Block
    registerBlockType('agricultor/contact-info', {
        edit: function({ attributes, setAttributes }) {
            const blockProps = useBlockProps();
            const layouts = [
                { label: 'Vertical (sidebar)', value: 'vertical' },
                { label: 'Horizontal (header)', value: 'horizontal' },
                { label: 'Grid (footer)', value: 'grid' },
            ];

            return wp.element.createElement(
                wp.element.Fragment,
                null,
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        { title: 'Configuración de Contacto', initialOpen: true },
                        wp.element.createElement(SelectControl, {
                            label: 'Diseño',
                            value: attributes.layout || 'vertical',
                            options: layouts,
                            onChange: (value) => setAttributes({ layout: value }),
                        }),
                        wp.element.createElement(ToggleControl, {
                            label: 'Mostrar redes sociales',
                            checked: attributes.showSocial !== false,
                            onChange: (value) => setAttributes({ showSocial: value }),
                        })
                    )
                ),
                wp.element.createElement(
                    'div',
                    blockProps,
                    wp.element.createElement(
                        'div',
                        {
                            style: {
                                padding: '20px',
                                backgroundColor: '#dbeafe',
                                border: '2px solid #3b82f6',
                                borderRadius: '8px',
                                textAlign: 'center'
                            }
                        },
                        wp.element.createElement('h3', { style: { margin: '0 0 10px 0', color: '#1e3a8a' } }, '📞 Información de Contacto'),
                        wp.element.createElement(
                            'p',
                            { style: { margin: '0', color: '#1e3a8a', fontSize: '14px' } },
                            'Diseño: ' + (attributes.layout === 'vertical' ? 'Vertical' : attributes.layout === 'horizontal' ? 'Horizontal' : 'Grid') +
                            (attributes.showSocial !== false ? ' (con redes sociales)' : '')
                        )
                    )
                )
            );
        },
        save: function() {
            return null;
        }
    });

    // Map Block
    registerBlockType('agricultor/map', {
        edit: function({ attributes, setAttributes }) {
            const blockProps = useBlockProps();

            return wp.element.createElement(
                wp.element.Fragment,
                null,
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        { title: 'Configuración del Mapa', initialOpen: true },
                        wp.element.createElement(TextControl, {
                            label: 'Ancho',
                            value: attributes.width || '100%',
                            onChange: (value) => setAttributes({ width: value }),
                            placeholder: '100%',
                        }),
                        wp.element.createElement(TextControl, {
                            label: 'Alto',
                            value: attributes.height || '400px',
                            onChange: (value) => setAttributes({ height: value }),
                            placeholder: '400px',
                        }),
                        wp.element.createElement(NumberControl, {
                            label: 'Nivel de Zoom',
                            value: attributes.zoom || 15,
                            onChange: (value) => setAttributes({ zoom: value }),
                            min: 1,
                            max: 21,
                        })
                    )
                ),
                wp.element.createElement(
                    'div',
                    blockProps,
                    wp.element.createElement(
                        'div',
                        {
                            style: {
                                padding: '20px',
                                backgroundColor: '#ecfdf5',
                                border: '2px solid #10b981',
                                borderRadius: '8px',
                                textAlign: 'center'
                            }
                        },
                        wp.element.createElement('h3', { style: { margin: '0 0 10px 0', color: '#065f46' } }, '🗺️ Mapa de Ubicación'),
                        wp.element.createElement(
                            'p',
                            { style: { margin: '0', color: '#065f46', fontSize: '14px' } },
                            (attributes.height || '400px') + ' de alto, Zoom: ' + (attributes.zoom || 15)
                        )
                    )
                )
            );
        },
        save: function() {
            return null;
        }
    });

    // WhatsApp Block
    registerBlockType('agricultor/whatsapp', {
        edit: function({ attributes, setAttributes }) {
            const blockProps = useBlockProps();
            const positions = [
                { label: 'Esquina Derecha', value: 'right' },
                { label: 'Esquina Izquierda', value: 'left' },
            ];

            return wp.element.createElement(
                wp.element.Fragment,
                null,
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        { title: 'Configuración de WhatsApp', initialOpen: true },
                        wp.element.createElement(SelectControl, {
                            label: 'Posición',
                            value: attributes.position || 'right',
                            options: positions,
                            onChange: (value) => setAttributes({ position: value }),
                        }),
                        wp.element.createElement(TextareaControl, {
                            label: 'Mensaje predefinido (opcional)',
                            value: attributes.message || '',
                            onChange: (value) => setAttributes({ message: value }),
                            placeholder: 'Ej: Hola, tengo una pregunta...',
                            rows: 3,
                        })
                    )
                ),
                wp.element.createElement(
                    'div',
                    blockProps,
                    wp.element.createElement(
                        'div',
                        {
                            style: {
                                padding: '20px',
                                backgroundColor: '#f0fdf4',
                                border: '2px solid #22c55e',
                                borderRadius: '8px',
                                textAlign: 'center'
                            }
                        },
                        wp.element.createElement('h3', { style: { margin: '0 0 10px 0', color: '#14532d' } }, '💬 Botón WhatsApp Flotante'),
                        wp.element.createElement(
                            'p',
                            { style: { margin: '0', color: '#14532d', fontSize: '14px' } },
                            'Posición: ' + (attributes.position === 'right' ? 'Derecha' : 'Izquierda') +
                            (attributes.message ? ' - Con mensaje: "' + attributes.message.substring(0, 30) + '..."' : '')
                        )
                    )
                )
            );
        },
        save: function() {
            return null;
        }
    });
})();
        <?php
        return ob_get_clean();
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
