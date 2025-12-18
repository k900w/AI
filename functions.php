<?php

/**
 * TEX-K Theme Functions
 *
 * @package TEX-K
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom Menu Walker for Header Navigation
 */
class Texk_Menu_Walker extends Walker_Nav_Menu
{
    /**
     * Start the element output
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'header__menu_item';

        // Check if item has children
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'header__menu_item--submenu';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id_attr = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id_attr = $id_attr ? ' id="' . esc_attr($id_attr) . '"' : '';

        $output .= $indent . '<li' . $id_attr . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'header__menu_item_link';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        // Add dropdown icon if has children
        $icon = '';
        if (in_array('menu-item-has-children', (array) $item->classes)) {
            $icon = '<span class="header__menu_item_link_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.333 213.333">
                            <path d="M0 53.333L106.667 160 213.333 53.333z" />
                        </svg>
                    </span>';
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= $icon;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Start the submenu output
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $class = ($depth == 0) ? 'catalog-menu' : 'catalog-menu__second-level';
        $output .= "\n$indent<ul class=\"$class\">\n";
    }

    /**
     * End the submenu output
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

/**
 * Custom Menu Walker for Mobile Navigation
 */
class Texk_Mobile_Menu_Walker extends Walker_Nav_Menu
{
    /**
     * Start the element output
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'mobile-menu__item';

        // Check if item has children
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'mobile-menu__item--has-children';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'mobile-menu__link';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Start the submenu output
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"mobile-menu__submenu\">\n";
    }

    /**
     * End the submenu output
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

// Theme setup
function texk_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'tex-k'),
        'top' => __('Top Menu', 'tex-k'),
        'footer' => __('Footer Menu', 'tex-k'),
    ));
}
add_action('after_setup_theme', 'texk_setup');

// Enqueue scripts and styles
function texk_scripts()
{
    // Styles
    wp_enqueue_style('texk-main', get_template_directory_uri() . '/assets/css/main.min.css', array(), '1.0.0');
    wp_enqueue_style('texk-header', get_template_directory_uri() . '/assets/css/header.css', array('texk-main'), '1.0.0');
    wp_enqueue_style('texk-home', get_template_directory_uri() . '/assets/css/home.min.css', array('texk-main'), '1.0.0');
    wp_enqueue_style('texk-banner', get_template_directory_uri() . '/assets/css/banner.min.css', array('texk-main'), '1.0.0');

    // Page styles (for static pages)
    if (is_page()) {
        wp_enqueue_style('texk-page', get_template_directory_uri() . '/assets/css/page.css', array('texk-main'), '1.0.0');
    }

    // Product page styles (only on single product page)
    if (is_singular('product')) {
        // Try minified version first, fallback to regular CSS
        $cart_css_min = get_template_directory() . '/assets/css/cart.min.css';
        $cart_css = get_template_directory() . '/assets/css/cart.css';

        if (file_exists($cart_css_min)) {
            wp_enqueue_style('texk-cart', get_template_directory_uri() . '/assets/css/cart.min.css', array('texk-main'), '1.0.0');
        } elseif (file_exists($cart_css)) {
            wp_enqueue_style('texk-cart', get_template_directory_uri() . '/assets/css/cart.css', array('texk-main'), '1.0.1');
        }
    }

    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('texk-main', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('texk-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery', 'texk-main'), '1.0.0', true);

    // Home page scripts (only on front page)
    if (is_front_page()) {
        // Check if home.min.js exists before enqueuing
        $home_js = get_template_directory() . '/assets/js/home.min.js';
        if (file_exists($home_js)) {
            wp_enqueue_script('texk-home', get_template_directory_uri() . '/assets/js/home.min.js', array('jquery', 'texk-main'), '1.0.0', true);
        }
    }

    // Product page scripts (only on single product page)
    if (is_singular('product')) {
        $cart_js = get_template_directory() . '/assets/js/cart.min.js';
        if (file_exists($cart_js)) {
            wp_enqueue_script('texk-cart', get_template_directory_uri() . '/assets/js/cart.min.js', array('jquery', 'texk-main'), '1.0.0', true);
        }

        // Slick Slider for product gallery
        wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
        wp_enqueue_style('slick-carousel-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array('slick-carousel'), '1.8.1');
        wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);

        // Fancybox for image lightbox
        wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css', array(), '5.0');
        wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', array('jquery'), '5.0', true);
        
        // Modal popup styles and scripts
        $modal_css = '
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            z-index: 10000;
            overflow-y: auto;
        }
        
        /* Modal Popup */
        .modal-popup {
            background: #ffffff;
            width: 700px;
            max-width: 95%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            margin-bottom: 50px;
        }
        
        /* Header */
        .modal-popup-header {
            background: #212121;
            color: #ffffff;
            padding: 25px;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.2;
            position: relative;
        }
        
        /* Close button */
        .modal-close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 28px;
            height: 28px;
            background: #e60023;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .modal-close-btn::before,
        .modal-close-btn::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 2px;
            height: 18px;
            background: #ffffff;
            transform-origin: center;
        }
        
        .modal-close-btn::before {
            transform: translate(-50%, -50%) rotate(45deg);
        }
        
        .modal-close-btn::after {
            transform: translate(-50%, -50%) rotate(-45deg);
        }
        
        /* Body */
        .modal-popup-body {
            display: flex;
            flex-wrap: wrap;
            padding: 40px 30px 30px;
            gap: 40px;
        }
        
        /* Left column */
        .modal-left {
            flex: 1 1 40%;
            min-width: 200px;
        }
        
        .modal-left p {
            color: #333;
            font-size: 16px;
            margin: 0 0 20px;
            line-height: 1.5;
        }
        
        .modal-type-box {
            border: 1px solid #e0e0e0;
            background: #f2f2f2;
            height: 80px;
            padding: 10px;
            font-size: 14px;
            color: #666;
            display: flex;
            align-items: flex-start;
        }
        
