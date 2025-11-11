<?php
/**
 * Clase para registrar shortcodes reutilizables
 */

if (!defined('ABSPATH')) {
    exit;
}

class Agricultor_Shortcodes {

    private static $instance = null;

    /**
     * Obtener instancia única (Singleton)
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Inicializar shortcodes
     */
    public function init() {
        add_shortcode('agricultor_faq', array($this, 'shortcode_faq'));
        add_shortcode('agricultor_contact_form', array($this, 'shortcode_contact_form'));
        add_shortcode('agricultor_map', array($this, 'shortcode_map'));
        add_shortcode('agricultor_contact_info', array($this, 'shortcode_contact_info'));
        add_shortcode('agricultor_whatsapp_button', array($this, 'shortcode_whatsapp_button'));
    }

    /**
     * Shortcode para mostrar FAQs
     * Uso: [agricultor_faq category="general" limit="10"]
     */
    public function shortcode_faq($atts) {
        $atts = shortcode_atts(array(
            'category' => '',
            'limit' => 10,
            'title' => __('Frequently Asked Questions', 'agricultor-custom-admin'),
        ), $atts, 'agricultor_faq');

        $faqs = Agricultor_FAQs::get_all_faqs($atts['category']);
        $faqs = array_slice($faqs, 0, $atts['limit']);

        if (empty($faqs)) {
            return '<p>' . __('No FAQs found.', 'agricultor-custom-admin') . '</p>';
        }

        ob_start();
        ?>
        <div class="agricultor-faq-container">
            <?php if (!empty($atts['title'])) : ?>
                <h2 class="agricultor-faq-title"><?php echo esc_html($atts['title']); ?></h2>
            <?php endif; ?>

            <div class="agricultor-faq-list">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <div class="agricultor-faq-item">
                        <button class="agricultor-faq-toggle" onclick="this.parentElement.classList.toggle('open')">
                            <span class="agricultor-faq-question"><?php echo esc_html($faq['question']); ?></span>
                            <span class="agricultor-faq-icon">+</span>
                        </button>
                        <div class="agricultor-faq-answer">
                            <?php echo wp_kses_post($faq['answer']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .agricultor-faq-container {
                max-width: 800px;
                margin: 2rem auto;
            }

            .agricultor-faq-title {
                color: var(--agricultor-primary-color, #2D5016);
                margin-bottom: 2rem;
                text-align: center;
                font-size: 2rem;
            }

            .agricultor-faq-list {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                overflow: hidden;
            }

            .agricultor-faq-item {
                border-bottom: 1px solid #e0e0e0;
            }

            .agricultor-faq-item:last-child {
                border-bottom: none;
            }

            .agricultor-faq-toggle {
                width: 100%;
                padding: 1.5rem;
                background: white;
                border: none;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
                transition: all 0.3s ease;
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--agricultor-primary-color, #2D5016);
            }

            .agricultor-faq-toggle:hover {
                background: var(--agricultor-primary-color, #2D5016);
                color: white;
            }

            .agricultor-faq-icon {
                font-size: 1.5rem;
                transition: transform 0.3s ease;
                display: inline-block;
            }

            .agricultor-faq-item.open .agricultor-faq-icon {
                transform: rotate(45deg);
            }

            .agricultor-faq-answer {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
                background: #f9f9f9;
            }

            .agricultor-faq-item.open .agricultor-faq-answer {
                max-height: 1000px;
            }

            .agricultor-faq-answer {
                padding: 0 1.5rem;
            }

            .agricultor-faq-item.open .agricultor-faq-answer {
                padding: 1.5rem;
            }

            .agricultor-faq-answer p {
                margin: 0.5rem 0;
                line-height: 1.6;
                color: #333;
            }

            @media (max-width: 768px) {
                .agricultor-faq-toggle {
                    padding: 1rem;
                    font-size: 1rem;
                }

                .agricultor-faq-title {
                    font-size: 1.5rem;
                }
            }
        </style>
        <?php

        return ob_get_clean();
    }

    /**
     * Shortcode para mostrar formulario de contacto
     * Uso: [agricultor_contact_form]
     */
    public function shortcode_contact_form($atts) {
        return Agricultor_Frontend::render_contact_form();
    }

    /**
     * Shortcode para mostrar mapa
     * Uso: [agricultor_map width="100%" height="400px" zoom="15"]
     */
    public function shortcode_map($atts) {
        $atts = shortcode_atts(array(
            'width' => '100%',
            'height' => '400px',
            'zoom' => '15',
        ), $atts, 'agricultor_map');

        $contact = Agricultor_Frontend::get_contact_info();
        $lat = $contact['latitude'] ?? '';
        $lng = $contact['longitude'] ?? '';
        $address = $contact['address'] ?? '';

        if (empty($lat) || empty($lng)) {
            return '<p style="color: red; text-align: center; padding: 1rem;">' .
                __('Location coordinates not configured. Go to Dashboard → Contact Info to set latitude and longitude.', 'agricultor-custom-admin') .
                '</p>';
        }

        $map_id = 'agricultor-map-' . wp_rand(1000, 9999);

        ob_start();
        ?>
        <div class="agricultor-map-container">
            <div id="<?php echo esc_attr($map_id); ?>"
                 class="agricultor-map"
                 style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>;">
            </div>
        </div>

        <script>
            // Cargar Google Maps API si no está cargado
            if (typeof google === 'undefined') {
                var script = document.createElement('script');
                script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY';
                document.head.appendChild(script);
                script.onload = function() {
                    initMap_<?php echo wp_rand(1000, 9999); ?>();
                };
            } else {
                initMap_<?php echo wp_rand(1000, 9999); ?>();
            }

            function initMap_<?php echo wp_rand(1000, 9999); ?>() {
                var location = {
                    lat: <?php echo floatval($lat); ?>,
                    lng: <?php echo floatval($lng); ?>
                };

                var map = new google.maps.Map(
                    document.getElementById('<?php echo esc_js($map_id); ?>'),
                    {
                        zoom: <?php echo absint($atts['zoom']); ?>,
                        center: location,
                        mapTypeControl: true,
                        streetViewControl: true
                    }
                );

                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: '<?php echo esc_js($address); ?>'
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: '<div style="padding: 10px; color: #333;"><strong><?php echo esc_js(get_bloginfo('name')); ?></strong><br><?php echo esc_js($address); ?></div>'
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            }
        </script>

        <style>
            .agricultor-map-container {
                margin: 2rem 0;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .agricultor-map {
                border-radius: 8px;
            }
        </style>
        <?php

        return ob_get_clean();
    }

    /**
     * Shortcode para información de contacto
     * Uso: [agricultor_contact_info layout="vertical" show_social="yes"]
     */
    public function shortcode_contact_info($atts) {
        $atts = shortcode_atts(array(
            'layout' => 'vertical', // vertical, horizontal, grid
            'show_social' => 'yes',
        ), $atts, 'agricultor_contact_info');

        $contact = Agricultor_Frontend::get_contact_info();
        $social = Agricultor_Frontend::get_social_media();

        ob_start();
        ?>
        <div class="agricultor-contact-info-wrapper <?php echo esc_attr('layout-' . $atts['layout']); ?>">
            <?php if (!empty($contact['phone'])) : ?>
                <div class="agricultor-contact-item">
                    <i class="icon">📞</i>
                    <div class="contact-details">
                        <h3><?php _e('Phone', 'agricultor-custom-admin'); ?></h3>
                        <a href="tel:<?php echo esc_attr(str_replace(array(' ', '-', '(', ')'), '', $contact['phone'])); ?>">
                            <?php echo esc_html($contact['phone']); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($contact['whatsapp'])) : ?>
                <div class="agricultor-contact-item">
                    <i class="icon">💬</i>
                    <div class="contact-details">
                        <h3><?php _e('WhatsApp', 'agricultor-custom-admin'); ?></h3>
                        <a href="<?php echo esc_url(Agricultor_Frontend::get_whatsapp_url()); ?>" target="_blank">
                            <?php _e('Contact via WhatsApp', 'agricultor-custom-admin'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($contact['email'])) : ?>
                <div class="agricultor-contact-item">
                    <i class="icon">📧</i>
                    <div class="contact-details">
                        <h3><?php _e('Email', 'agricultor-custom-admin'); ?></h3>
                        <a href="mailto:<?php echo esc_attr($contact['email']); ?>">
                            <?php echo esc_html($contact['email']); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($contact['address'])) : ?>
                <div class="agricultor-contact-item">
                    <i class="icon">📍</i>
                    <div class="contact-details">
                        <h3><?php _e('Address', 'agricultor-custom-admin'); ?></h3>
                        <p><?php echo esc_html($contact['address']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($atts['show_social'] === 'yes' && !empty($social)) : ?>
                <div class="agricultor-contact-item social-item">
                    <div class="contact-details">
                        <h3><?php _e('Follow Us', 'agricultor-custom-admin'); ?></h3>
                        <div class="social-icons">
                            <?php foreach ($social as $platform => $url) : ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-icon <?php echo esc_attr($platform); ?>" title="<?php echo esc_attr(ucfirst($platform)); ?>">
                                    <?php echo esc_html(strtoupper($platform[0])); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .agricultor-contact-info-wrapper {
                display: flex;
                gap: 2rem;
                padding: 2rem;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .agricultor-contact-info-wrapper.layout-vertical {
                flex-direction: column;
                max-width: 600px;
            }

            .agricultor-contact-info-wrapper.layout-grid {
                flex-wrap: wrap;
            }

            .agricultor-contact-item {
                display: flex;
                gap: 1rem;
                align-items: flex-start;
            }

            .agricultor-contact-item .icon {
                font-size: 2rem;
                min-width: 50px;
            }

            .contact-details h3 {
                margin: 0;
                color: var(--agricultor-primary-color, #2D5016);
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .contact-details p,
            .contact-details a {
                margin: 0.5rem 0 0 0;
                font-size: 1.1rem;
                color: #333;
                text-decoration: none;
                font-weight: 500;
            }

            .contact-details a:hover {
                color: var(--agricultor-secondary-color, #7CB342);
            }

            .social-icons {
                display: flex;
                gap: 1rem;
                margin-top: 0.5rem;
            }

            .social-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background: var(--agricultor-primary-color, #2D5016);
                color: white;
                border-radius: 50%;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: bold;
            }

            .social-icon:hover {
                background: var(--agricultor-secondary-color, #7CB342);
                transform: translateY(-3px);
            }

            @media (max-width: 768px) {
                .agricultor-contact-info-wrapper {
                    flex-direction: column;
                    gap: 1.5rem;
                }
            }
        </style>
        <?php

        return ob_get_clean();
    }

    /**
     * Shortcode para botón flotante de WhatsApp
     * Uso: [agricultor_whatsapp_button position="right" message="¡Hola! Me gustaría saber más"]
     */
    public function shortcode_whatsapp_button($atts) {
        $atts = shortcode_atts(array(
            'position' => 'right', // left, right
            'message' => '',
        ), $atts, 'agricultor_whatsapp_button');

        $whatsapp_url = Agricultor_Frontend::get_whatsapp_url();

        if (empty($whatsapp_url)) {
            return ''; // No mostrar si no está configurado
        }

        if (!empty($atts['message'])) {
            $whatsapp_url .= '?text=' . urlencode($atts['message']);
        }

        $position_style = $atts['position'] === 'left' ? 'left: 20px;' : 'right: 20px;';

        ob_start();
        ?>
        <div id="agricultor-whatsapp-floating" style="<?php echo esc_attr($position_style); ?>">
            <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" class="whatsapp-button" title="Contact us on WhatsApp">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                    <path d="M17.6915026,14.4744748 C17.5908952,14.4744748 16.4272231,13.9247899 16.1572151,13.8241825 C15.8842377,13.7235751 15.7836307,13.8241825 15.5106632,14.0274797 C15.2406807,14.2307769 14.5475588,15.1274899 14.3148346,15.4006049 C14.0851376,15.6737198 13.8554406,15.7115758 13.5824732,15.5082786 C12.0591357,14.5120177 10.8721683,13.2347729 9.87562435,11.6625031 C9.65830201,11.3208844 9.72874849,11.0871357 9.93204571,10.8905037 C10.0947341,10.7279154 10.3009154,10.4548005 10.4035228,10.2515032 C10.5061301,10.0482061 10.4035228,9.84490888 10.3029154,9.74430146 C10.2022283,9.64368652 9.62054282,8.47996271 9.34928074,7.95166232 C9.08686206,7.45107146 8.81827343,7.5300126 8.60399262,7.5300126 L8.18622022,7.5300126 C7.97524435,7.5300126 7.63135988,7.63061003 7.35823206,7.90789151 C7.09018282,8.17600695 6.31162261,8.94463029 6.31162261,10.1069717 C6.31162261,11.2662605 7.37919504,12.3883742 7.48649244,12.5880334 C7.59378984,12.7906718 9.67046207,16.2839739 13.0281346,17.7130368 C13.5546182,17.9585174 13.9654061,18.104016 14.2878564,18.2079274 C14.8156205,18.3951434 15.2832309,18.3633962 15.6634117,18.2954259 C16.0885315,18.2158151 16.9543152,17.7406095 17.1573722,17.2128455 C17.3573586,16.6881666 17.3573586,16.252175 17.2566715,16.1483848 C17.1559844,16.0344758 16.9486281,15.9329785 16.6743196,15.8294986 L17.6915026,14.4744748 Z"></path>
                </svg>
                <span class="whatsapp-label"><?php _e('WhatsApp', 'agricultor-custom-admin'); ?></span>
            </a>
        </div>

        <style>
            #agricultor-whatsapp-floating {
                position: fixed;
                bottom: 30px;
                z-index: 9999;
                animation: slideUp 0.5s ease-in-out;
            }

            .whatsapp-button {
                display: flex;
                align-items: center;
                gap: 10px;
                background: #25D366;
                color: white;
                padding: 15px 20px;
                border-radius: 50px;
                text-decoration: none;
                box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
                transition: all 0.3s ease;
                font-weight: 600;
                font-size: 1rem;
            }

            .whatsapp-button svg {
                width: 24px;
                height: 24px;
            }

            .whatsapp-button:hover {
                background: #1ebe56;
                box-shadow: 0 6px 16px rgba(37, 211, 102, 0.6);
                transform: translateY(-3px);
            }

            @media (max-width: 768px) {
                .whatsapp-button {
                    padding: 12px 16px;
                    font-size: 0.9rem;
                }

                .whatsapp-label {
                    display: none;
                }

                .whatsapp-button svg {
                    width: 28px;
                    height: 28px;
                }
            }

            @keyframes slideUp {
                from {
                    transform: translateY(100px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        </style>
        <?php

        return ob_get_clean();
    }
}
