import React, { useState, useEffect } from 'react';
import Dashboard from './components/Dashboard';
import ContactForm from './components/ContactForm';
import ThemeCustomizer from './components/ThemeCustomizer';
import ImageManager from './components/ImageManager';
import FormSubmissions from './components/FormSubmissions';
import Sidebar from './components/Sidebar';
import Header from './components/Header';

export default function App() {
    const [currentPage, setCurrentPage] = useState('dashboard');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [sidebarOpen, setSidebarOpen] = useState(true);

    // Obtener API URL y nonce de WordPress
    const apiUrl = window.agricultor?.apiUrl || '/wp-json/agricultor/v1';
    const nonce = window.agricultor?.nonce || '';

    // Hacer disponibles globalmente
    window.agricultor = window.agricultor || {
        apiUrl,
        nonce,
    };

    useEffect(() => {
        // Verificar que tenemos los datos necesarios
        if (!nonce) {
            setError('Unable to initialize dashboard. Missing security token.');
        }
    }, [nonce]);

    const handleNavigate = (page) => {
        setCurrentPage(page);
        setError(null);
    };

    const renderPage = () => {
        switch (currentPage) {
            case 'dashboard':
                return <Dashboard />;
            case 'contact':
                return <ContactForm />;
            case 'theme':
                return <ThemeCustomizer />;
            case 'images':
                return <ImageManager />;
            case 'submissions':
                return <FormSubmissions />;
            default:
                return <Dashboard />;
        }
    };

    return (
        <div className="flex h-screen bg-gray-100">
            {/* Sidebar */}
            <Sidebar
                currentPage={currentPage}
                onNavigate={handleNavigate}
                isOpen={sidebarOpen}
                onToggle={() => setSidebarOpen(!sidebarOpen)}
            />

            {/* Main content */}
            <div className="flex-1 flex flex-col overflow-hidden">
                {/* Header */}
                <Header onToggleSidebar={() => setSidebarOpen(!sidebarOpen)} />

                {/* Content */}
                <main className="flex-1 overflow-auto">
                    {error && (
                        <div className="alert alert-error m-4">
                            <p className="font-semibold">Error</p>
                            <p>{error}</p>
                        </div>
                    )}

                    <div className="p-6">
                        {loading ? (
                            <div className="flex items-center justify-center h-64">
                                <div className="spinner"></div>
                            </div>
                        ) : (
                            renderPage()
                        )}
                    </div>
                </main>
            </div>
        </div>
    );
}