        /* Right column */
        .modal-right {
            flex: 1 1 50%;
            min-width: 250px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        /* Form controls */
        .modal-right input,
        .modal-right select {
            border: none;
            border-bottom: 2px solid #e60023;
            padding: 6px 4px;
            font-size: 15px;
            outline: none;
            width: 100%;
            background: transparent;
        }
        
        .modal-right input::placeholder {
            color: #999;
        }
        
        .modal-right select {
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
        }
        
        /* Select wrapper */
        .modal-select-wrapper {
            position: relative;
        }
        
        .modal-select-wrapper::after {
            content: "";
            position: absolute;
            right: 0;
            top: 50%;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 8px solid #e60023;
            transform: translateY(-50%);
            pointer-events: none;
        }
        
        /* Textarea */
        .modal-right textarea {
            border: 1px solid #e0e0e0;
            border-bottom: 2px solid #e60023;
            padding: 6px 4px;
            font-size: 15px;
            outline: none;
            height: 90px;
            resize: vertical;
            width: 100%;
        }
        
        /* Submit button */
        .modal-btn {
            margin-top: 20px;
            background: #e60023;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            padding: 14px 20px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
            align-self: flex-start;
        }
        
        .modal-btn:hover {
            background: #c7001a;
        }
        
        /* Consultation modal specific styles */
        .modal-consultation .modal-popup {
            width: 600px;
        }
        
        .modal-consultation-body {
            flex-direction: column;
            padding: 30px 40px 40px;
            gap: 0;
        }
        
        .modal-consultation-field {
            margin-bottom: 25px;
        }
        
        .modal-consultation-field label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 400;
        }
        
        .modal-consultation-field input,
        .modal-consultation-field textarea {
            width: 100%;
            border: none;
            border-bottom: 2px solid #e30f1b;
            padding: 8px 0;
            font-size: 15px;
            outline: none;
            background: transparent;
            font-family: inherit;
        }
        
        .modal-consultation-field textarea {
            border: none;
            border-bottom: 2px solid #e30f1b;
            resize: vertical;
            min-height: 80px;
            padding: 8px 0;
        }
        
        .modal-consultation-field input::placeholder,
        .modal-consultation-field textarea::placeholder {
            color: #999;
        }
        
        .modal-consultation-btn {
            width: 100%;
            background: #e30f1b;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
            margin-top: 10px;
            text-transform: uppercase;
        }
        
        .modal-consultation-btn:hover {
            background: #c00e18;
        }
        
        .modal-consultation-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        /* Test drive modal specific styles */
        .modal-test-drive .modal-popup {
            width: 900px;
            max-width: 95%;
        }
        
        .test-drive {
            background: #fff;
        }
        
        .test-drive-header {
            background: #212121;
            color: #ffffff;
            padding: 25px 30px;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.2;
            position: relative;
        }
        
        .test-drive-header .modal-close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
        }
        
        .test-drive-header h2 {
            margin: 0;
            padding-right: 40px;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.2;
            color: #ffffff;
        }
        
        .test-drive-content {
            display: flex;
            gap: 40px;
            padding: 40px 30px;
            flex-wrap: wrap;
        }
        
        .test-drive-left {
            flex: 1 1 45%;
            min-width: 280px;
        }
        
        .test-drive-left .description {
            color: #333;
            font-size: 16px;
            line-height: 1.5;
            margin: 0 0 30px;
        }
        
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        
        .feature-icon {
            width: 48px;
            height: 48px;
            background: #e30f1b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .feature-icon svg {
            width: 32px;
            height: 32px;
        }
        
        .feature-text {
            flex: 1;
        }
        
        .feature-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
        }
        
        .test-drive-form {
            flex: 1 1 45%;
            min-width: 280px;
        }
        
        .test-drive-form .form-group {
            margin-bottom: 20px;
        }
        
        .test-drive-form input,
        .test-drive-form textarea {
            width: 100%;
            border: none;
            border-bottom: 2px solid #e30f1b;
            padding: 10px 0;
            font-size: 15px;
            outline: none;
            background: transparent;
            font-family: inherit;
        }
        
        .test-drive-form textarea {
            min-height: 80px;
            resize: vertical;
        }
        
        .test-drive-form input::placeholder,
        .test-drive-form textarea::placeholder {
            color: #999;
        }
        
        .test-drive-submit-btn {
            width: 100%;
            background: #e30f1b;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
            margin-top: 10px;
            text-transform: uppercase;
        }
        
        .test-drive-submit-btn:hover {
            background: #c00e18;
        }
        
        .test-drive-submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        @media (max-width: 768px) {
            .test-drive-content {
                flex-direction: column;
            }
            
            .test-drive-left,
            .test-drive-form {
                flex: 1 1 100%;
            }
        }
        ';
        // Add modal styles - use cart style if exists, otherwise main style
        $cart_style_loaded = false;
        if (file_exists($cart_css_min) || file_exists($cart_css)) {
            wp_add_inline_style('texk-cart', $modal_css);
            $cart_style_loaded = true;
        }
        if (!$cart_style_loaded) {
            wp_add_inline_style('texk-main', $modal_css);
        }
        
        // Modal popup JavaScript
        $modal_js = '
        jQuery(document).ready(function($) {
            // Open modal on button click
            $(".show-modal-config, .show-modal-demo, .show-modal-consultation, .show-modal-test_drive").on("click", function(e) {
                e.preventDefault();
                var modalId;
                if ($(this).hasClass("show-modal-config")) {
                    modalId = "#modal-config-popup";
                } else if ($(this).hasClass("show-modal-demo")) {
                    modalId = "#modal-demo-popup";
                } else if ($(this).hasClass("show-modal-consultation")) {
                    modalId = "#modal-consultation-popup";
                } else if ($(this).hasClass("show-modal-test_drive")) {
                    modalId = "#modal-test_drive-popup";
                }
                if (modalId) {
                    $(modalId).fadeIn(300);
                    $("body").css("overflow", "hidden");
                }
            });
            
            // Close modal on close button click
            $(".modal-close-btn").on("click", function() {
                $(this).closest(".modal-overlay").fadeOut(300);
                $("body").css("overflow", "");
            });
            
            // Close modal on overlay click
            $(".modal-overlay").on("click", function(e) {
                if ($(e.target).hasClass("modal-overlay")) {
                    $(this).fadeOut(300);
                    $("body").css("overflow", "");
                }
            });
            
            // Close modal on ESC key
            $(document).on("keydown", function(e) {
                if (e.key === "Escape") {
                    $(".modal-overlay").fadeOut(300);
                    $("body").css("overflow", "");
                }
            });
            
            // Form submission via AJAX
            $("#config-request-form, #demo-request-form, #consultation-request-form, #test-drive-request-form").on("submit", function(e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $form.find(".modal-btn, .test-drive-submit-btn");
                var originalText = $btn.text();
                
                $btn.prop("disabled", true).text("Відправка...");
                
                $.ajax({
                    url: $form.attr("action"),
                    type: "POST",
                    data: $form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            $form.html("<p style=\'padding: 20px; text-align: center; color: #4caf50; font-size: 18px;\'>Дякуємо! Ваша заявка відправлена.</p>");
                            setTimeout(function() {
                                $form.closest(".modal-overlay").fadeOut(300);
                                $("body").css("overflow", "");
                            }, 2000);
                        } else {
                            alert("Помилка: " + (response.data ? response.data.message : "Спробуйте ще раз"));
                            $btn.prop("disabled", false).text(originalText);
                        }
                    },
                    error: function() {
                        alert("Помилка відправки. Спробуйте ще раз.");
                        $btn.prop("disabled", false).text(originalText);
                    }
                });
            });
        });
        ';
        // Add modal script - use cart script if exists, otherwise main script
        $cart_script_loaded = false;
        if (file_exists($cart_js)) {
            wp_add_inline_script('texk-cart', $modal_js);
            $cart_script_loaded = true;
        }
        if (!$cart_script_loaded) {
            wp_add_inline_script('texk-main', $modal_js);
        }
    }

    // Owl Carousel - using CDN since files don't exist locally (for other pages)
    if (!is_singular('product')) {
        wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
        wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    }
    
    // Owl Carousel для страницы категории товаров (если нужен слайдер)
    if (is_tax('product_category') || is_tax('product_cat')) {
        wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
        wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    }
}
add_action('wp_enqueue_scripts', 'texk_scripts');

