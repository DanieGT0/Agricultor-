/**
 * Manejador de formularios de contacto
 */

(function() {
    'use strict';

    // Esperar a que el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        initContactForm();
    });

    /**
     * Inicializar formulario de contacto
     */
    function initContactForm() {
        const form = document.getElementById('agricultor-contact-form');
        if (!form) return;

        form.addEventListener('submit', handleFormSubmit);
    }

    /**
     * Manejar envío de formulario
     */
    async function handleFormSubmit(e) {
        e.preventDefault();

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const statusDiv = form.querySelector('.form-status');

        // Deshabilitar botón
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        try {
            // Recopilar datos del formulario
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            // Enviar a la API REST
            const response = await fetch(agricultorForm.apiUrl + '/submissions/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': agricultorForm.nonce,
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                // Mostrar mensaje de éxito
                statusDiv.classList.remove('error');
                statusDiv.classList.add('success');
                statusDiv.textContent = result.message || 'Message sent successfully!';
                statusDiv.style.display = 'block';

                // Resetear formulario
                form.reset();

                // Ocultar mensaje después de 5 segundos
                setTimeout(() => {
                    statusDiv.style.display = 'none';
                }, 5000);
            } else {
                // Mostrar errores
                const errors = result.errors || [result.message || 'Error sending message'];
                statusDiv.classList.remove('success');
                statusDiv.classList.add('error');
                statusDiv.innerHTML = '<strong>Error:</strong><br>' + errors.join('<br>');
                statusDiv.style.display = 'block';
            }
        } catch (error) {
            // Error de red
            statusDiv.classList.remove('success');
            statusDiv.classList.add('error');
            statusDiv.textContent = 'Error sending message. Please try again.';
            statusDiv.style.display = 'block';

            console.error('Form submission error:', error);
        } finally {
            // Re-habilitar botón
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Message';
        }
    }
})();
