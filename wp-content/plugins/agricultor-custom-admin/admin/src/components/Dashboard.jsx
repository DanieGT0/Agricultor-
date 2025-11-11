import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function Dashboard() {
    const [stats, setStats] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchStats();
    }, []);

    const fetchStats = async () => {
        try {
            setLoading(true);
            const response = await api.get('/dashboard/stats');
            setStats(response.data);
            setError(null);
        } catch (err) {
            setError('Failed to load dashboard statistics');
            console.error('Error fetching stats:', err);
        } finally {
            setLoading(false);
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
            <div>
                <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p className="text-gray-600 mt-2">Welcome to your Agricultor management dashboard</p>
            </div>

            {/* Error message */}
            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            {/* Stats grid */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                {/* Total Images */}
                <div className="card">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-gray-600 text-sm font-medium">Total Images</p>
                            <p className="text-3xl font-bold text-primary-500 mt-2">
                                {stats?.data?.total_images || 0}
                            </p>
                        </div>
                        <div className="bg-blue-100 p-4 rounded-lg">
                            <span className="text-3xl">🖼️</span>
                        </div>
                    </div>
                </div>

                {/* Total Submissions */}
                <div className="card">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-gray-600 text-sm font-medium">Total Submissions</p>
                            <p className="text-3xl font-bold text-secondary-500 mt-2">
                                {stats?.data?.total_submissions || 0}
                            </p>
                        </div>
                        <div className="bg-green-100 p-4 rounded-lg">
                            <span className="text-3xl">📧</span>
                        </div>
                    </div>
                </div>

                {/* Recent Submissions */}
                <div className="card">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-gray-600 text-sm font-medium">Recent Submissions (7 days)</p>
                            <p className="text-3xl font-bold text-accent mt-2">
                                {stats?.data?.recent_submissions || 0}
                            </p>
                        </div>
                        <div className="bg-yellow-100 p-4 rounded-lg">
                            <span className="text-3xl">📋</span>
                        </div>
                    </div>
                </div>
            </div>

            {/* Quick actions */}
            <div className="card">
                <h2 className="card-title">Quick Actions</h2>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <QuickActionButton
                        title="Contact Information"
                        description="Update your contact details and social media"
                        icon="📞"
                        href="#contact"
                    />
                    <QuickActionButton
                        title="Customize Theme"
                        description="Change colors, fonts, and visual settings"
                        icon="🎨"
                        href="#theme"
                    />
                    <QuickActionButton
                        title="Manage Images"
                        description="Upload and organize website images"
                        icon="🖼️"
                        href="#images"
                    />
                    <QuickActionButton
                        title="View Submissions"
                        description="Check contact form responses"
                        icon="📧"
                        href="#submissions"
                    />
                </div>
            </div>

            {/* Help section */}
            <div className="card bg-blue-50 border border-blue-200">
                <h2 className="text-lg font-bold text-blue-900 mb-3">Need Help?</h2>
                <p className="text-blue-800 mb-4">
                    This dashboard allows you to manage all aspects of your Agricultor Verde website
                    without accessing the WordPress admin panel.
                </p>
                <a
                    href="https://github.com/DanieGT0/Agricultor-"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="text-blue-600 font-semibold hover:text-blue-700"
                >
                    View Documentation →
                </a>
            </div>
        </div>
    );
}

function QuickActionButton({ title, description, icon, href }) {
    return (
        <a
            href={href}
            className="p-4 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition cursor-pointer group"
        >
            <div className="flex items-start gap-3">
                <div className="text-3xl flex-shrink-0">{icon}</div>
                <div>
                    <h3 className="font-semibold text-gray-900 group-hover:text-primary-500">
                        {title}
                    </h3>
                    <p className="text-sm text-gray-600">{description}</p>
                </div>
            </div>
        </a>
    );
}