// Register Custom Post Type for Products
function texk_register_product_post_type()
{
    $labels = array(
        'name' => __('Товари', 'tex-k'),
        'singular_name' => __('Товар', 'tex-k'),
        'menu_name' => __('Товари', 'tex-k'),
        'add_new' => __('Додати новий', 'tex-k'),
        'add_new_item' => __('Додати новий товар', 'tex-k'),
        'edit_item' => __('Редагувати товар', 'tex-k'),
        'new_item' => __('Новий товар', 'tex-k'),
        'view_item' => __('Переглянути товар', 'tex-k'),
        'search_items' => __('Шукати товари', 'tex-k'),
        'not_found' => __('Товари не знайдено', 'tex-k'),
        'not_found_in_trash' => __('У кошику товарів не знайдено', 'tex-k'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cart',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
    );

    register_post_type('product', $args);
}
add_action('init', 'texk_register_product_post_type');

// Register Custom Taxonomy for Product Categories
function texk_register_product_taxonomy()
{
    $labels = array(
        'name' => __('Категорії товарів', 'tex-k'),
        'singular_name' => __('Категорія товару', 'tex-k'),
        'search_items' => __('Шукати категорії', 'tex-k'),
        'all_items' => __('Всі категорії', 'tex-k'),
        'parent_item' => __('Батьківська категорія', 'tex-k'),
        'parent_item_colon' => __('Батьківська категорія:', 'tex-k'),
        'edit_item' => __('Редагувати категорію', 'tex-k'),
        'update_item' => __('Оновити категорію', 'tex-k'),
        'add_new_item' => __('Додати нову категорію', 'tex-k'),
        'new_item_name' => __('Назва нової категорії', 'tex-k'),
        'menu_name' => __('Категорії', 'tex-k'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-category'),
        'show_in_rest' => true,
    );

    register_taxonomy('product_category', array('product'), $args);
}
add_action('init', 'texk_register_product_taxonomy');

// ACF JSON Save Point
function texk_acf_json_save_point($path)
{
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}
add_filter('acf/settings/save_json', 'texk_acf_json_save_point');

// ACF JSON Load Point
function texk_acf_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'texk_acf_json_load_point');

// Add image sizes
function texk_image_sizes()
{
    add_image_size('product-thumb', 300, 300, true);
    add_image_size('product-large', 800, 600, true);
    add_image_size('banner-large', 1920, 800, true);
}
add_action('after_setup_theme', 'texk_image_sizes');

/**
 * Исправление запроса для таксономии product_category
 * WordPress по умолчанию ищет 'post', а нам нужен 'product'
 */
function texk_product_category_query($query)
{
    if (!is_admin() && $query->is_main_query()) {
        // Для архива таксономии product_category
        if ($query->is_tax('product_category')) {
            $query->set('post_type', 'product');
            $query->set('posts_per_page', 12);
        }
        // Для архива типа product
        if ($query->is_post_type_archive('product')) {
            $query->set('posts_per_page', 12);
        }
    }
}
add_action('pre_get_posts', 'texk_product_category_query');

/**
 * Добавляем CSS для страниц категорий товаров
 */
function texk_product_category_styles()
{
    if (is_tax('product_category') || is_post_type_archive('product')) {
        wp_enqueue_style('texk-products', get_template_directory_uri() . '/assets/css/products.css', array('texk-main'), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'texk_product_category_styles');

/**
 * Сессия и корзина запчастей
 */
function texk_start_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'texk_start_session', 1);

function texk_get_cart_items()
{
    if (!isset($_SESSION['texk_cart']) || !is_array($_SESSION['texk_cart'])) {
        return array();
    }
    return array_values(array_unique(array_map('intval', $_SESSION['texk_cart'])));
}

function texk_cart_count()
{
    return count(texk_get_cart_items());
}

function texk_is_in_cart($product_id)
{
    return in_array((int)$product_id, texk_get_cart_items(), true);
}

function texk_ajax_add_to_cart()
{
    check_ajax_referer('texk_cart_nonce', 'nonce');

    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    if (!$product_id || get_post_type($product_id) !== 'product') {
        wp_send_json_error(array('message' => 'Товар не знайдено'));
    }

    if (!isset($_SESSION['texk_cart']) || !is_array($_SESSION['texk_cart'])) {
        $_SESSION['texk_cart'] = array();
    }

    if (!in_array($product_id, $_SESSION['texk_cart'], true)) {
        $_SESSION['texk_cart'][] = $product_id;
    }

    wp_send_json_success(array('count' => texk_cart_count()));
}
add_action('wp_ajax_texk_add_to_cart', 'texk_ajax_add_to_cart');
add_action('wp_ajax_nopriv_texk_add_to_cart', 'texk_ajax_add_to_cart');

function texk_ajax_order_parts()
{
    check_ajax_referer('texk_cart_nonce', 'nonce');

    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    $items = texk_get_cart_items();

    if (empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => 'Заповніть ім’я та телефон'));
    }

    $subject = 'Замовлення запчастин з сайту';
    $body = "Ім'я: {$name}\nТелефон: {$phone}\nEmail: {$email}\nКоментар: {$comment}\n";
    $body .= "Товари: " . (empty($items) ? 'немає' : implode(', ', $items));

    wp_mail(get_option('admin_email'), $subject, $body);

    $_SESSION['texk_cart'] = array();

    wp_send_json_success(array('message' => 'Відправлено', 'count' => 0));
}
add_action('wp_ajax_texk_order_parts', 'texk_ajax_order_parts');
add_action('wp_ajax_nopriv_texk_order_parts', 'texk_ajax_order_parts');

