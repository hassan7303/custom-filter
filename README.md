
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/hassan-ali-askari-280bb530a/
[telegram-shield]: https://img.shields.io/badge/-Telegram-blue.svg?style=for-the-badge&logo=telegram&colorB=555
[telegram-url]: https://t.me/hassan7303
[instagram-shield]: https://img.shields.io/badge/-Instagram-red.svg?style=for-the-badge&logo=instagram&colorB=555
[instagram-url]: https://www.instagram.com/hasan_ali_askari
[github-shield]: https://img.shields.io/badge/-GitHub-black.svg?style=for-the-badge&logo=github&colorB=555
[github-url]: https://gitiran.spadit.com/plugin
[email-shield]: https://img.shields.io/badge/-Email-orange.svg?style=for-the-badge&logo=gmail&colorB=555
[email-url]: mailto:hassanali7303@gmail.com


[![LinkedIn][linkedin-shield]][linkedin-url]
[![Telegram][telegram-shield]][telegram-url]
[![Instagram][instagram-shield]][instagram-url]
[![GitHub][github-shield]][github-url]
[![Email][email-shield]][email-url]


# Custom Filters Plugin Documentation

## Plugin Information

- **Plugin Name:** Custom Filters
- **Description:** A Plugin For Custom Filters In WordPress.
- **Version:** 1.0.0
- **Author:** Hassan Ali Askari
- **Author URI:** [Telegram](https://t.me/hassan7303)
- **Plugin URI:** [GitHub](https://github.com/hassan7303)
- **License:** MIT
- **License URI:** [MIT License](https://opensource.org/licenses/MIT)
- **Email:** hassanali7303@gmail.com
- **Domain Path:** [Domain](https://hsnali.ir)

## Installation

1. Download the plugin.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

### Shortcode

To display the custom filters in your posts or pages, use the following shortcode:

```php
[custom_filters]

```

# Filter Structure And Features

This plugin creates a tabbed filter system for car products in WooCommerce. It includes:

- **Tabbed Interface:** Filter products based on car types (Light Vehicles, Heavy Vehicles, API/SAE, Industrial).
- **Brand Selection:** Choose brands based on car types.
- **Category Filtering:** Filter products by category.
- **AJAX Search:** Filter results are loaded without page refresh using AJAX.

### Tabs

1. **Light Vehicles (خودروهای سبک):**
   - Filters include `Brand` and `Car`.

2. **Heavy Vehicles (خودروهای سنگین):**
   - Filters include `Brand` and `Car`.

3. **API / SAE:**
   - Select different levels of API or SAE.

4. **Industrial (صنعتی):**
   - Redirects to a product category page with industrial products.

## Filters and Taxonomies

This plugin uses WooCommerce product taxonomies for filtering:

- `pa_brand`: Brand taxonomy for cars.
- `pa_car`: Car taxonomy.
- `product_cat`: Product categories.

### Example Code Snippets

To fetch terms for the filter dropdowns:

```php
$brand_terms = get_terms(array(
    'taxonomy' => 'pa_brand',
    'hide_empty' => false,
));