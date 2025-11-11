import React from 'react';

export default function Header({ onToggleSidebar }) {
    const userName = window.agricultor?.userName || 'User';

    return (
        <header className="bg-white border-b border-gray-200 shadow-sm">
            <div className="flex items-center justify-between px-6 py-4">
                <div className="flex items-center gap-4">
                    <button
                        onClick={onToggleSidebar}
                        className="md:hidden p-2 hover:bg-gray-100 rounded-md"
                        aria-label="Toggle sidebar"
                    >
                        <svg
                            className="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                    <div>
                        <h1 className="text-2xl font-bold text-primary-500">
                            Agricultor Dashboard
                        </h1>
                        <p className="text-sm text-gray-500">Manage your site</p>
                    </div>
                </div>

                <div className="flex items-center gap-6">
                    {/* Help link */}
                    <a
                        href="https://github.com/DanieGT0/Agricultor-"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="text-gray-600 hover:text-primary-500 transition"
                        title="View documentation"
                    >
                        <svg
                            className="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </a>

                    {/* User profile */}
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {userName.charAt(0).toUpperCase()}
                        </div>
                        <span className="text-sm font-medium text-gray-700">{userName}</span>
                    </div>
                </div>
            </div>
        </header>
    );
}
