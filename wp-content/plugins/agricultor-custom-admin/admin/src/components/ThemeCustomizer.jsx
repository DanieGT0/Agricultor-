import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function ThemeCustomizer() {
    const [formData, setFormData] = useState({
        primary_color: '#2D5016',
        secondary_color: '#7CB342',
        text_color: '#333333',
        bg_color: '#FFFFFF',
        font_family: "'Inter', sans-serif",
    });

    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(null);

    const fontFamilies = [
        "'Inter', sans-serif",
        "'Segoe UI', sans-serif",
        "'Arial', sans-serif",
        "'Roboto', sans-serif",
        "'Open Sans', sans-serif",
        "'Poppins', sans-serif",
        "'Playfair Display', serif",
        "'Georgia', serif",
    ];

    useEffect(() => {
        fetchThemeConfig();
    }, []);

    const fetchThemeConfig = async () => {
        try {
            setLoading(true);
            const response = await api.get('/theme');
            setFormData(response.data.data || formData);
            setError(null);
        } catch (err) {
            setError('Failed to load theme configuration');
            console.error('Error fetching theme:', err);
        } finally {
            setLoading(false);
        }
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError(null);
        setSuccess(false);

        try {
            await api.post('/theme', formData);
            setSuccess(true);

            // Actualizar variables CSS en la página
            updateCSSVariables();

            setTimeout(() => setSuccess(false), 3000);
        } catch (err) {
            setError(err.message || 'Failed to save theme configuration');
        } finally {
            setSaving(false);
        }
    };

    const updateCSSVariables = () => {
        const root = document.documentElement;
        root.style.setProperty('--agricultor-primary-color', formData.primary_color);
        root.style.setProperty('--agricultor-secondary-color', formData.secondary_color);
        root.style.setProperty('--agricultor-text-color', formData.text_color);
        root.style.setProperty('--agricultor-bg-color', formData.bg_color);
        root.style.setProperty('--agricultor-font-family', formData.font_family);
    };

    if (loading) {
        return (
            <div className="flex items-center justify-center h-64">
                <div className="spinner"></div>
            </div>
        );
    }

    return (
        <div className="space-y-6 max-w-4xl">
            {/* Header */}
            <div>
                <h1 className="text-3xl font-bold text-gray-900">Customize Theme</h1>
                <p className="text-gray-600 mt-2">
                    Change colors, fonts, and visual appearance of your website
                </p>
            </div>

            {/* Messages */}
            {success && (
                <div className="alert alert-success">
                    <p className="font-semibold">Success!</p>
                    <p>Theme configuration saved successfully</p>
                </div>
            )}

            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {/* Form */}
                <form onSubmit={handleSubmit} className="lg:col-span-2 card space-y-6">
                    {/* Colors Section */}
                    <div>
                        <h2 className="text-xl font-semibold text-primary-500 mb-4">Colors</h2>

                        <div className="space-y-6">
                            <ColorField
                                label="Primary Color"
                                description="Main brand color used for buttons and links"
                                name="primary_color"
                                value={formData.primary_color}
                                onChange={handleChange}
                            />

                            <ColorField
                                label="Secondary Color"
                                description="Supporting color for accents and highlights"
                                name="secondary_color"
                                value={formData.secondary_color}
                                onChange={handleChange}
                            />

                            <ColorField
                                label="Text Color"
                                description="Color for body text and content"
                                name="text_color"
                                value={formData.text_color}
                                onChange={handleChange}
                            />

                            <ColorField
                                label="Background Color"
                                description="Main background color for the site"
                                name="bg_color"
                                value={formData.bg_color}
                                onChange={handleChange}
                            />
                        </div>
                    </div>

                    {/* Typography Section */}
                    <div className="pt-6 border-t">
                        <h2 className="text-xl font-semibold text-primary-500 mb-4">Typography</h2>

                        <div className="form-group">
                            <label htmlFor="font_family" className="form-label">
                                Font Family
                            </label>
                            <select
                                id="font_family"
                                name="font_family"
                                value={formData.font_family}
                                onChange={handleChange}
                                className="form-select"
                            >
                                {fontFamilies.map((font) => (
                                    <option key={font} value={font}>
                                        {font}
                                    </option>
                                ))}
                            </select>
                        </div>

                        <p className="text-xs text-gray-500 bg-gray-50 p-3 rounded mt-3">
                            💡 The selected font will be applied to all text elements on your website
                        </p>
                    </div>

                    {/* Submit Buttons */}
                    <div className="pt-6 border-t flex gap-4">
                        <button
                            type="submit"
                            disabled={saving}
                            className="btn btn-primary flex-shrink-0"
                        >
                            {saving ? (
                                <>
                                    <span className="spinner mr-2"></span>
                                    Saving...
                                </>
                            ) : (
                                'Save Changes'
                            )}
                        </button>

                        <button
                            type="button"
                            onClick={fetchThemeConfig}
                            className="btn btn-outline"
                        >
                            Reset
                        </button>
                    </div>
                </form>

                {/* Preview */}
                <div className="card bg-white h-fit sticky top-6">
                    <h2 className="text-xl font-semibold mb-4">Preview</h2>

                    <div className="space-y-4">
                        {/* Color preview */}
                        <div>
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Colors</h3>
                            <div className="grid grid-cols-2 gap-3">
                                <div className="space-y-1">
                                    <div
                                        className="w-full h-16 rounded-md border border-gray-200"
                                        style={{ backgroundColor: formData.primary_color }}
                                    />
                                    <p className="text-xs text-gray-600">Primary</p>
                                </div>
                                <div className="space-y-1">
                                    <div
                                        className="w-full h-16 rounded-md border border-gray-200"
                                        style={{ backgroundColor: formData.secondary_color }}
                                    />
                                    <p className="text-xs text-gray-600">Secondary</p>
                                </div>
                                <div className="space-y-1">
                                    <div
                                        className="w-full h-16 rounded-md border border-gray-200"
                                        style={{ backgroundColor: formData.text_color }}
                                    />
                                    <p className="text-xs text-gray-600">Text</p>
                                </div>
                                <div className="space-y-1">
                                    <div
                                        className="w-full h-16 rounded-md border border-gray-200"
                                        style={{ backgroundColor: formData.bg_color }}
                                    />
                                    <p className="text-xs text-gray-600">Background</p>
                                </div>
                            </div>
                        </div>

                        {/* Typography preview */}
                        <div className="pt-4 border-t">
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Font Preview</h3>
                            <div style={{ fontFamily: formData.font_family }}>
                                <h4 className="text-lg font-bold mb-2">Heading Text</h4>
                                <p className="text-sm">
                                    This is body text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                        </div>

                        {/* Sample button */}
                        <div className="pt-4 border-t">
                            <h3 className="text-sm font-medium text-gray-700 mb-2">Button Preview</h3>
                            <button
                                style={{ backgroundColor: formData.primary_color }}
                                className="w-full text-white py-2 rounded-md font-medium transition hover:opacity-90"
                            >
                                Sample Button
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

function ColorField({ label, description, name, value, onChange }) {
    return (
        <div>
            <div className="flex items-center gap-4">
                <div className="flex-1">
                    <label htmlFor={name} className="form-label">
                        {label}
                    </label>
                    <p className="text-xs text-gray-500 mt-1">{description}</p>
                </div>
                <div className="flex items-center gap-2">
                    <input
                        id={name}
                        type="color"
                        name={name}
                        value={value}
                        onChange={onChange}
                        className="w-16 h-12 rounded-md cursor-pointer border-2 border-gray-300"
                    />
                    <input
                        type="text"
                        value={value}
                        onChange={onChange}
                        name={name}
                        className="form-input w-24 text-center text-sm"
                    />
                </div>
            </div>
        </div>
    );
}
