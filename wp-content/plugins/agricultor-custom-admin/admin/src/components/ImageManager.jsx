import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function ImageManager() {
    const [images, setImages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(false);
    const [showForm, setShowForm] = useState(false);

    const [formData, setFormData] = useState({
        title: '',
        image_url: '',
        type: 'gallery',
        alt: '',
        order: 0,
    });

    useEffect(() => {
        fetchImages();
    }, []);

    const fetchImages = async () => {
        try {
            setLoading(true);
            const response = await api.get('/images');
            setImages(response.data.data || []);
            setError(null);
        } catch (err) {
            setError('Failed to load images');
            console.error('Error fetching images:', err);
        } finally {
            setLoading(false);
        }
    };

    const handleFormChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    const handleAddImage = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError(null);

        try {
            await api.post('/images', formData);
            setSuccess(true);
            setFormData({
                title: '',
                image_url: '',
                type: 'gallery',
                alt: '',
                order: 0,
            });
            setShowForm(false);
            await fetchImages();
            setTimeout(() => setSuccess(false), 3000);
        } catch (err) {
            setError(err.message || 'Failed to add image');
        } finally {
            setSaving(false);
        }
    };

    const handleDeleteImage = async (id) => {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        try {
            await api.delete(`/images/${id}`);
            setSuccess(true);
            await fetchImages();
            setTimeout(() => setSuccess(false), 3000);
        } catch (err) {
            setError(err.message || 'Failed to delete image');
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
        <div className="space-y-6">
            {/* Header */}
            <div className="flex items-center justify-between">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Manage Images</h1>
                    <p className="text-gray-600 mt-2">Upload and organize images for your website</p>
                </div>
                <button
                    onClick={() => setShowForm(!showForm)}
                    className="btn btn-primary"
                >
                    + Add Image
                </button>
            </div>

            {/* Messages */}
            {success && (
                <div className="alert alert-success">
                    <p className="font-semibold">Success!</p>
                    <p>Image operation completed successfully</p>
                </div>
            )}

            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            {/* Add Image Form */}
            {showForm && (
                <div className="card space-y-4 bg-blue-50 border border-blue-200">
                    <h2 className="text-lg font-semibold text-blue-900">Add New Image</h2>

                    <form onSubmit={handleAddImage} className="space-y-4">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <FormField
                                label="Image Title"
                                type="text"
                                name="title"
                                value={formData.title}
                                onChange={handleFormChange}
                                placeholder="e.g., Farm Overview"
                                required
                            />

                            <div className="form-group">
                                <label htmlFor="type" className="form-label">
                                    Image Type
                                </label>
                                <select
                                    id="type"
                                    name="type"
                                    value={formData.type}
                                    onChange={handleFormChange}
                                    className="form-select"
                                >
                                    <option value="hero">Hero (Page header)</option>
                                    <option value="logo">Logo</option>
                                    <option value="gallery">Gallery</option>
                                </select>
                            </div>
                        </div>

                        <FormField
                            label="Image URL"
                            type="url"
                            name="image_url"
                            value={formData.image_url}
                            onChange={handleFormChange}
                            placeholder="https://example.com/image.jpg"
                            required
                        />

                        <FormField
                            label="Alt Text (for accessibility)"
                            type="text"
                            name="alt"
                            value={formData.alt}
                            onChange={handleFormChange}
                            placeholder="Describe the image"
                        />

                        <FormField
                            label="Display Order"
                            type="number"
                            name="order"
                            value={formData.order}
                            onChange={handleFormChange}
                            placeholder="0"
                        />

                        <div className="flex gap-3 pt-4">
                            <button
                                type="submit"
                                disabled={saving}
                                className="btn btn-primary"
                            >
                                {saving ? (
                                    <>
                                        <span className="spinner mr-2"></span>
                                        Saving...
                                    </>
                                ) : (
                                    'Add Image'
                                )}
                            </button>
                            <button
                                type="button"
                                onClick={() => setShowForm(false)}
                                className="btn btn-outline"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            )}

            {/* Images List */}
            {images.length === 0 ? (
                <div className="card text-center py-12">
                    <p className="text-lg text-gray-600 mb-4">No images yet</p>
                    <button
                        onClick={() => setShowForm(true)}
                        className="btn btn-primary"
                    >
                        Add Your First Image
                    </button>
                </div>
            ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {images.map((image) => (
                        <ImageCard
                            key={image.id}
                            image={image}
                            onDelete={handleDeleteImage}
                        />
                    ))}
                </div>
            )}

            {/* Info */}
            <div className="card bg-yellow-50 border border-yellow-200">
                <h3 className="font-semibold text-yellow-900 mb-2">💡 Image Tips</h3>
                <ul className="text-sm text-yellow-800 space-y-1">
                    <li>• Use external image URLs (you'll need to upload to an image service first)</li>
                    <li>• Recommended image sizes: Hero (1200x400px), Logo (300x100px), Gallery (800x600px)</li>
                    <li>• Always add alt text for accessibility and SEO</li>
                    <li>• The display order number determines how images appear on your site</li>
                </ul>
            </div>
        </div>
    );
}

function ImageCard({ image, onDelete }) {
    return (
        <div className="card overflow-hidden hover:shadow-lg transition">
            {/* Image Preview */}
            <div className="w-full h-48 bg-gray-200 overflow-hidden rounded-lg mb-4">
                <img
                    src={image.image_url}
                    alt={image.alt}
                    className="w-full h-full object-cover"
                    onError={(e) => {
                        e.target.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300"%3E%3Crect fill="%23ddd" width="400" height="300"/%3E%3Ctext x="50%25" y="50%25" font-size="24" fill="%23999" text-anchor="middle" dy=".3em"%3EImage not found%3C/text%3E%3C/svg%3E';
                    }}
                />
            </div>

            {/* Info */}
            <div className="space-y-2 mb-4">
                <h3 className="font-semibold text-gray-900">{image.title}</h3>
                <p className="text-xs text-gray-600">
                    <strong>Type:</strong> {image.type}
                </p>
                <p className="text-xs text-gray-600">
                    <strong>Alt Text:</strong> {image.alt || 'Not set'}
                </p>
                <p className="text-xs text-gray-600">
                    <strong>Order:</strong> {image.order}
                </p>
                <p className="text-xs text-gray-500 truncate">
                    <strong>URL:</strong> {image.image_url}
                </p>
            </div>

            {/* Actions */}
            <div className="flex gap-2">
                <a
                    href={image.image_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="flex-1 btn btn-outline text-sm text-center"
                >
                    View
                </a>
                <button
                    onClick={() => onDelete(image.id)}
                    className="flex-1 btn bg-red-500 text-white hover:bg-red-600 text-sm"
                >
                    Delete
                </button>
            </div>
        </div>
    );
}

function FormField({ label, type = 'text', name, value, onChange, placeholder, required = false }) {
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
                className="form-input"
            />
        </div>
    );
}