function texk_cart_scripts()
{
    if (is_singular('product') || is_post_type_archive('product') || is_tax('product_category')) {
        wp_enqueue_script('texk-cart-custom', get_template_directory_uri() . '/assets/js/cart-custom.js', array('jquery'), '1.0.0', true);
        wp_localize_script('texk-cart-custom', 'texkCart', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('texk_cart_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'texk_cart_scripts');

/**
 * Определяем, относится ли товар к разделу "Запчастини"
 *
 * Используем slug корневой категории из импорта Bitrix (zapchasti) и резервные проверки,
 * чтобы не зависеть от числовых slug'ов.
 */
function texk_is_parts_product($post_id = null)
{
    $post_id = $post_id ?: get_queried_object_id();
    if (!$post_id || get_post_type($post_id) !== 'product') {
        return false;
    }

    // Собираем термины из обеих таксономий, чтобы не зависеть от product_cat
    $terms = wp_get_post_terms($post_id, 'product_category');
    $terms_cat = wp_get_post_terms($post_id, 'product_cat');
    if (!is_wp_error($terms_cat) && !empty($terms_cat)) {
        $terms = array_merge((array)$terms, (array)$terms_cat);
    }
    if (empty($terms) || is_wp_error($terms)) {
        return false;
    }

    $parts_slugs = array('zapchasti', 'zapchasti1', 'zapchast', 'zapchastini', 'parts');

    foreach ($terms as $term) {
        // Прямая проверка slug
        if (in_array($term->slug, $parts_slugs, true)) {
            return true;
        }

        // Проверка имени (UA/RU) на вхождение "запчаст"
        if (stripos($term->name, 'запчаст') !== false) {
            return true;
        }

        // Поднимаемся по иерархии до корня
        $parent_id = $term->parent;
        while ($parent_id) {
            $parent = get_term($parent_id, 'product_category');
            if (!$parent || is_wp_error($parent)) {
                break;
            }

            if (in_array($parent->slug, $parts_slugs, true) || stripos($parent->name, 'запчаст') !== false) {
                return true;
            }

            $parent_id = $parent->parent;
        }
    }

    return false;
}

/**
 * Подменяем шаблон single-product для запчастей
 */
function texk_single_product_template($template)
{
    if (is_singular('product') && texk_is_parts_product()) {
        $parts_template = locate_template('single-product-part.php');
        if (!empty($parts_template)) {
            return $parts_template;
        }
    }

    return $template;
}
add_filter('single_template', 'texk_single_product_template');

/**
 * Подменяем template_include для запчастей (обходит wc loader)
 */
function texk_parts_template_include($template)
{
    if (is_singular('product') && texk_is_parts_product()) {
        $parts_template = locate_template('single-product-part.php');
        if (!empty($parts_template)) {
            return $parts_template;
        }
    }
    return $template;
}
add_filter('template_include', 'texk_parts_template_include', 20);

/**
 * Woo cart fragments for header count
 */
function texk_woo_cart_fragments($fragments)
{
    ob_start();
    ?>
    <div class="header_basket__count"><?php echo (WC()->cart) ? intval(WC()->cart->get_cart_contents_count()) : 0; ?></div>
    <?php
    $fragments['div.header_basket__count'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'texk_woo_cart_fragments');

/**
 * Enqueue cart fragments script on front
 */
function texk_enqueue_cart_fragments()
{
    if (!is_admin()) {
        wp_enqueue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'texk_enqueue_cart_fragments');


/**
 * Добавляем CSS для страниц блога (Агроблог)
 */
function texk_blog_styles()
{
    if (is_singular('post') || is_home() || is_archive() || is_page_template('template-agroblog.php') || is_category() || is_tag()) {
        wp_enqueue_style('texk-blog', get_template_directory_uri() . '/assets/css/blog.css', array('texk-main'), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'texk_blog_styles');

/**
 * Сортировка категорий товаров
 * Позволяет управлять порядком через ACF поле 'category_order'
 * 
 * @param array $categories Массив объектов категорий
 * @param string $orderby Критерий сортировки: 'order' (по ACF полю), 'name', 'count', 'term_id'
 * @param string $order Направление: 'ASC' или 'DESC'
 * @return array Отсортированный массив категорий
 */
function texk_sort_product_categories($categories, $orderby = 'order', $order = 'ASC')
{
    if (empty($categories) || is_wp_error($categories)) {
        return $categories;
    }

    // Преобразуем в массив для работы с usort
    $categories_array = is_array($categories) ? $categories : (array)$categories;

    switch ($orderby) {
        case 'order':
            // Сортировка по ACF полю 'category_order'
            usort($categories_array, function ($a, $b) use ($order) {
                $order_a = get_field('category_order', 'product_category_' . $a->term_id);
                $order_b = get_field('category_order', 'product_category_' . $b->term_id);

                // Если поле не установлено, используем значение по умолчанию (999 - в конец)
                $order_a = $order_a !== false && $order_a !== null ? (int)$order_a : 999;
                $order_b = $order_b !== false && $order_b !== null ? (int)$order_b : 999;

                // Сначала по порядку, затем по названию
                if ($order_a === $order_b) {
                    $result = strcmp($a->name, $b->name);
                } else {
                    $result = $order_a <=> $order_b;
                }

                return $order === 'DESC' ? -$result : $result;
            });
            break;

        case 'name':
            usort($categories_array, function ($a, $b) use ($order) {
                $result = strcmp($a->name, $b->name);
                return $order === 'DESC' ? -$result : $result;
            });
            break;

        case 'count':
            usort($categories_array, function ($a, $b) use ($order) {
                $result = $a->count <=> $b->count;
                return $order === 'DESC' ? -$result : $result;
            });
            break;

        case 'term_id':
            usort($categories_array, function ($a, $b) use ($order) {
                $result = $a->term_id <=> $b->term_id;
                return $order === 'DESC' ? -$result : $result;
            });
            break;

        default:
            // По умолчанию - без изменений
            break;
    }

    return $categories_array;
}

/**
 * Исправляем permalink для постов блога
 * Заменяем %product_category% на 'novosti-sobytiya' для обычных постов
 */
function texk_blog_post_link($permalink, $post)
{
    if ($post->post_type !== 'post') {
        return $permalink;
    }

    // Если permalink содержит %product_category% - заменяем на novosti-sobytiya
    if (strpos($permalink, '%product_category%') !== false) {
        $permalink = str_replace('%product_category%', 'novosti-sobytiya', $permalink);
    }

    // Если permalink содержит %category% - заменяем на novosti-sobytiya
    if (strpos($permalink, '%category%') !== false) {
        $permalink = str_replace('%category%', 'novosti-sobytiya', $permalink);
    }

    // Если permalink начинается с /catalog/ - заменяем на /novosti-sobytiya/
    if (strpos($permalink, '/catalog/') === 0 || strpos($permalink, 'catalog/') !== false) {
        $permalink = preg_replace('#/catalog/[^/]+/#', '/novosti-sobytiya/', $permalink);
    }

    return $permalink;
}
add_filter('post_link', 'texk_blog_post_link', 10, 2);
add_filter('post_type_link', 'texk_blog_post_link', 10, 2);

/**
 * Добавляем rewrite rules для блога
 */
function texk_blog_rewrite_rules()
{
    // Rewrite rule для блога: /novosti-sobytiya/post-slug/ -> post
    add_rewrite_rule(
        '^novosti-sobytiya/([^/]+)/?$',
        'index.php?name=$matches[1]',
        'top'
    );

    // Rewrite rule для архива блога: /novosti-sobytiya/ -> blog archive
    add_rewrite_rule(
        '^novosti-sobytiya/?$',
        'index.php?pagename=novosti-sobytiya',
        'top'
    );

    // Rewrite rule для пагинации блога: /novosti-sobytiya/page/2/
    add_rewrite_rule(
        '^novosti-sobytiya/page/([0-9]+)/?$',
        'index.php?pagename=novosti-sobytiya&paged=$matches[1]',
        'top'
    );
}
add_action('init', 'texk_blog_rewrite_rules');

/**
 * Flush rewrite rules при активации темы
 */
function texk_flush_rewrite_rules()
{
    texk_blog_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'texk_flush_rewrite_rules');

/**
 * Получение курсов валют из API НБУ с кешированием
 * Кеш обновляется раз в день
 * 
 * @return array Массив курсов валют ['USD' => 42.1936, 'EUR' => 49.4678, ...]
 */
function texk_get_currency_rates()
{
    $cache_key = 'texk_nbu_currency_rates';
    $cache_expiry = DAY_IN_SECONDS; // 24 часа
    
    // Пытаемся получить из кеша
    $rates = get_transient($cache_key);
    
    if (false !== $rates) {
        return $rates;
    }
    
    // Если кеш истек, получаем новые данные
    $api_url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange';
    
    $response = wp_remote_get($api_url, array(
        'timeout' => 10,
        'sslverify' => true,
    ));
    
    if (is_wp_error($response)) {
        // В случае ошибки пытаемся вернуть последние известные курсы из опции
        $rates = get_option('texk_nbu_currency_rates_backup', array());
        if (empty($rates)) {
            $rates = array();
        }
    } else {
        $body = wp_remote_retrieve_body($response);
        $xml = simplexml_load_string($body);
        
        $rates = array();
        
        if ($xml && isset($xml->currency)) {
            foreach ($xml->currency as $currency) {
                $cc = (string)$currency->cc;
                $rate = (float)$currency->rate;
                
                // Сохраняем только нужные валюты (USD, EUR)
                if (in_array($cc, array('USD', 'EUR'))) {
                    $rates[$cc] = $rate;
                }
            }
        }
        
        // UAH всегда равен 1 (базовая валюта)
        $rates['UAH'] = 1.0;
        
        // Сохраняем резервную копию на случай ошибки API в будущем
        if (!empty($rates)) {
            update_option('texk_nbu_currency_rates_backup', $rates);
        }
    }
    
    // Сохраняем в кеш на 24 часа
    if (!empty($rates)) {
        set_transient($cache_key, $rates, $cache_expiry);
    }
    
    return $rates;
}

/**
 * Конвертация цены товара в UAH для товаров категории "Запчасти"
 * 
 * @param float $price Исходная цена
 * @param string $currency Код валюты (UAH, USD, EUR)
 * @param int|null $post_id ID товара (для проверки категории)
 * @param bool $force_convert Принудительная конвертация (игнорирует проверку категории)
 * @return array Массив с ключами: 'price' (конвертированная цена), 'currency' (UAH), 'original_price', 'original_currency'
 */
function texk_convert_price_to_uah($price, $currency, $post_id = null, $force_convert = false)
{
    // Если цена пустая или равна нулю, возвращаем как есть
    if (empty($price) || $price == 0) {
        return array(
            'price' => $price,
            'currency' => $currency ?: 'UAH',
            'original_price' => $price,
            'original_currency' => $currency ?: 'UAH'
        );
    }
    
    // Нормализуем валюту
    $currency_clean = trim($currency);
    if (empty($currency_clean) || $currency_clean === 'грн') {
        $currency_clean = 'UAH';
    }
    
    // Если валюта уже UAH, возвращаем как есть
    if (strtoupper($currency_clean) === 'UAH') {
        return array(
            'price' => $price,
            'currency' => 'UAH',
            'original_price' => $price,
            'original_currency' => 'UAH'
        );
    }
    
    // Проверяем, относится ли товар к категории "Запчасти" (если не принудительная конвертация)
    if (!$force_convert && $post_id && function_exists('texk_is_parts_product')) {
        if (!texk_is_parts_product($post_id)) {
            // Не запчасти - возвращаем исходную цену без конвертации
            return array(
                'price' => $price,
                'currency' => $currency_clean,
                'original_price' => $price,
                'original_currency' => $currency_clean
            );
        }
    }
    
    // Нормализуем код валюты
    $currency_upper = strtoupper($currency_clean);
    
    // Получаем курсы валют
    $rates = texk_get_currency_rates();
    
    // Если курс не найден, возвращаем исходную цену
    if (empty($rates) || !isset($rates[$currency_upper])) {
        return array(
            'price' => $price,
            'currency' => $currency_clean,
            'original_price' => $price,
            'original_currency' => $currency_clean
        );
    }
    
    // Конвертируем цену в UAH
    $converted_price = $price * $rates[$currency_upper];
    
    return array(
        'price' => $converted_price,
        'currency' => 'UAH',
        'original_price' => $price,
        'original_currency' => $currency_upper
    );
}

/**
 * Конвертация цены в попапе корзины YITH для товаров категории "Запчасти"
 * 
 * @param string $price_html Отформатированная HTML-строка с ценой
 * @param array $cart_item Элемент корзины
 * @param string $cart_item_key Ключ элемента корзины
 * @return string Отформатированная HTML-строка с конвертированной ценой
 */
function texk_convert_cart_item_price_in_popup($price_html, $cart_item, $cart_item_key)
{
    // Проверяем, что это запчасти и есть ACF поля
    if (empty($cart_item) || empty($cart_item['product_id'])) {
        return $price_html;
    }
    
    $product_id = $cart_item['product_id'];
    
    // Проверяем, относится ли товар к категории "Запчасти"
    if (!function_exists('texk_is_parts_product') || !texk_is_parts_product($product_id)) {
        return $price_html;
    }
    
    // Получаем ACF поля для цены и валюты
    if (!function_exists('get_field')) {
        return $price_html;
    }
    
    $original_price = get_field('product_price', $product_id);
    $original_currency = get_field('product_currency', $product_id);
    
    // Если нет ACF полей или валюта уже UAH, возвращаем как есть
    if (empty($original_price) || empty($original_currency) || $original_currency === 'UAH' || $original_currency === 'грн') {
        return $price_html;
    }
    
    // Конвертируем цену
    $price_data = texk_convert_price_to_uah($original_price, $original_currency, $product_id, true);
    
    if ($price_data['currency'] === 'UAH' && $price_data['price'] != $original_price) {
        // Заменяем цену в HTML на конвертированную
        $converted_price = number_format((float)$price_data['price'], 2, '.', '');
        
        // Парсим HTML и заменяем цену
        // WooCommerce форматирует цену как: <span class="woocommerce-Price-amount amount">цена<span class="woocommerce-Price-currencySymbol">валюта</span></span>
        // Или просто как текст с валютой
        $converted_price_html = wc_price($price_data['price']);
        
        return $converted_price_html;
    }
    
    return $price_html;
}
add_filter('woocommerce_cart_item_price', 'texk_convert_cart_item_price_in_popup', 10, 3);

/**
 * Конвертация цены товара WooCommerce для попапа (перехватываем цену до форматирования)
 * 
 * @param float $price Цена товара
 * @param WC_Product $product Объект товара
 * @return float Конвертированная цена
 */
function texk_convert_wc_product_price_for_parts($price, $product)
{
    if (!$product || !method_exists($product, 'get_id')) {
        return $price;
    }
    
    $product_id = $product->get_id();
    
    // Проверяем, относится ли товар к категории "Запчасти"
    if (!function_exists('texk_is_parts_product') || !texk_is_parts_product($product_id)) {
        return $price;
    }
    
    // Получаем ACF поля для цены и валюты
    if (!function_exists('get_field')) {
        return $price;
    }
    
    $acf_price = get_field('product_price', $product_id);
    $acf_currency = get_field('product_currency', $product_id);
    
    // Если есть ACF поля, используем их вместо WooCommerce цены
    if (!empty($acf_price) && !empty($acf_currency) && $acf_currency !== 'UAH' && $acf_currency !== 'грн') {
        // Конвертируем цену из ACF полей
        $price_data = texk_convert_price_to_uah($acf_price, $acf_currency, $product_id, true);
        
        if ($price_data['currency'] === 'UAH' && $price_data['price'] != $acf_price) {
            return $price_data['price'];
        }
    }
    
    return $price;
}
add_filter('woocommerce_product_get_price', 'texk_convert_wc_product_price_for_parts', 10, 2);
add_filter('woocommerce_product_get_regular_price', 'texk_convert_wc_product_price_for_parts', 10, 2);
add_filter('woocommerce_product_get_sale_price', 'texk_convert_wc_product_price_for_parts', 10, 2);

/**
 * Перmalink для запчастей: /parts/{slug}/
 */
function texk_parts_product_link($permalink, $post)
{
    if ($post->post_type === 'product' && texk_is_parts_product($post->ID)) {
        return home_url('/parts/' . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_type_link', 'texk_parts_product_link', 10, 2);

function texk_parts_rewrite_rules()
{
    add_rewrite_rule(
        '^parts/([^/]+)/?$',
        'index.php?post_type=product&name=$matches[1]',
        'top'
    );
}
add_action('init', 'texk_parts_rewrite_rules', 20);

/**
 * WooCommerce Integration Fixes
 */

/**
 * Перенаправляем WooCommerce таксономию product_cat на кастомную product_category
 */
add_filter('woocommerce_product_query_tax_query', 'texk_redirect_product_cat_to_product_category', 10, 2);
function texk_redirect_product_cat_to_product_category($tax_query, $query) {
    if (isset($_GET['product_cat'])) {
        // Если запрос пришел с product_cat, перенаправляем на product_category
        $term_slug = sanitize_text_field($_GET['product_cat']);
        $term = get_term_by('slug', $term_slug, 'product_category');

        if ($term) {
            wp_redirect(get_term_link($term, 'product_category'));
            exit;
        }
    }

    return $tax_query;
}

/**
 * Изменяем основной запрос WooCommerce для работы с product_category
 */
add_action('pre_get_posts', 'texk_modify_woocommerce_query', 20);
function texk_modify_woocommerce_query($query) {
    if (!is_admin() && $query->is_main_query()) {

        // Для архива товаров - используем кастомный тип product
        if ($query->is_post_type_archive('product')) {
            $query->set('post_type', 'product');
            $query->set('posts_per_page', 12);
        }

        // Для таксономии product_cat - перенаправляем на product_category
        if ($query->is_tax('product_cat')) {
            $current_term = get_queried_object();

            // Ищем соответствующий термин в product_category
            $product_category_term = get_term_by('slug', $current_term->slug, 'product_category');

            if ($product_category_term) {
                // Меняем запрос на product_category
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'product_category',
                        'field'    => 'term_id',
                        'terms'    => $product_category_term->term_id,
                    )
                ));
                $query->set('post_type', 'product');
                $query->set('posts_per_page', 12);
            }
        }
    }
}

/**
 * Добавляем поддержку WooCommerce в тему
 */
add_action('after_setup_theme', 'texk_add_woocommerce_support');
function texk_add_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

/**
 * WooCommerce Price Integration with ACF
 * Подстановка цены из ACF поля 'product_price' в WooCommerce
 */

/**
 * Получить цену из ACF поля
 */
function texk_get_acf_price($product_id) {
    if (!$product_id) {
        return null;
    }

    // Получаем цену из ACF поля
    $acf_price = get_field('product_price', $product_id);

    // Если цена существует (даже 0) и не пустая строка
    if ($acf_price !== null && $acf_price !== '' && $acf_price !== false) {
        // Приводим к float
        $price = floatval($acf_price);

        // Возвращаем цену, даже если она 0 (нужно для логики доступности)
        return $price;
    }

    return null;
}

/**
 * Фильтр для основной цены товара
 */
if (!defined('TEXK_USE_ACF_PRICE')) define('TEXK_USE_ACF_PRICE', false);
if (TEXK_USE_ACF_PRICE) {
add_filter('woocommerce_product_get_price', 'texk_acf_price_filter', 10, 2);
add_filter('woocommerce_product_get_regular_price', 'texk_acf_price_filter', 10, 2);
add_filter('woocommerce_product_variation_get_price', 'texk_acf_price_filter', 10, 2);
add_filter('woocommerce_product_variation_get_regular_price', 'texk_acf_price_filter', 10, 2);

function texk_acf_price_filter($price, $product) {
    // Получаем цену из ACF
    $acf_price = texk_get_acf_price($product->get_id());

    // Если ACF цена найдена, используем её
    if ($acf_price !== null) {
        return $acf_price;
    }

    // Иначе возвращаем оригинальную цену
    return $price;
}

/**
 * Фильтр для цены продажи (если нужно)
 */
add_filter('woocommerce_product_get_sale_price', 'texk_acf_sale_price_filter', 10, 2);
add_filter('woocommerce_product_variation_get_sale_price', 'texk_acf_sale_price_filter', 10, 2);

function texk_acf_sale_price_filter($sale_price, $product) {
    // Пока что возвращаем null (без скидки)
    // В будущем можно добавить логику для поля sale_price
    return $sale_price;
}

/**
 * Фильтр для HTML отображения цены
 */
add_filter('woocommerce_get_price_html', 'texk_acf_price_html_filter', 10, 2);

function texk_acf_price_html_filter($price_html, $product) {
    // Получаем ACF цену
    $acf_price = texk_get_acf_price($product->get_id());

    if ($acf_price !== null) {
        // Получаем валюту из ACF
        $currency = get_field('product_currency', $product->get_id()) ?: 'UAH';

        // Форматируем цену
        $formatted_price = number_format($acf_price, 0, ',', ' ') . ' ' . $currency;

        // Возвращаем отформатированную цену
        return '<span class="woocommerce-Price-amount amount"><bdi>' . $formatted_price . '</bdi></span>';
    }

    // Возвращаем оригинальный HTML
    return $price_html;
}

/**
 * Обновление доступности товара на основе цены
 */
add_filter('woocommerce_is_purchasable', 'texk_product_purchasable', 10, 2);
add_filter('woocommerce_product_is_in_stock', 'texk_product_in_stock', 10, 2);

function texk_product_purchasable($is_purchasable, $product) {
    if (!$product) {
        return $is_purchasable;
    }

    $acf_price = texk_get_acf_price($product->get_id());

    // Товар можно купить только если цена > 0
    if ($acf_price !== null && $acf_price > 0) {
        return true;
    }

    // Если цены нет или цена = 0 - товар нельзя купить
    return false;
}

function texk_product_in_stock($is_in_stock, $product) {
    if (!$product) {
        return $is_in_stock;
    }

    $acf_price = texk_get_acf_price($product->get_id());

    // Товар в наличии только если цена > 0
    if ($acf_price !== null && $acf_price > 0) {
        return true;
    }

    // Если цены нет или цена = 0 - товара нет в наличии
    return false;
}

/**
 * Дополнительные фильтры для вариативных товаров
 */
add_filter('woocommerce_variation_prices_price', 'texk_acf_variation_price', 10, 3);
add_filter('woocommerce_variation_prices_regular_price', 'texk_acf_variation_price', 10, 3);
}

function texk_acf_variation_price($price, $variation, $product) {
    // Для вариаций используем ту же логику
    $acf_price = texk_get_acf_price($variation->get_id());

    if ($acf_price !== null) {
        return $acf_price;
    }

    return $price;
}

/**
 * Регистрация ACF Options Page для настроек главной страницы
 */
add_action('acf/init', 'texk_add_options_page');
function texk_add_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Настройки главной страницы',
            'menu_title' => 'Главная страница',
            'menu_slug' => 'home-page-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-admin-home',
        ));
        
        // Добавляем страницу настроек меню
        acf_add_options_sub_page(array(
            'page_title' => 'Настройки меню',
            'menu_title' => 'Настройки меню',
            'menu_slug' => 'menu-settings',
            'parent_slug' => 'home-page-settings',
            'capability' => 'edit_posts',
        ));
    }
}

/**
 * Регистрация ACF полей для выбора категорий в меню "ТЕХНИКА"
 */
add_action('acf/init', 'texk_register_menu_categories_field');
function texk_register_menu_categories_field() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_menu_settings',
            'title' => 'Настройки меню',
            'fields' => array(
                array(
                    'key' => 'field_menu_technika_categories',
                    'label' => 'Категории для меню "ТЕХНИКА"',
                    'name' => 'menu_technika_categories',
                    'type' => 'taxonomy',
                    'instructions' => 'Выберите категории товаров, которые будут отображаться в меню "ТЕХНИКА". Если ничего не выбрано, будут показаны все корневые категории.',
                    'required' => 0,
                    'taxonomy' => 'product_category',
                    'field_type' => 'multi_select',
                    'allow_null' => 1,
                    'return_format' => 'id',
                    'multiple' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'menu-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
        ));
    }
}

/**
 * Регистрация ACF полей для выбора категорий на главной странице
 */
add_action('acf/init', 'texk_register_home_categories_field');
function texk_register_home_categories_field() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_home_categories',
            'title' => 'Категории на главной странице',
            'fields' => array(
                array(
                    'key' => 'field_home_categories_select',
                    'label' => 'Выберите категории для отображения',
                    'name' => 'home_categories_select',
                    'type' => 'taxonomy',
                    'instructions' => 'Выберите категории продуктов, которые будут отображаться на главной странице. Если ничего не выбрано, будут показаны все категории.',
                    'required' => 0,
                    'taxonomy' => 'product_category',
                    'field_type' => 'multi_select',
                    'allow_null' => 1,
                    'return_format' => 'id',
                    'multiple' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'home-page-settings',
                    ),
                ),
                array(
                    array(
                        'param' => 'page_type',
                        'operator' => '==',
                        'value' => 'front_page',
                    ),
                ),
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'front-page.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
        ));
    }
}

