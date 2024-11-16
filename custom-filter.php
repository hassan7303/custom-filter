<?php

/**
 * Plugin Name: Custom Filters
 *
 * Description: A Plugin For Custom Filters In Wordpress.
 *
 * Version: 1.0.0
 *
 * Author: Hassan Ali Askari
 * Author URI: https://t.me/hassan7303
 * Plugin URI: https://github.com/hassan7303
 *
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * Email: hassanali7303@gmail.com
 * Domain Path: https://hsnali.ir
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

/**
 * HTML For Filters
 *
 * @return bool|string
 */
function custom_filters_shortcode_function(): bool|string
{
    ob_start();

    $APIs = get_terms(array(
        'taxonomy' => 'pa_api',
        'hide_empty' => false,
    ));
    $SAEs = get_terms(array(
        'taxonomy' => 'pa_sae',
        'hide_empty' => false,
    ));


    // دریافت دسته‌بندی‌های محصولات ووکامرس
    $product_categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));

    $brands = get_terms(array(
        'taxonomy' => 'pa_brand',
        'hide_empty' => false,
    ));
    

    //جدا کردن برند ها
    $brands_h = [];
    $brands_l = [];
    foreach ($brands as $brand) {
        $slug_parts = explode('-', $brand->slug);

        if ($slug_parts[0] === 'h') {
            $brands_h[$brand->name] = [
                'name' => $brand->name,
                'slug' => $brand->slug
            ];
        } elseif ($slug_parts[0] === 'l') {
            $brands_l[$brand->name] = [
                'name' => $brand->name,
                'slug' => $brand->slug
            ];
        }
    }


// دریافت داده‌ها ماشین از وردپرس
    $car_data = [];
    $cars = get_terms(array(
        'taxonomy' => 'pa_car',
        'hide_empty' => false,
    ));
    
    $car_data = [
    'heavy' => [],
    'light' => [],
];

