=== Mallorca ===
Contributors: mallorca
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 8.1
WC requires at least: 8.0
WC tested up to: 9.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tema WordPress editorial para Pastelería Mallorca México. Compatible con Elementor y WooCommerce.

== Description ==

Mallorca es un tema híbrido (PHP + theme.json) pensado para una pastelería española en México:

* Sitio institucional
* Catálogo gastronómico
* Tienda WooCommerce
* Sucursales (CPT `mallorca_location`)
* Portada construible con Elementor (widgets Mallorca) o con plantillas PHP

No copia el diseño del sitio actual. Dirección visual: marfil, borgoña, serif editorial, fotografía protagonista.

== Instalación ==

1. Sube la carpeta `mallorca` a `/wp-content/themes/` o instala el zip desde Apariencia → Temas → Añadir nuevo.
2. Activa el tema.
3. Instala y activa **WooCommerce**.
4. Instala y activa **Elementor** (recomendado para editar la portada).
5. Apariencia → Mallorca demo → Importar contenido demo.
6. Edita Inicio con Elementor. Los widgets están en la categoría **Mallorca**.
7. Apariencia → Personalizar para colores, tipografía, hero, redes y WhatsApp.

== Elementor ==

Widgets propios:

* Mallorca Hero
* Mallorca Categorías
* Mallorca Favoritos
* Mallorca Historia
* Mallorca Temporada
* Mallorca Experiencia
* Mallorca Sucursales
* Mallorca Instagram
* Mallorca Newsletter
* Mallorca CTA

Plantillas de página:

* Mallorca / Elementor ancho completo
* Mallorca / Elementor canvas

Si usas Elementor Pro, el tema registra las locations de Theme Builder (header, footer, single, archive). El header y footer PHP se usan cuando no hay plantilla de Theme Builder.

La portada PHP se sustituye automáticamente si la página de inicio está construida con Elementor.

== Plugins recomendados (fuera del tema) ==

* WooCommerce Product Add-Ons (mensaje, velas, extras)
* Delivery slots / Order Delivery Date
* WooCommerce Local Pickup
* Pasarela mexicana (Mercado Pago, Stripe, etc.) — no van en el tema
* Mailchimp / Brevo / Fluent Forms (pega el shortcode en el widget Newsletter)
* Yoast o Rank Math

== Checklist de activación ==

* Activar tema sin errores PHP (con y sin WooCommerce)
* Activar WooCommerce y Elementor
* Importar demo
* Menús, buscador, carrito, mini cart
* Producto simple y variable
* Cupón, checkout, validación
* Cuenta, 404, búsqueda vacía
* Menú móvil y teclado (Esc cierra overlays)

== Changelog ==

= 1.0.0 =
* Primera versión. Tema listo para Elementor + WooCommerce.
