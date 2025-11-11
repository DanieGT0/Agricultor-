import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function FAQManager() {
    const [faqs, setFaqs] = useState([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(false);
    const [showForm, setShowForm] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const [formData, setFormData] = useState({
        question: '',
        answer: '',
        category: 'general',
        order: 0,
    });

    useEffect(() => {
        fetchFAQs();
    }, []);

    const fetchFAQs = async () => {
        try {
            setLoading(true);
            const response = await api.get('/faqs');
            setFaqs(response.data.data || []);
            setError(null);
        } catch (err) {
            setError('Failed to load FAQs');
            console.error('Error fetching FAQs:', err);
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

    const handleAddFAQ = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError(null);

        try {
            if (editingId) {
                await api.post(`/faqs/${editingId}`, formData);
                setSuccess(true);
            } else {
                await api.post('/faqs', formData);
                setSuccess(true);
            }

            setFormData({
                question: '',
                answer: '',
                category: 'general',
                order: 0,
            });
            setShowForm(false);
            setEditingId(null);
            await fetchFAQs();
            setTimeout(() => setSuccess(false), 3000);
        } catch (err) {
            setError(err.message || 'Failed to save FAQ');
        } finally {
            setSaving(false);
        }
    };

    const handleEditFAQ = (faq) => {
        setFormData({
            question: faq.question,
            answer: faq.answer,
            category: faq.category || 'general',
            order: faq.order || 0,
        });
        setEditingId(faq.id);
        setShowForm(true);
    };

    const handleDeleteFAQ = async (id) => {
        if (!confirm('Are you sure you want to delete this FAQ?')) {
            return;
        }

        try {
            await api.delete(`/faqs/${id}`);
            setSuccess(true);
            await fetchFAQs();
            setTimeout(() => setSuccess(false), 3000);
        } catch (err) {
            setError(err.message || 'Failed to delete FAQ');
        }
    };

    const handleCancel = () => {
        setShowForm(false);
        setEditingId(null);
        setFormData({
            question: '',
            answer: '',
            category: 'general',
            order: 0,
        });
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
                    <h1 className="text-3xl font-bold text-gray-900">FAQs (Preguntas Frecuentes)</h1>
                    <p className="text-gray-600 mt-2">Gestiona las preguntas frecuentes de tu sitio</p>
                </div>
                <button
                    onClick={() => setShowForm(!showForm)}
                    className="btn btn-primary"
                >
                    + Agregar FAQ
                </button>
            </div>

            {/* Messages */}
            {success && (
                <div className="alert alert-success">
                    <p className="font-semibold">Success!</p>
                    <p>FAQ operación completada exitosamente</p>
                </div>
            )}

            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            {/* Add/Edit Form */}
            {showForm && (
                <div className="card space-y-4 bg-blue-50 border border-blue-200">
                    <h2 className="text-lg font-semibold text-blue-900">
                        {editingId ? 'Editar FAQ' : 'Crear Nueva FAQ'}
                    </h2>

                    <form onSubmit={handleAddFAQ} className="space-y-4">
                        <FormField
                            label="Pregunta"
                            type="text"
                            name="question"
                            value={formData.question}
                            onChange={handleFormChange}
                            placeholder="¿Cuál es tu pregunta?"
                            required
                        />

                        <div className="form-group">
                            <label htmlFor="answer" className="form-label">
                                Respuesta (Descripción detallada)
                            </label>
                            <textarea
                                id="answer"
                                name="answer"
                                value={formData.answer}
                                onChange={handleFormChange}
                                placeholder="Escribe la respuesta completa aquí..."
                                rows="6"
                                required
                                className="form-textarea"
                            />
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div className="form-group">
                                <label htmlFor="category" className="form-label">
                                    Categoría
                                </label>
                                <select
                                    id="category"
                                    name="category"
                                    value={formData.category}
                                    onChange={handleFormChange}
                                    className="form-select"
                                >
                                    <option value="general">General</option>
                                    <option value="productos">Productos</option>
                                    <option value="envios">Envíos</option>
                                    <option value="devolucion">Devoluciones</option>
                                    <option value="pago">Métodos de Pago</option>
                                    <option value="cuenta">Mi Cuenta</option>
                                </select>
                            </div>

                            <FormField
                                label="Orden"
                                type="number"
                                name="order"
                                value={formData.order}
                                onChange={handleFormChange}
                                placeholder="0"
                            />
                        </div>

                        <div className="flex gap-3 pt-4">
                            <button
                                type="submit"
                                disabled={saving}
                                className="btn btn-primary"
                            >
                                {saving ? (
                                    <>
                                        <span className="spinner mr-2"></span>
                                        Guardando...
                                    </>
                                ) : editingId ? (
                                    'Actualizar FAQ'
                                ) : (
                                    'Crear FAQ'
                                )}
                            </button>
                            <button
                                type="button"
                                onClick={handleCancel}
                                className="btn btn-outline"
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            )}

            {/* FAQs List */}
            {faqs.length === 0 ? (
                <div className="card text-center py-12">
                    <p className="text-lg text-gray-600 mb-4">❓ No hay FAQs aún</p>
                    <button
                        onClick={() => setShowForm(true)}
                        className="btn btn-primary"
                    >
                        Crear Tu Primera FAQ
                    </button>
                </div>
            ) : (
                <div className="space-y-4">
                    {faqs.map((faq) => (
                        <div key={faq.id} className="card hover:shadow-lg transition">
                            <div className="flex items-start justify-between gap-4">
                                <div className="flex-1">
                                    <h3 className="text-xl font-semibold text-gray-900 mb-2">
                                        {faq.question}
                                    </h3>
                                    <p className="text-gray-600 mb-3 line-clamp-2">
                                        {faq.answer}
                                    </p>
                                    <div className="flex items-center gap-4 text-sm">
                                        <span className="badge badge-info">
                                            {faq.category || 'General'}
                                        </span>
                                        <span className="text-gray-500">
                                            Orden: {faq.order}
                                        </span>
                                    </div>
                                </div>

                                {/* Actions */}
                                <div className="flex gap-2">
                                    <button
                                        onClick={() => handleEditFAQ(faq)}
                                        className="btn btn-outline text-sm"
                                        title="Edit FAQ"
                                    >
                                        ✎ Editar
                                    </button>
                                    <button
                                        onClick={() => handleDeleteFAQ(faq.id)}
                                        className="btn bg-red-500 text-white hover:bg-red-600 text-sm"
                                        title="Delete FAQ"
                                    >
                                        🗑️ Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            )}

            {/* Info */}
            <div className="card bg-yellow-50 border border-yellow-200">
                <h3 className="font-semibold text-yellow-900 mb-2">💡 Tips para FAQs</h3>
                <ul className="text-sm text-yellow-800 space-y-1">
                    <li>• Organiza las FAQs por categoría para mejor acceso</li>
                    <li>• Usa un número de orden para controlar el orden de aparición</li>
                    <li>• Escribe respuestas claras y detalladas</li>
                    <li>• Las FAQs aparecerán en tu sitio con el shortcode: [agricultor_faq]</li>
                    <li>• Puedes filtrar por categoría: [agricultor_faq category="productos"]</li>
                </ul>
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
