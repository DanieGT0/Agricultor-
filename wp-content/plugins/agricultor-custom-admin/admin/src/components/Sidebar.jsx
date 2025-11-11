import React from 'react';

const menuItems = [
    { id: 'dashboard', label: 'Dashboard', icon: '📊' },
    { id: 'messages', label: 'Messages', icon: '💬' },
    { id: 'contact', label: 'Contact Info', icon: '📞' },
    { id: 'theme', label: 'Customize Theme', icon: '🎨' },
    { id: 'images', label: 'Manage Images', icon: '🖼️' },
    { id: 'faqs', label: 'FAQs', icon: '❓' },
    { id: 'submissions', label: 'Form Submissions', icon: '📧' },
];

export default function Sidebar({ currentPage, onNavigate, isOpen, onToggle }) {
    return (
        <>
            {/* Overlay para mobile */}
            {isOpen && (
                <div
                    className="fixed inset-0 bg-black/50 md:hidden z-20"
                    onClick={onToggle}
                />
            )}

            {/* Sidebar */}
            <aside
                className={`fixed md:relative w-64 bg-white border-r border-gray-200 h-screen overflow-y-auto z-30 transition-transform duration-300 transform ${
                    isOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
                }`}
            >
                {/* Logo */}
                <div className="p-6 border-b border-gray-200">
                    <div className="flex items-center gap-2">
                        <div className="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                            🌱
                        </div>
                        <h2 className="text-xl font-bold text-primary-500">Agricultor</h2>
                    </div>
                </div>

                {/* Navigation */}
                <nav className="p-4">
                    <ul className="space-y-2">
                        {menuItems.map((item) => (
                            <li key={item.id}>
                                <button
                                    onClick={() => {
                                        onNavigate(item.id);
                                        // Cerrar sidebar en mobile después de navegar
                                        if (window.innerWidth < 768) {
                                            onToggle();
                                        }
                                    }}
                                    className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 ${
                                        currentPage === item.id
                                            ? 'bg-primary-500 text-white font-semibold'
                                            : 'text-gray-700 hover:bg-gray-100'
                                    }`}
                                >
                                    <span className="text-xl">{item.icon}</span>
                                    <span>{item.label}</span>
                                </button>
                            </li>
                        ))}
                    </ul>
                </nav>

                {/* Footer info */}
                <div className="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-gray-50">
                    <p className="text-xs text-gray-500 mb-2">
                        <strong>Dashboard Version:</strong> 1.0.0
                    </p>
                    <a
                        href={`${window.location.origin}/wp-admin/`}
                        className="text-xs text-primary-500 hover:text-primary-600 font-medium"
                    >
                        ← Back to WordPress
                    </a>
                </div>
            </aside>
        </>
    );
}
