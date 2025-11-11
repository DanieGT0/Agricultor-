import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import './index.css';

// Función para inicializar React
function initReact() {
    // Buscar el elemento raíz (WordPress usa agriculartor-root)
    const rootElement = document.getElementById('agricultor-root') || document.getElementById('root');

    if (!rootElement) {
        console.error('Cannot find root element for React app. Looking for #agricultor-root or #root');
        // Reintentar en 100ms
        setTimeout(initReact, 100);
        return;
    }

    try {
        const root = ReactDOM.createRoot(rootElement);
        root.render(
            <React.StrictMode>
                <App />
            </React.StrictMode>
        );
        console.log('✅ Agricultor Dashboard React app mounted successfully');
    } catch (error) {
        console.error('Error mounting React app:', error);
    }
}

// Esperar a que el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReact);
} else {
    // DOM ya está cargado
    initReact();
}
