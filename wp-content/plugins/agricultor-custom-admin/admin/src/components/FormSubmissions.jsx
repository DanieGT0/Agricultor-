import React, { useState, useEffect } from 'react';
import api from '../services/api';

export default function FormSubmissions() {
    const [submissions, setSubmissions] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [selectedSubmission, setSelectedSubmission] = useState(null);

    useEffect(() => {
        fetchSubmissions();
    }, []);

    const fetchSubmissions = async () => {
        try {
            setLoading(true);
            const response = await api.get('/submissions');
            setSubmissions(response.data.data || []);
            setError(null);
        } catch (err) {
            setError('Failed to load submissions');
            console.error('Error fetching submissions:', err);
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
            <div className="flex items-center justify-between">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Form Submissions</h1>
                    <p className="text-gray-600 mt-2">
                        View and manage contact form responses
                    </p>
                </div>
                <button
                    onClick={fetchSubmissions}
                    className="btn btn-outline"
                >
                    🔄 Refresh
                </button>
            </div>

            {/* Error message */}
            {error && (
                <div className="alert alert-error">
                    <p className="font-semibold">Error</p>
                    <p>{error}</p>
                </div>
            )}

            {/* Stats */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="card">
                    <p className="text-gray-600 text-sm font-medium">Total Submissions</p>
                    <p className="text-3xl font-bold text-primary-500 mt-2">{submissions.length}</p>
                </div>
                <div className="card">
                    <p className="text-gray-600 text-sm font-medium">Latest Submission</p>
                    <p className="text-lg font-semibold text-gray-900 mt-2">
                        {submissions.length > 0
                            ? new Date(submissions[0].submitted_at).toLocaleDateString()
                            : 'No submissions'}
                    </p>
                </div>
                <div className="card">
                    <p className="text-gray-600 text-sm font-medium">This Week</p>
                    <p className="text-lg font-semibold text-secondary-500 mt-2">
                        {getSubmissionsThisWeek(submissions)}
                    </p>
                </div>
            </div>

            {/* Submissions List */}
            {submissions.length === 0 ? (
                <div className="card text-center py-12">
                    <p className="text-lg text-gray-600 mb-4">📧 No form submissions yet</p>
                    <p className="text-gray-500">
                        Submissions will appear here when visitors use your contact form
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Submissions Table */}
                    <div className="lg:col-span-2">
                        <div className="card overflow-hidden">
                            <div className="overflow-x-auto">
                                <table className="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {submissions.map((submission) => (
                                            <tr key={submission.id}>
                                                <td>
                                                    <strong>{submission.name}</strong>
                                                </td>
                                                <td>{submission.email}</td>
                                                <td>{submission.subject}</td>
                                                <td className="text-xs text-gray-600">
                                                    {formatDate(submission.submitted_at)}
                                                </td>
                                                <td>
                                                    <button
                                                        onClick={() => setSelectedSubmission(submission)}
                                                        className="text-primary-500 hover:text-primary-700 font-medium text-sm"
                                                    >
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {/* Submission Details */}
                    {selectedSubmission && (
                        <div className="card bg-gray-50">
                            <div className="flex items-center justify-between mb-4">
                                <h2 className="text-lg font-semibold">Submission Details</h2>
                                <button
                                    onClick={() => setSelectedSubmission(null)}
                                    className="text-gray-500 hover:text-gray-700"
                                >
                                    ✕
                                </button>
                            </div>

                            <div className="space-y-4">
                                <InfoField label="Name" value={selectedSubmission.name} />
                                <InfoField label="Email" value={selectedSubmission.email} />

                                {selectedSubmission.phone && (
                                    <InfoField label="Phone" value={selectedSubmission.phone} />
                                )}

                                <InfoField label="Subject" value={selectedSubmission.subject} />

                                <div>
                                    <label className="text-sm font-medium text-gray-700 mb-1 block">
                                        Message
                                    </label>
                                    <div className="bg-white p-3 rounded border border-gray-200 text-sm text-gray-700 max-h-48 overflow-y-auto">
                                        {selectedSubmission.message}
                                    </div>
                                </div>

                                <div className="pt-4 border-t">
                                    <p className="text-xs text-gray-600 mb-3">
                                        <strong>Submitted:</strong>{' '}
                                        {new Date(selectedSubmission.submitted_at).toLocaleString()}
                                    </p>

                                    <a
                                        href={`mailto:${selectedSubmission.email}`}
                                        className="w-full btn btn-primary text-center block"
                                    >
                                        Reply via Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            )}

            {/* Info */}
            {submissions.length > 0 && (
                <div className="card bg-blue-50 border border-blue-200">
                    <h3 className="font-semibold text-blue-900 mb-2">💡 Submission Tips</h3>
                    <ul className="text-sm text-blue-800 space-y-1">
                        <li>• Click "View" to see the full submission details</li>
                        <li>• Use "Reply via Email" to respond to visitors quickly</li>
                        <li>• Email notifications are also sent to your admin email address</li>
                        <li>• Submissions are stored in your WordPress database</li>
                    </ul>
                </div>
            )}
        </div>
    );
}

function InfoField({ label, value }) {
    return (
        <div>
            <label className="text-sm font-medium text-gray-700 mb-1 block">{label}</label>
            <div className="bg-white p-2 rounded border border-gray-200 text-sm text-gray-900">
                {value}
            </div>
        </div>
    );
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}

function getSubmissionsThisWeek(submissions) {
    const now = new Date();
    const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);

    return submissions.filter((submission) => {
        const submissionDate = new Date(submission.submitted_at);
        return submissionDate > weekAgo;
    }).length;
}
