/**
 * Bloques Gutenberg personalizados para Agricultor
 */

const { registerBlockType } = wp.blocks;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { PanelBody, TextControl, SelectControl, NumberControl, ToggleControl, TextareaControl } = wp.components;
const { Fragment } = wp.element;

console.log('Cargando bloques Agricultor...');

// ==============================
// Bloque FAQ
// ==============================
registerBlockType('agricultor/faq', {
    title: 'Preguntas Frecuentes (FAQs)',
    icon: 'editor-help',
    category: 'agricultor',
    attributes: {
        category: { type: 'string', default: '' },
        limit: { type: 'number', default: 10 },
        title: { type: 'string', default: 'Preguntas Frecuentes' }
    },
    edit: ({ attributes, setAttributes }) => {
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
            Fragment,
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
    save: () => null,
});

// ==============================
// Bloque Formulario de Contacto
// ==============================
registerBlockType('agricultor/contact-form', {
    title: 'Formulario de Contacto',
    icon: 'email',
    category: 'agricultor',
    edit: ({ attributes }) => {
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
    save: () => null,
});

// ==============================
// Bloque Información de Contacto
// ==============================
registerBlockType('agricultor/contact-info', {
    title: 'Información de Contacto',
    icon: 'phone',
    category: 'agricultor',
    attributes: {
        layout: { type: 'string', default: 'vertical' },
        showSocial: { type: 'boolean', default: true }
    },
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const layouts = [
            { label: 'Vertical (sidebar)', value: 'vertical' },
            { label: 'Horizontal (header)', value: 'horizontal' },
            { label: 'Grid (footer)', value: 'grid' },
        ];

        return wp.element.createElement(
            Fragment,
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
    save: () => null,
});

// ==============================
// Bloque Mapa
// ==============================
registerBlockType('agricultor/map', {
    title: 'Mapa de Ubicación',
    icon: 'location',
    category: 'agricultor',
    attributes: {
        width: { type: 'string', default: '100%' },
        height: { type: 'string', default: '400px' },
        zoom: { type: 'number', default: 15 }
    },
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return wp.element.createElement(
            Fragment,
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
    save: () => null,
});

// ==============================
// Bloque WhatsApp
// ==============================
registerBlockType('agricultor/whatsapp', {
    title: 'Botón WhatsApp Flotante',
    icon: 'phone',
    category: 'agricultor',
    attributes: {
        position: { type: 'string', default: 'right' },
        message: { type: 'string', default: '' }
    },
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const positions = [
            { label: 'Esquina Derecha', value: 'right' },
            { label: 'Esquina Izquierda', value: 'left' },
        ];

        return wp.element.createElement(
            Fragment,
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
    save: () => null,
});

console.log('✅ Bloques Agricultor cargados correctamente');