foreach ($cars as $car) {
    $slug_parts = explode('-', $car->slug);

    if ($slug_parts[0] === 'h') {
        $car_data['heavy'][] = [
            'name' => $car->name,
            'slug' => $car->slug,
        ];
    } elseif ($slug_parts[0] === 'l') {
        $car_data['light'][] = [
            'name' => $car->name,
            'slug' => $car->slug,
        ];
    }
}


    ?>
    <div class="tab-container">
        <!-- tabs -->
        <div class="tab-buttons">
            <button id="btn_tab1" class="tab-button active" data-tab="1">
                <img src="<?= plugin_dir_url(__FILE__) ?>/assets/images/car.png" alt="." width="50" height="50">
                <span>خودروهای سبک</span>
            </button>
            <button id="btn_tab2" class="tab-button" data-tab="2">
                <img src="<?= plugin_dir_url(__FILE__) ?>/assets/images/h-car.png" alt="." width="50" height="50">
                <span>خودروهای سنگین</span>
            </button>
            <button id="btn_tab3" class="tab-button" data-tab="3">
                <img src="<?= plugin_dir_url(__FILE__) ?>/assets/images/API-SAE.png" alt="." width="50" height="50">
                <span>API , SAE</span>
            </button>
            <a id="btn_tab4" href="<?= home_url('product-category/industrial') ?>" class="tab-button" data-tab="4">
                <img src="<?= plugin_dir_url(__FILE__) ?>/assets/images/s.png" alt="." width="50" height="50">
                <span>صنعتی</span>
            </a>
        </div>
        <!-- end tabs -->

        <div class="tab-content active" id="tab-1">
            <form class="search-form" id="search-form-1">
                <div>
                    <label for="brand_car_light">برند</label>
                    <select name="brand_car_light" id="brand_car_light" onchange="updateCarLightOptions()">
                        <option value="">انتخاب برند</option>
                        <?php
                        if (!empty($brands_l)) {
                            foreach ($brands_l as $brand) {
                                echo '<option value="' . esc_attr($brand['slug']) . '">' . esc_html($brand['name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">برندی یافت نشد</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="car_light">ماشین</label>
                    <select name="car_light" id="car_light">
                        <option value="">انتخاب ماشین</option>
                    </select>
                </div>
                <div>
                    <label for="product-category">دسته‌بندی</label>
                    <select name="product-category" id="product-category">
                        <?php
                        // نمایش دسته‌بندی‌ها در سلکت‌باکس
                        if (!empty($product_categories) && !is_wp_error($product_categories)) {
                            echo '<option value="">انتخاب دسته‌بندی</option>';
                            foreach ($product_categories as $category) {
                                echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                            }
                        } else {
                            echo '<option value="">هیچ دسته‌بندی‌ای یافت نشد</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="search-btn-div">
                    <button type="button" onclick="searchFilters(1)">جستجو</button>
                    <div class="loader loader-1"></div>
                </div>
            </form>
        </div>

        <div class="tab-content" id="tab-2">
            <form class="search-form" id="search-form-2">
                <div>
                    <label for="brand_car_heavy">برند</label>
                    <select name="brand_car_heavy" id="brand_car_heavy" onchange="updateCarHeavyOptions()">
                        <option value="">انتخاب برند</option>
                        <?php
                        if (!empty($brands_h)) {
                            foreach ($brands_h as $brand) {
                                echo '<option value="' . esc_attr($brand['slug']) . '">' . esc_html($brand['name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">برندی یافت نشد</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="car_heavy">ماشین</label>
                    <select name="car_heavy" id="car_heavy" >
                        <option value="">انتخاب ماشین</option>
                    </select>
                </div>
                <div>
                    <label for="product-category">دسته‌بندی</label>
                    <select name="product-category" id="product-category">
                        <?php
                        // نمایش دسته‌بندی‌ها در سلکت‌باکس
                        if (!empty($product_categories) && !is_wp_error($product_categories)) {
                            echo '<option value="">انتخاب دسته‌بندی</option>';
                            foreach ($product_categories as $category) {
                                echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                            }
                        } else {
                            echo '<option value="">هیچ دسته‌بندی‌ای یافت نشد</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="search-btn-div">
                    <button type="button" onclick="searchFilters(2)">جستجو</button>
                    <div class="loader loader-2"></div>
                </div>
            </form>
        </div>

        <div class="tab-content" id="tab-3">
            <form class="search-form" id="search-form-3">
                <div>
                    <label for="API">سطح کارایی (API)</label>
                    <select name="API" id="API">
                        <?php
                        if (!empty($APIs) && !is_wp_error($APIs)) {
                            echo '<option value="">انتخاب API</option>';

                            foreach ($APIs as $API) {
                                echo '<option value="' . esc_attr($API->slug) . '">' . esc_html($API->name) . '</option>';
                            }
                        } else {
                            echo '<option value="">سطح کارایی (API) یافت نشد</option>'; // در صورت عدم وجود برند
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="SAE">درجه گرانروی (SAE)</label>
                    <select name="SAE" id="SAE">
                        <?php


                        if (!empty($SAEs) && !is_wp_error($SAEs)) {
                            echo '<option value="">انتخاب SAE</option>';

                            foreach ($SAEs as $SAE) {
                                echo '<option value="' . esc_attr($SAE->slug) . '">' . esc_html($SAE->name) . '</option>';
                            }
                        } else {
                            echo '<option value="">درجه گرانروی (SAE) یافت نشد</option>'; // در صورت عدم وجود برند
                        }
                        ?>
                    </select>
                </div>
                <div class="col-custom">
                    <div class="search-btn-div">
                        <button type="button" onclick="searchFilters(3)">جستجو</button>
                        <div class="loader loader-3"></div>
                    </div>
                </div>
                <!-- </div> -->
            </form>
        </div>

        <div class="tab-content" id="tab-4"></div>
    </div>
    
    <style>

        .frame-content {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .row-custom {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }

        .col-custom {
            flex: 1;
            margin-right: 10px; /* Adjust spacing between columns */
            text-align: center;
        }

        .col-custom:last-child {
            margin-right: 0; /* Remove margin for last column */
        }

        .lbl-filter {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .box-list {
            margin-bottom: 10px;
        }

        .lst-theme {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-submit {
            padding: 10px;
            border: none;
            background-color: #0073aa;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #005177;
        }

        .btn-tab-3 {
            width: 50%;
            margin-top: 17px;
        }


        .tab-container {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .tab-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .tab-button {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, border-bottom 0.3s;
            text-decoration: none; /* حذف خط زیر لینک */
        }

        .tab-button img {
            margin-bottom: 5px; /* فاصله بین تصویر و متن */
        }

        .tab-button:hover {
            background-color: #eaeaea;
        }

        .tab-button.active {
            background-color: #fff;
            border-bottom: 2px solid #0073aa; /* رنگ مرز پایین تب فعال */
        }

        .tab-content {
            display: none; /* مخفی کردن محتوای تب‌ها به صورت پیش‌فرض */
        }

        .tab-content.active {
            display: block; /* نمایش محتوای تب فعال */
        }

        /* استایل‌های فرم جستجو */
        .search-form {
            display: flex;
            gap: 40px;
        }

        .search-form div {
            flex: 1;
        }

        .search-btn-div{
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 25px;
        }

        .search-form button {
            height: 10px;
            flex: 0.5;
            background-color: #ede9e9;
            /* margin-top: 26px; */
        }


        .search-form select,
        .search-form button {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .loader {
            display:none;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #5e5a5a;
            width: 5px;
            height: 5px;
            padding: 8px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            position: absolute;
            margin: 0 45%;
            }

            /* Safari */
            @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>

    <script>
        window.onload = function() {
            updateCarLightOptions();
            updateCarHeavyOptions(); 
        }
        document.querySelectorAll(".tab-button").forEach(function (button) {
            button.addEventListener("click", function () {
                var tabId = this.getAttribute("data-tab");

                // مخفی کردن همه تب‌ها
                document.querySelectorAll(".tab-content").forEach(function (content) {
                    content.classList.remove("active");
                });

                // غیرفعال کردن همه دکمه‌های تب
                document.querySelectorAll(".tab-button").forEach(function (btn) {
                    btn.classList.remove("active");
                });

                // نمایش تب انتخاب شده
                document.getElementById("tab-" + tabId).classList.add("active");
                this.classList.add("active");
            });
        });

        // تابع جستجو
        function searchFilters(tabId) {
            document.querySelector(".loader-"+tabId).style.display = 'block';

            let form = document.getElementById("search-form-" + tabId);
            let filters = new FormData(form);

            const filter_1 = form.querySelector(`select[name="brand_car_light"], select[name="brand_car_heavy"],select[name="API"]`).value;
            const filter_2 = form.querySelector(`select[name="car_light"], select[name="car_heavy"],select[name="SAE"]`).value;
            
            let category
            var flag = false
 
            if (tabId == 1 || tabId == 2) {

                category = form.querySelector('select[name="product-category"]').value;

                if (category) {
                    flag = true
                }
            }
            
                      console.log(flag)

            let home_url = "<?= home_url() ?>"
            let url

            if (flag) {
                jQuery.ajax({
                    type: 'POST',
                    url: "<?= home_url('wp-admin/admin-ajax.php')  ?>",
                    data: {
                        action: 'get_category_slug',
                        term_id: category
                    },
                    success: function (response) {
                        window.location.href = home_url + "/product-category/" + response + '?filter_brand=' + filter_1 + '&' + 'filter_car=' + filter_2;
                    },
                    error: function (error) {
                        alert('خطایی رخ داده است')
                    }
                });
            } else {
                if (tabId == 1 || tabId == 2) {
                    window.location.href = home_url + '/shop/?filter_brand=' + filter_1 + '&' + 'filter_car=' + filter_2;
                }else{
                    window.location.href = home_url + '/shop/?filter_api=' + filter_1 + '&' + 'filter_sae=' + filter_2;
                }
            }
        }


const car_data = <?= json_encode($car_data) ?>; 

function updateCarLightOptions() {
    updateOptions("brand_car_light", "car_light", car_data.light);
}

function updateCarHeavyOptions() {
    updateOptions("brand_car_heavy", "car_heavy", car_data.heavy);
}

function updateOptions(brandElementId, carElementId, carData) {
    const selectedBrand = document.getElementById(brandElementId).value.split('-')[1]; 

    if (!selectedBrand) {
        return;
    }

    const carSelect = document.getElementById(carElementId);
    carSelect.innerHTML = '<option value="">انتخاب ماشین</option>';

    carData.forEach((item) => {
        const slugParts = item.slug.split('-');
        const brand = slugParts[1]; 

        if (brand === selectedBrand) {
            const option = document.createElement("option");
            option.value = item.slug;
            option.textContent = item.name;
            carSelect.appendChild(option);
        }
    });
}
    </script>


    <?php
    return ob_get_clean();
}

add_shortcode('custom_filters_shortcode', 'custom_filters_shortcode_function');


/**
 * Get Slug From Category Id
 *
 * @return void
 */
function get_category_slug(): void
{
    if (isset($_POST['term_id'])) {
        $term_id = intval($_POST['term_id']);
        $term = get_term($term_id, 'product_cat');

        if (!is_wp_error($term) && !empty($term)) {
            echo $term->slug;
        } else {
            echo '';
        }
    }

    wp_die();
}

add_action('wp_ajax_get_category_slug', 'get_category_slug');
add_action('wp_ajax_nopriv_get_category_slug', 'get_category_slug');