/**
 * AJAX обработчики для модальных форм
 */
add_action('wp_ajax_texk_config_request', 'texk_handle_config_request');
add_action('wp_ajax_nopriv_texk_config_request', 'texk_handle_config_request');
add_action('wp_ajax_texk_demo_request', 'texk_handle_demo_request');
add_action('wp_ajax_nopriv_texk_demo_request', 'texk_handle_demo_request');
add_action('wp_ajax_texk_consultation_request', 'texk_handle_consultation_request');
add_action('wp_ajax_nopriv_texk_consultation_request', 'texk_handle_consultation_request');
add_action('wp_ajax_texk_test_drive_request', 'texk_handle_test_drive_request');
add_action('wp_ajax_nopriv_texk_test_drive_request', 'texk_handle_test_drive_request');

function texk_handle_config_request() {
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $region = sanitize_text_field($_POST['region'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    $product_id = intval($_POST['product_id'] ?? 0);
    
    if (empty($name) || empty($phone) || empty($region)) {
        wp_send_json_error(array('message' => 'Заповніть обов\'язкові поля'));
        return;
    }
    
    // Отправка email администратору
    $to = get_option('admin_email');
    $subject = 'Заявка на розрахунок вартості конфігурації';
    $message = "Нова заявка на розрахунок вартості конфігурації:\n\n";
    $message .= "Ім'я: $name\n";
    $message .= "Телефон: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Регіон: $region\n";
    if ($product_id) {
        $product_title = get_the_title($product_id);
        $message .= "Товар: $product_title (ID: $product_id)\n";
    }
    if ($comment) {
        $message .= "Коментар: $comment\n";
    }
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if ($email) {
        $headers[] = "Reply-To: $name <$email>";
    }
    
    $sent = wp_mail($to, $subject, nl2br($message), $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Заявка успішно відправлена'));
    } else {
        wp_send_json_error(array('message' => 'Помилка відправки. Спробуйте ще раз'));
    }
}

function texk_handle_demo_request() {
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $region = sanitize_text_field($_POST['region'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    $product_id = intval($_POST['product_id'] ?? 0);
    
    if (empty($name) || empty($phone) || empty($region)) {
        wp_send_json_error(array('message' => 'Заповніть обов\'язкові поля'));
        return;
    }
    
    // Отправка email администратору
    $to = get_option('admin_email');
    $subject = 'Заявка на демопоказ';
    $message = "Нова заявка на демопоказ:\n\n";
    $message .= "Ім'я: $name\n";
    $message .= "Телефон: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Регіон: $region\n";
    if ($product_id) {
        $product_title = get_the_title($product_id);
        $message .= "Товар: $product_title (ID: $product_id)\n";
    }
    if ($comment) {
        $message .= "Коментар: $comment\n";
    }
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if ($email) {
        $headers[] = "Reply-To: $name <$email>";
    }
    
    $sent = wp_mail($to, $subject, nl2br($message), $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Заявка успішно відправлена'));
    } else {
        wp_send_json_error(array('message' => 'Помилка відправки. Спробуйте ще раз'));
    }
}

function texk_handle_consultation_request() {
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    $product_id = intval($_POST['product_id'] ?? 0);
    
    if (empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => 'Заповніть обов\'язкові поля'));
        return;
    }
    
    // Отправка email администратору
    $to = get_option('admin_email');
    $subject = 'Заявка на консультацію';
    $message = "Нова заявка на консультацію:\n\n";
    $message .= "Ім'я: $name\n";
    $message .= "Телефон: $phone\n";
    $message .= "Email: $email\n";
    if ($product_id) {
        $product_title = get_the_title($product_id);
        $message .= "Товар: $product_title (ID: $product_id)\n";
    }
    if ($comment) {
        $message .= "Коментар: $comment\n";
    }
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if ($email) {
        $headers[] = "Reply-To: $name <$email>";
    }
    
    $sent = wp_mail($to, $subject, nl2br($message), $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Заявка успішно відправлена'));
    } else {
        wp_send_json_error(array('message' => 'Помилка відправки. Спробуйте ще раз'));
    }
}

function texk_handle_test_drive_request() {
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $comment = sanitize_textarea_field($_POST['comment'] ?? '');
    $product_id = intval($_POST['product_id'] ?? 0);
    
    if (empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => 'Заповніть обов\'язкові поля'));
        return;
    }
    
    // Отправка email администратору
    $to = get_option('admin_email');
    $subject = 'Заявка на тест-драйв';
    $message = "Нова заявка на тест-драйв:\n\n";
    $message .= "Ім'я: $name\n";
    $message .= "Телефон: $phone\n";
    $message .= "Email: $email\n";
    if ($product_id) {
        $product_title = get_the_title($product_id);
        $message .= "Товар: $product_title (ID: $product_id)\n";
    }
    if ($comment) {
        $message .= "Коментар: $comment\n";
    }
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if ($email) {
        $headers[] = "Reply-To: $name <$email>";
    }
    
    $sent = wp_mail($to, $subject, nl2br($message), $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Заявка успішно відправлена'));
    } else {
        wp_send_json_error(array('message' => 'Помилка відправки. Спробуйте ще раз'));
    }
}