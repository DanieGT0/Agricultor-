import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function ContactForm() {
    const [formData, setFormData] = useState({
        phone: '',
        whatsapp: '',
        email: '',
        address: '',
        latitude: '',
        longitude: '',
        social_media: {
            facebook: '',
            instagram: '',
            linkedin: '',
            twitter: '',
        },
    });

    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchContactInfo();
    }, []);

    const fetchContactInfo = async () => {
        try {
            setLoading(true);
            const response = await api.get('/contact');
            setFormData(response.data.data || formData);
            setError(null);
        } catch (err) {
            setError('Failed to load contact information');
            console.error('Error fetching contact:', err);
        } finally {
            setLoading(false);
        }
    };

    const handleChange = (e) => {
        const { name, value } = e.target;

        if (name.startsWith('social_')) {
            const socialKey = name.replace('social_', '');
            setFormData({
                ...formData,
                social_media: {
                    ...formData.social_media,
                    [socialKey]: value,
                },
            });
        } else {
            setFormData({
                ...formData,
                [name]: value,
            });
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError(null);
        setSuccess(false);

        try {
            await api.post('/contact', formData);
            setSuccess(true);
            setTimeout(() => setSuccess(false), 3000);
        } catch (err) {
            setError(err.message || 'Failed to save contact information');
        } finally {
            setSaving(false);
        }
    };

    if (loading) {
        return (
            <div className="flex items-center justify-center h-64">
                <div className="spinner"></div>
            </div>
        );
    }

    return (
        <div className="space-y-6 max-w-2xl">
            {/* Header */}
            <div>
                <h1 className="text-3xl font-bold text-gray-900">Contact Information</h1>
                <p className="text-gray-600 mt-2">
                    Update your business contact details and social media links
                </p>
            </div>

            {/* Messages */}
            {success && (
                <div className="alert alert-success">
                    <p className="font-semibold">Success!</p>
                    <p>Contact information saved successfully</p>
                </div>
            )}

            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            {/* Form */}
            <form onSubmit={handleSubmit} className="card space-y-6">
                {/* Basic Contact Info */}
                <div>
                    <h2 className="text-xl font-semibold text-primary-500 mb-4">Basic Information</h2>

                    <div className="space-y-4">
                        <FormField
                            label="Phone Number"
                            type="tel"
                            name="phone"
                            value={formData.phone}
                            onChange={handleChange}
                            placeholder="e.g., +503 2234 5678"
                        />

                        <FormField
                            label="WhatsApp Number"
                            type="tel"
                            name="whatsapp"
                            value={formData.whatsapp}
                            onChange={handleChange}
                            placeholder="e.g., +503 2234 5678"
                            helperText="Used to generate WhatsApp contact links"
                        />

                        <FormField
                            label="Email Address"
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            placeholder="e.g., info@agricultor.com"
                            required
                        />

                        <FormField
                            label="Physical Address"
                            type="text"
                            name="address"
                            value={formData.address}
                            onChange={handleChange}
                            placeholder="e.g., 123 Main Street, San Salvador"
                        />
                    </div>
                </div>

                {/* Location */}
                <div className="pt-6 border-t">
                    <h2 className="text-xl font-semibold text-primary-500 mb-4">Location</h2>

                    <div className="space-y-4">
                        <div className="grid grid-cols-2 gap-4">
                            <FormField
                                label="Latitude"
                                type="number"
                                name="latitude"
                                value={formData.latitude}
                                onChange={handleChange}
                                placeholder="e.g., 13.6929"
                                step="0.000001"
                            />

                            <FormField
                                label="Longitude"
                                type="number"
                                name="longitude"
                                value={formData.longitude}
                                onChange={handleChange}
                                placeholder="e.g., -89.2182"
                                step="0.000001"
                            />
                        </div>

                        <p className="text-xs text-gray-500 bg-gray-50 p-3 rounded">
                            💡 Tip: Get your coordinates from Google Maps or{' '}
                            <a
                                href="https://maps.google.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-primary-500 hover:underline"
                            >
                                maps.google.com
                            </a>
                        </p>
                    </div>
                </div>

                {/* Social Media */}
                <div className="pt-6 border-t">
                    <h2 className="text-xl font-semibold text-primary-500 mb-4">Social Media</h2>

                    <div className="space-y-4">
                        <FormField
                            label="Facebook"
                            type="url"
                            name="social_facebook"
                            value={formData.social_media.facebook}
                            onChange={handleChange}
                            placeholder="https://facebook.com/your-page"
                        />

                        <FormField
                            label="Instagram"
                            type="url"
                            name="social_instagram"
                            value={formData.social_media.instagram}
                            onChange={handleChange}
                            placeholder="https://instagram.com/your-profile"
                        />

                        <FormField
                            label="LinkedIn"
                            type="url"
                            name="social_linkedin"
                            value={formData.social_media.linkedin}
                            onChange={handleChange}
                            placeholder="https://linkedin.com/company/your-company"
                        />

                        <FormField
                            label="Twitter"
                            type="url"
                            name="social_twitter"
                            value={formData.social_media.twitter}
                            onChange={handleChange}
                            placeholder="https://twitter.com/your-profile"
                        />
                    </div>
                </div>

                {/* Submit Button */}
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
                        onClick={fetchContactInfo}
                        className="btn btn-outline"
                    >
                        Reset
                    </button>
                </div>
            </form>
        </div>
    );
}

function FormField({
    label,
    type = 'text',
    name,
    value,
    onChange,
    placeholder,
    helperText,
    required = false,
    step,
}) {
    return (
        <div className="form-group">
            <label htmlFor={name} className="form-label">
                {label} {required && <span className="text-red-500">*</span>}
            </label>
            <input
                id={name}
                type={type}
                name={name}
                value={value}
                onChange={onChange}
                placeholder={placeholder}
                required={required}
                step={step}
                className="form-input"
            />
            {helperText && (
                <p className="text-xs text-gray-500 mt-1">{helperText}</p>
            )}
        </div>
    );
}
