/**
 * Cliente API para comunicarse con la REST API de WordPress
 */

const API_BASE = window.agricultor?.apiUrl || '/wp-json/agricultor/v1';
const NONCE = window.agricultor?.nonce || '';

// Configuración por defecto para las peticiones
const defaultConfig = {
    headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': NONCE,
    },
};

/**
 * Clase para manejar peticiones HTTP
 */
class API {
    constructor(baseURL = API_BASE) {
        this.baseURL = baseURL;
    }

    /**
     * GET request
     */
    async get(endpoint) {
        return this._request('GET', endpoint, null);
    }

    /**
     * POST request
     */
    async post(endpoint, data) {
        return this._request('POST', endpoint, data);
    }

    /**
     * PUT request
     */
    async put(endpoint, data) {
        return this._request('PUT', endpoint, data);
    }

    /**
     * DELETE request
     */
    async delete(endpoint) {
        return this._request('DELETE', endpoint, null);
    }

    /**
     * Método base para hacer peticiones
     */
    async _request(method, endpoint, body) {
        const url = `${this.baseURL}${endpoint}`;

        const options = {
            method,
            headers: defaultConfig.headers,
        };

        if (body) {
            options.body = JSON.stringify(body);
        }

        try {
            const response = await fetch(url, options);

            // Manejar respuestas no OK
            if (!response.ok) {
                const error = new Error(`HTTP Error ${response.status}`);
                error.response = {
                    status: response.status,
                    data: await response.json().catch(() => ({})),
                };
                throw error;
            }

            // Parsear respuesta JSON
            const data = await response.json();

            return {
                status: response.status,
                data,
            };
        } catch (error) {
            // Log error en desarrollo
            if (process.env.NODE_ENV === 'development') {
                console.error('API Error:', error);
            }

            throw error;
        }
    }
}

export default new API();
