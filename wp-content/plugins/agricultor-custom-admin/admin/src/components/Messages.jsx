import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function Messages() {
    const [messages, setMessages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [selectedMessage, setSelectedMessage] = useState(null);
    const [filter, setFilter] = useState('all'); // all, unread, read

    useEffect(() => {
        fetchMessages();
    }, []);

    const fetchMessages = async () => {
        try {
            setLoading(true);
            const response = await api.get('/submissions');
            setMessages(response.data.data || []);
            setError(null);
        } catch (err) {
            setError('Failed to load messages');
            console.error('Error fetching messages:', err);
        } finally {
            setLoading(false);
        }
    };

    const handleReply = (email) => {
        window.location.href = `mailto:${email}`;
    };

    const filteredMessages = messages.filter(msg => {
        if (filter === 'unread') return msg.status !== 'read';
        if (filter === 'read') return msg.status === 'read';
        return true;
    });

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
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
                    <h1 className="text-3xl font-bold text-gray-900">Mensajes</h1>
                    <p className="text-gray-600 mt-2">
                        {messages.length} mensaje{messages.length !== 1 ? 's' : ''} recibido{messages.length !== 1 ? 's' : ''}
                    </p>
                </div>
                <button
                    onClick={fetchMessages}
                    className="btn btn-outline"
                    title="Refresh messages"
                >
                    🔄 Actualizar
                </button>
            </div>

            {/* Error message */}
            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            {/* Filter tabs */}
            <div className="flex gap-2 border-b border-gray-200">
                <button
                    onClick={() => setFilter('all')}
                    className={`px-4 py-2 font-medium border-b-2 transition-colors ${
                        filter === 'all'
                            ? 'border-primary-500 text-primary-500'
                            : 'border-transparent text-gray-600 hover:text-gray-900'
                    }`}
                >
                    Todos ({messages.length})
                </button>
                <button
                    onClick={() => setFilter('unread')}
                    className={`px-4 py-2 font-medium border-b-2 transition-colors ${
                        filter === 'unread'
                            ? 'border-primary-500 text-primary-500'
                            : 'border-transparent text-gray-600 hover:text-gray-900'
                    }`}
                >
                    Sin leer ({messages.filter(m => m.status !== 'read').length})
                </button>
            </div>

            {/* Messages list */}
            <div className="space-y-3">
                {filteredMessages.length === 0 ? (
                    <div className="card text-center py-12">
                        <p className="text-lg text-gray-600 mb-4">💌 No hay mensajes</p>
                        <p className="text-sm text-gray-500">Los mensajes que recibas aparecerán aquí</p>
                    </div>
                ) : (
                    <>
                        {/* Messages grid */}
                        <div className="grid gap-4">
                            {filteredMessages.map((message) => (
                                <div
                                    key={message.id}
                                    className="card hover:shadow-lg transition cursor-pointer"
                                    onClick={() => setSelectedMessage(message)}
                                >
                                    <div className="flex items-start justify-between gap-4">
                                        <div className="flex-1 min-w-0">
                                            <div className="flex items-center gap-2 mb-2">
                                                <h3 className="text-lg font-semibold text-gray-900">
                                                    {message.subject}
                                                </h3>
                                                {message.status !== 'read' && (
                                                    <span className="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                                )}
                                            </div>
                                            <p className="text-gray-700 font-medium mb-1">{message.name}</p>
                                            <p className="text-gray-600 text-sm mb-2 truncate">{message.email}</p>
                                            {message.phone && (
                                                <p className="text-gray-600 text-sm mb-2">{message.phone}</p>
                                            )}
                                            <p className="text-gray-500 text-xs">
                                                {formatDate(message.submitted_at)}
                                            </p>
                                        </div>
                                        <div className="flex gap-2 flex-shrink-0">
                                            <button
                                                onClick={(e) => {
                                                    e.stopPropagation();
                                                    handleReply(message.email);
                                                }}
                                                className="btn btn-sm btn-outline"
                                                title="Reply to message"
                                            >
                                                💬 Responder
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Message detail modal */}
                        {selectedMessage && (
                            <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                                <div className="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
                                    {/* Modal header */}
                                    <div className="sticky top-0 bg-white border-b border-gray-200 p-6 flex items-start justify-between">
                                        <div>
                                            <h2 className="text-2xl font-bold text-gray-900">
                                                {selectedMessage.subject}
                                            </h2>
                                            <p className="text-gray-600 mt-1">{selectedMessage.name}</p>
                                        </div>
                                        <button
                                            onClick={() => setSelectedMessage(null)}
                                            className="text-gray-500 hover:text-gray-700 text-2xl"
                                        >
                                            ✕
                                        </button>
                                    </div>

                                    {/* Modal content */}
                                    <div className="p-6 space-y-4">
                                        <div>
                                            <p className="text-sm font-semibold text-gray-600">De:</p>
                                            <p className="text-gray-900">{selectedMessage.name}</p>
                                        </div>

                                        <div>
                                            <p className="text-sm font-semibold text-gray-600">Email:</p>
                                            <a
                                                href={`mailto:${selectedMessage.email}`}
                                                className="text-primary-500 hover:text-primary-600"
                                            >
                                                {selectedMessage.email}
                                            </a>
                                        </div>

                                        {selectedMessage.phone && (
                                            <div>
                                                <p className="text-sm font-semibold text-gray-600">Teléfono:</p>
                                                <a
                                                    href={`tel:${selectedMessage.phone}`}
                                                    className="text-primary-500 hover:text-primary-600"
                                                >
                                                    {selectedMessage.phone}
                                                </a>
                                            </div>
                                        )}

                                        <div>
                                            <p className="text-sm font-semibold text-gray-600">Fecha:</p>
                                            <p className="text-gray-900">
                                                {formatDate(selectedMessage.submitted_at)}
                                            </p>
                                        </div>

                                        <div className="border-t border-gray-200 pt-4">
                                            <p className="text-sm font-semibold text-gray-600 mb-2">Mensaje:</p>
                                            <p className="text-gray-700 whitespace-pre-wrap leading-relaxed">
                                                {selectedMessage.message}
                                            </p>
                                        </div>
                                    </div>

                                    {/* Modal footer */}
                                    <div className="sticky bottom-0 bg-gray-50 border-t border-gray-200 p-6 flex gap-3 justify-end">
                                        <button
                                            onClick={() => setSelectedMessage(null)}
                                            className="btn btn-outline"
                                        >
                                            Cerrar
                                        </button>
                                        <button
                                            onClick={() => {
                                                handleReply(selectedMessage.email);
                                                setSelectedMessage(null);
                                            }}
                                            className="btn btn-primary"
                                        >
                                            💬 Responder por Email
                                        </button>
                                    </div>
                                </div>
                            </div>
                        )}
                    </>
                )}
            </div>

            {/* Info box */}
            <div className="card bg-blue-50 border border-blue-200">
                <h3 className="font-semibold text-blue-900 mb-2">ℹ️ Acerca de Mensajes</h3>
                <ul className="text-sm text-blue-800 space-y-1">
                    <li>• Los mensajes se guardan automáticamente cuando se envían</li>
                    <li>• Puedes responder directamente por email usando el botón "Responder"</li>
                    <li>• Los mensajes están organizados por fecha de recepción</li>
                    <li>• Usa el botón "Actualizar" para cargar nuevos mensajes</li>
                </ul>
            </div>
        </div>
    );
}
