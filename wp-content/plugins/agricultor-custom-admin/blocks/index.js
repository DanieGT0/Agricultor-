/**
 * Registrar bloques Gutenberg personalizados para Agricultor
 */

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, NumberControl, ToggleControl, TextareaControl } from '@wordpress/components';

// ==============================
// Bloque FAQ
// ==============================
registerBlockType('agricultor/faq', {
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

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Configuración de FAQs" initialOpen={true}>
                        <SelectControl
                            label="Categoría"
                            value={attributes.category}
                            options={categories}
                            onChange={(value) => setAttributes({ category: value })}
                        />
                        <NumberControl
                            label="Límite de preguntas"
                            value={attributes.limit}
                            onChange={(value) => setAttributes({ limit: value })}
                            min={1}
                            max={50}
                        />
                        <TextControl
                            label="Título"
                            value={attributes.title}
                            onChange={(value) => setAttributes({ title: value })}
                            placeholder="Preguntas Frecuentes"
                        />
                    </PanelBody>
                </InspectorControls>

                <div {...blockProps}>
                    <div style={{
                        padding: '20px',
                        backgroundColor: '#f0f9ff',
                        border: '2px solid #0ea5e9',
                        borderRadius: '8px',
                        textAlign: 'center'
                    }}>
                        <h3 style={{ margin: '0 0 10px 0', color: '#0c4a6e' }}>❓ Preguntas Frecuentes</h3>
                        <p style={{ margin: '0', color: '#0c4a6e', fontSize: '14px' }}>
                            Mostrará {attributes.limit} preguntas
                            {attributes.category ? ` de la categoría "${attributes.category}"` : ' de todas las categorías'}
                        </p>
                    </div>
                </div>
            </>
        );
    },

    save: () => null,
});

// ==============================
// Bloque Formulario de Contacto
// ==============================
registerBlockType('agricultor/contact-form', {
    edit: ({ attributes }) => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <div style={{
                    padding: '20px',
                    backgroundColor: '#fef3c7',
                    border: '2px solid #f59e0b',
                    borderRadius: '8px',
                    textAlign: 'center'
                }}>
                    <h3 style={{ margin: '0 0 10px 0', color: '#92400e' }}>📧 Formulario de Contacto</h3>
                    <p style={{ margin: '0', color: '#92400e', fontSize: '14px' }}>
                        Formulario con validación automática y envío de emails
                    </p>
                </div>
            </div>
        );
    },

    save: () => null,
});

// ==============================
// Bloque Información de Contacto
// ==============================
registerBlockType('agricultor/contact-info', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const layouts = [
            { label: 'Vertical (sidebar)', value: 'vertical' },
            { label: 'Horizontal (header)', value: 'horizontal' },
            { label: 'Grid (footer)', value: 'grid' },
        ];

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Configuración de Contacto" initialOpen={true}>
                        <SelectControl
                            label="Diseño"
                            value={attributes.layout}
                            options={layouts}
                            onChange={(value) => setAttributes({ layout: value })}
                        />
                        <ToggleControl
                            label="Mostrar redes sociales"
                            checked={attributes.showSocial}
                            onChange={(value) => setAttributes({ showSocial: value })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div {...blockProps}>
                    <div style={{
                        padding: '20px',
                        backgroundColor: '#dbeafe',
                        border: '2px solid #3b82f6',
                        borderRadius: '8px',
                        textAlign: 'center'
                    }}>
                        <h3 style={{ margin: '0 0 10px 0', color: '#1e3a8a' }}>📞 Información de Contacto</h3>
                        <p style={{ margin: '0', color: '#1e3a8a', fontSize: '14px' }}>
                            Diseño: {attributes.layout === 'vertical' ? 'Vertical' : attributes.layout === 'horizontal' ? 'Horizontal' : 'Grid'}
                            {attributes.showSocial && ' (con redes sociales)'}
                        </p>
                    </div>
                </div>
            </>
        );
    },

    save: () => null,
});

// ==============================
// Bloque Mapa
// ==============================
registerBlockType('agricultor/map', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Configuración del Mapa" initialOpen={true}>
                        <TextControl
                            label="Ancho"
                            value={attributes.width}
                            onChange={(value) => setAttributes({ width: value })}
                            placeholder="100%"
                        />
                        <TextControl
                            label="Alto"
                            value={attributes.height}
                            onChange={(value) => setAttributes({ height: value })}
                            placeholder="400px"
                        />
                        <NumberControl
                            label="Nivel de Zoom"
                            value={attributes.zoom}
                            onChange={(value) => setAttributes({ zoom: value })}
                            min={1}
                            max={21}
                        />
                    </PanelBody>
                </InspectorControls>

                <div {...blockProps}>
                    <div style={{
                        padding: '20px',
                        backgroundColor: '#ecfdf5',
                        border: '2px solid #10b981',
                        borderRadius: '8px',
                        textAlign: 'center'
                    }}>
                        <h3 style={{ margin: '0 0 10px 0', color: '#065f46' }}>🗺️ Mapa de Ubicación</h3>
                        <p style={{ margin: '0', color: '#065f46', fontSize: '14px' }}>
                            {attributes.height} de alto, Zoom: {attributes.zoom}
                        </p>
                    </div>
                </div>
            </>
        );
    },

    save: () => null,
});

// ==============================
// Bloque WhatsApp
// ==============================
registerBlockType('agricultor/whatsapp', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();
        const positions = [
            { label: 'Esquina Derecha', value: 'right' },
            { label: 'Esquina Izquierda', value: 'left' },
        ];

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Configuración de WhatsApp" initialOpen={true}>
                        <SelectControl
                            label="Posición"
                            value={attributes.position}
                            options={positions}
                            onChange={(value) => setAttributes({ position: value })}
                        />
                        <TextareaControl
                            label="Mensaje predefinido (opcional)"
                            value={attributes.message}
                            onChange={(value) => setAttributes({ message: value })}
                            placeholder="Ej: Hola, tengo una pregunta..."
                            rows={3}
                        />
                    </PanelBody>
                </InspectorControls>

                <div {...blockProps}>
                    <div style={{
                        padding: '20px',
                        backgroundColor: '#f0fdf4',
                        border: '2px solid #22c55e',
                        borderRadius: '8px',
                        textAlign: 'center'
                    }}>
                        <h3 style={{ margin: '0 0 10px 0', color: '#14532d' }}>💬 Botón WhatsApp Flotante</h3>
                        <p style={{ margin: '0', color: '#14532d', fontSize: '14px' }}>
                            Posición: {attributes.position === 'right' ? 'Derecha' : 'Izquierda'}
                            {attributes.message && ` - Con mensaje: "${attributes.message.substring(0, 30)}..."`}
                        </p>
                    </div>
                </div>
            </>
        );
    },

    save: () => null,
});
