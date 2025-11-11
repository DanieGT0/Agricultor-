import { useState, useCallback } from 'react';
import api from '../services/api';

/**
 * Hook personalizado para hacer llamadas a la API
 */
export function useApi() {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const request = useCallback(async (method, endpoint, data = null) => {
        setLoading(true);
        setError(null);

        try {
            let response;

            switch (method) {
                case 'GET':
                    response = await api.get(endpoint);
                    break;
                case 'POST':
                    response = await api.post(endpoint, data);
                    break;
                case 'PUT':
                    response = await api.put(endpoint, data);
                    break;
                case 'DELETE':
                    response = await api.delete(endpoint);
                    break;
                default:
                    throw new Error(`Unsupported method: ${method}`);
            }

            setLoading(false);
            return response.data;
        } catch (err) {
            const errorMessage = err.response?.data?.message || err.message || 'An error occurred';
            setError(errorMessage);
            setLoading(false);
            throw err;
        }
    }, []);

    const clearError = useCallback(() => setError(null), []);

    return {
        request,
        loading,
        error,
        clearError,
    };
}

/**
 * Hook para obtener datos (GET)
 */
export function useFetch(endpoint, dependencies = []) {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const { request } = useApi();

    const fetchData = useCallback(async () => {
        try {
            setLoading(true);
            const response = await request('GET', endpoint);
            setData(response.data || response);
            setError(null);
        } catch (err) {
            setError(err);
        } finally {
            setLoading(false);
        }
    }, [endpoint, request]);

    // Usar effect personalizado con dependencias
    const effect = () => {
        fetchData();
    };

    // Llamar al fetchData
    useCallback(effect, dependencies)();

    const refetch = useCallback(() => fetchData(), [fetchData]);

    return {
        data,
        loading,
        error,
        refetch,
    };
}
