<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>

    <style>
        @font-face {
            font-family: 'Proxima Nova Rg';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Regular.eot');
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Regular.eot?#iefix') format('embedded-opentype'),
                url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Regular.woff') format('woff'),
                url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Proxima Nova Rg lt';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-RegularIt.eot');
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-RegularIt.eot?#iefix') format('embedded-opentype'),
                url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-RegularIt.woff') format('woff'),
                url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-RegularIt.ttf') format('truetype');
            font-weight: normal;
            font-style: italic;
            font-display: swap;
        }

        @font-face {
            font-family: 'Proxima Nova Th';
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Extrabld.eot');
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Extrabld.eot?#iefix') format('embedded-opentype'),
                url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Extrabld.woff') format('woff'),
                url('<?php echo get_template_directory_uri(); ?>/assets/fonts/ProximaNova-Extrabld.ttf') format('truetype');
            font-weight: 800;
            font-style: normal;
            font-display: swap;
        }

#yith-wacp-mini-cart {
    position: fixed;
    left: 1232.03px !important;
    top: 45.18px !important;
    background-color: none;
    border: 0px solid #ccc;
    border-radius: var(--yith-wacp-mini-cart-borders);
    box-shadow: 2px 2px 8px var(--yith-wacp-mini-cart-shadow);
    z-index: 1000;
    cursor: pointer;
    display: none;
}
    </style>
</head>

<body <?php body_class(); ?>>
    <div class="main-wrap">
        <!-- DESKTOP HEADER -->
        <header class="desktop-header">
            <!-- TOP HEADER -->
            <div class="top-header top-header--bg">
                <div class="container">
                    <div class="top-header__wrap dflex align-center">
                        <!-- Top Navigation -->
                        <nav class="top-header__nav top-header__nav--desktop">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'top',
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'fallback_cb' => function () {
                                    echo '<li><a href="' . esc_url(home_url('/o-kompanii/')) . '">Про компанію</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/novosti-sobytiya/')) . '">Агроблог</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/contact-01/')) . '">Контакти</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/support/')) . '">Підтримка</a></li>';
                                },
                            ));
                            ?>
                        </nav>

                        <div class="top-header__nav_right dflex">
                            <!-- Phone -->
                            <a href="tel:+380506580475" class="top-header__nav_right_item block-with-icon block-with-icon--white-color">
                                <span class="top-header__nav_right_item_icon-wrap block-with-icon_icon-wrap block-with-icon_icon-wrap--red">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.8628 22.6971C7.76458 23.4053 6.45613 23.7139 5.15721 23.5713C3.85828 23.4286 2.64801 22.8433 1.72966 21.9137L0.927376 21.1286C0.57577 20.7689 0.378906 20.2859 0.378906 19.7829C0.378906 19.2799 0.57577 18.7968 0.927376 18.4371L4.33195 15.0669C4.68875 14.7163 5.16892 14.5199 5.66909 14.5199C6.16926 14.5199 6.64944 14.7163 7.00623 15.0669C7.36601 15.419 7.84939 15.6162 8.3528 15.6162C8.85622 15.6162 9.3396 15.419 9.69938 15.0669L15.0479 9.71829C15.2264 9.54237 15.3681 9.33273 15.4648 9.10156C15.5616 8.87039 15.6114 8.6223 15.6114 8.37171C15.6114 8.12113 15.5616 7.87304 15.4648 7.64187C15.3681 7.4107 15.2264 7.20106 15.0479 7.02514C14.6974 6.66835 14.501 6.18817 14.501 5.688C14.501 5.18783 14.6974 4.70765 15.0479 4.35086L18.4388 0.96C18.7985 0.608394 19.2815 0.41153 19.7845 0.41153C20.2875 0.41153 20.7705 0.608394 21.1302 0.96L21.9154 1.76229C22.8448 2.68032 23.4302 3.89016 23.5731 5.18871C23.7161 6.48726 23.408 7.79546 22.7005 8.89371C19.0094 14.3344 14.3126 19.0196 8.8628 22.6971Z" fill="white" />
                                    </svg>
                                </span>
                                <span>+38 050 65 80 475</span>
                            </a>

                            <!-- Language Switch -->
                            <div class="lang-switch_desktop">
                                <div class="top-header__nav_right_item_lng-action dflex align-center">
                                    <div class="lang-switch_desktop__dropdown">
                                        <span class="lang-switch_desktop__item lang-switch_desktop__item_active">UKR</span>
                                        <a href="<?php echo esc_url(home_url('/ru/')); ?>" class="lang-switch_desktop__item">RU</a>
                                    </div>
                                    <span class="top-header__nav_right_item_lng-action_icon top-header__nav_right_item_lng-action_icon--white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M506.157 132.386c-7.803-7.819-20.465-7.831-28.285-.029l-207.73 207.299c-7.799 7.798-20.486 7.797-28.299-.015L34.128 132.357c-7.819-7.803-20.481-7.79-28.285.029-7.802 7.819-7.789 20.482.029 28.284l207.701 207.27c11.701 11.699 27.066 17.547 42.433 17.547 15.358 0 30.719-5.846 42.405-17.533L506.128 160.67c7.818-7.802 7.831-20.465.029-28.284z"></path>
                                        </svg>
                                    </span>
                                    <span class="text--white">UKR</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /TOP HEADER -->

            <!-- MAIN HEADER -->
            <div class="header header--bg">
                <div class="container">
                    <div class="header__wrap dflex align-center">
                        <!-- Logo TEX-K -->
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo" style="width: 10rem; height: 3rem; margin-right: 0px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/TEX_K.png" alt="TEX-K">
                        </a>

                        <!-- Logo KUHN -->
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo1" style="width: 5rem; height: 3rem; margin: 0.5rem 0px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/kuhn_logotype.svg" alt="KUHN">
                        </a>

                        <!-- Main Menu -->
                        <div class="header__menu-wrap dflex jusct-center">
                            <ul class="header__menu dflex">
                                <!-- Техніка with mega menu -->
                                <li class="header__menu_item header__menu_item--submenu">
                                    <a class="header__menu_item_link" href="javascript:void(0)">
                                        Технiка
                                        <span class="header__menu_item_link_icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.333 213.333">
                                                <path d="M0 53.333L106.667 160 213.333 53.333z"></path>
                                            </svg>
                                        </span>
                                    </a>

                                    <?php
                                    // Получаем выбранные категории из настроек меню
                                    $selected_categories = get_field('menu_technika_categories', 'option');
                                    
                                    // Если категории выбраны в настройках, используем их
                                    if (!empty($selected_categories) && is_array($selected_categories)) {
                                        $categories = array();
                                        foreach ($selected_categories as $cat_id) {
                                            $term = get_term($cat_id, 'product_category');
                                            if ($term && !is_wp_error($term) && $term->parent == 0) {
                                                $categories[] = $term;
                                            }
                                        }
                                        // Сортируем по порядку выбора (если нужна сортировка по menu_order)
                                        usort($categories, function($a, $b) {
                                            return strcmp($a->name, $b->name);
                                        });
                                    } else {
                                        // Если ничего не выбрано, показываем все корневые категории
                                        $categories = get_terms(array(
                                            'taxonomy' => 'product_category',
                                            'hide_empty' => false,
                                            'parent' => 0,
                                            'orderby' => 'menu_order',
                                            'order' => 'ASC',
                                        ));
                                    }

                                    if (!empty($categories) && !is_wp_error($categories)) :
                                    ?>
                                        <ul class="catalog-menu">
                                            <?php foreach ($categories as $category) :
                                                // Get subcategories
                                                $subcategories = get_terms(array(
                                                    'taxonomy' => 'product_category',
                                                    'hide_empty' => false,
                                                    'parent' => $category->term_id,
                                                    'orderby' => 'name',
                                                    'order' => 'ASC',
                                                ));
                                            ?>
                                                <li class="catalog-menu__first-level-item">
                                                    <a class="catalog-menu__first-level-title" href="<?php echo esc_url(get_term_link($category)); ?>">
                                                        <?php echo esc_html($category->name); ?>
                                                    </a>

                                                    <?php if (!empty($subcategories) && !is_wp_error($subcategories)) : ?>
                                                        <ul class="catalog-menu__second-level">
                                                            <?php foreach ($subcategories as $subcategory) : ?>
                                                                <li class="catalog-menu__second-level-item">
                                                                    <a class="catalog-menu__second-level-title" href="<?php echo esc_url(get_term_link($subcategory)); ?>">
                                                                        <?php echo esc_html($subcategory->name); ?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>

                                <!-- Запчастини -->
                                <li class="header__menu_item">
                                    <a class="header__menu_item_link" href="https://dev.tex-k.com.ua/catalog/product-category/zapchasti/">Запчастини</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Search -->
                        <div class="header__search">
                            <div id="title-search">
                                <form class="header_search" action="<?php echo esc_url(home_url('/search/')); ?>">
                                    <input placeholder="Введіть назву моделі або артикул запчастини"
                                        class="header_search__input"
                                        id="title-search-input"
                                        type="text"
                                        name="s"
                                        value="<?php echo get_search_query(); ?>"
                                        size="40"
                                        maxlength="50"
                                        autocomplete="off">
                                    <input class="header_search__btn" name="submit" type="image" src="<?php echo get_template_directory_uri(); ?>/assets/images/search_icon_red.png" value="Пошук">
                                </form>
                                <div class="title-search-result" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Favorites -->
                        <a href="<?php echo esc_url(home_url('/favorite/')); ?>" class="block-with-icon block-with-icon--white-color favorite">
                            <span class="favorite__icon">
                                <span class="favorite__count">0</span>
                                <svg width="28" height="28" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.0079 24L3.31334 13.4057C-3.04239 7.04996 6.3 -5.15518 15.0079 4.71917C23.7158 -5.15518 33.0176 7.09055 26.7046 13.4057L15.0079 24Z" stroke="#E30F1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>
<style>
.desktop-header.scrolled #yith-wacp-mini-cart {
    top: 14px !important;
}#yith-wacp-mini-cart {
    position: relative !important;
    left: 0px !important;
    top: 33.18px !important;
    height: 24px !important;
    background-color: #ffffff00 !important;
    border: 0px solid #cccccc00 !important;
    border-radius: var(--yith-wacp-mini-cart-borders);
    box-shadow: 2px 2px 8px #cccccc00 !important;
    z-index: 1000;
    cursor: pointer;
    display: none;
}
</style>    
                        <!-- Cart -->
                        <div id="yith-wacp-mini-cart" class="header_basket__inner bx-basket bx-opener empty" style="left: 1224.03px; top: 78.82px; display: block; zoom: 1;">
                            <a href="https://dev.tex-k.com.ua/#modal-basket" class="header_basket">
                                    <div class="header_basket__count">0</div>
    
                                <svg width="31" height="28" viewBox="0 0 31 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.972 1L24.5434 9M6.2577 9L10.8291 1M27.4691 9H3.33199C2.98918 8.99306 2.64919 9.06333 2.33722 9.20562C2.02525 9.3479 1.74929 9.55856 1.52978 9.82197C1.31027 10.0854 1.15284 10.3948 1.06914 10.7273C0.985443 11.0598 0.977629 11.4069 1.04628 11.7429L3.56056 24.3143C3.66742 24.8383 3.95467 25.3083 4.37232 25.6425C4.78996 25.9766 5.31154 26.1536 5.84628 26.1429H24.9548C25.4896 26.1536 26.0112 25.9766 26.4288 25.6425C26.8464 25.3083 27.1337 24.8383 27.2406 24.3143L29.7548 11.7429C29.8235 11.4069 29.8157 11.0598 29.732 10.7273C29.6483 10.3948 29.4909 10.0854 29.2713 9.82197C29.0518 9.55856 28.7759 9.3479 28.4639 9.20562C28.1519 9.06333 27.8119 8.99306 27.4691 9Z" stroke="#E30F1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /MAIN HEADER -->
        </header>
        <!-- /DESKTOP HEADER -->

        <!-- MOBILE HEADER -->
        <header class="mobile-header">
            <!-- Menu Button -->
            <span class="mobile-header__openMenuAction showMobileMenu--js">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                </svg>
            </span>

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-header__logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/TEX_K.png" alt="TEX-K">
            </a>

            <!-- Search Icon -->
            <div class="mobile-header__search">
                <span class="mobile-header__search-icon openMobileSearch--js">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>

            <!-- Phone -->
            <a href="tel:+380506580475" class="mobile-header__phone">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.8628 22.6971C7.76458 23.4053 6.45613 23.7139 5.15721 23.5713C3.85828 23.4286 2.64801 22.8433 1.72966 21.9137L0.927376 21.1286C0.57577 20.7689 0.378906 20.2859 0.378906 19.7829C0.378906 19.2799 0.57577 18.7968 0.927376 18.4371L4.33195 15.0669C4.68875 14.7163 5.16892 14.5199 5.66909 14.5199C6.16926 14.5199 6.64944 14.7163 7.00623 15.0669C7.36601 15.419 7.84939 15.6162 8.3528 15.6162C8.85622 15.6162 9.3396 15.419 9.69938 15.0669L15.0479 9.71829C15.2264 9.54237 15.3681 9.33273 15.4648 9.10156C15.5616 8.87039 15.6114 8.6223 15.6114 8.37171C15.6114 8.12113 15.5616 7.87304 15.4648 7.64187C15.3681 7.4107 15.2264 7.20106 15.0479 7.02514C14.6974 6.66835 14.501 6.18817 14.501 5.688C14.501 5.18783 14.6974 4.70765 15.0479 4.35086L18.4388 0.96C18.7985 0.608394 19.2815 0.41153 19.7845 0.41153C20.2875 0.41153 20.7705 0.608394 21.1302 0.96L21.9154 1.76229C22.8448 2.68032 23.4302 3.89016 23.5731 5.18871C23.7161 6.48726 23.408 7.79546 22.7005 8.89371C19.0094 14.3344 14.3126 19.0196 8.8628 22.6971Z" fill="white" />
                </svg>
            </a>
        </header>
        <!-- /MOBILE HEADER -->

        <!-- Mobile Menu Sidebar -->
        <div class="mobile-header-show">
            <div class="mobile-header-show__header">
                <a href="<?php echo esc_url(home_url('/ru/')); ?>" class="mobile-header-show__lang">RU</a>
                <img class="mobile-header-show__closed" src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-closed-icon.png" alt="">
            </div>
            <div class="mobile-header-show__body">
                <!-- Mobile Main Menu -->
                <ul class="mobile-menu">
                    <li class="mobile-menu__item mobile-menu__item--has-children">
                        <a href="javascript:void(0)" class="mobile-menu__link">Технiка</a>
                        <ul class="mobile-menu__submenu">
                            <?php
                            // Получаем выбранные категории из настроек меню для мобильной версии
                            $selected_mobile_categories = get_field('menu_technika_categories', 'option');
                            
                            if (!empty($selected_mobile_categories) && is_array($selected_mobile_categories)) {
                                $mobile_categories = array();
                                foreach ($selected_mobile_categories as $cat_id) {
                                    $term = get_term($cat_id, 'product_category');
                                    if ($term && !is_wp_error($term) && $term->parent == 0) {
                                        $mobile_categories[] = $term;
                                    }
                                }
                            } else {
                                $mobile_categories = get_terms(array(
                                    'taxonomy' => 'product_category',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                ));
                            }
                            
                            if (!empty($mobile_categories) && !is_wp_error($mobile_categories)) :
                                foreach ($mobile_categories as $cat) :
                            ?>
                                    <li><a href="<?php echo esc_url(get_term_link($cat)); ?>"><?php echo esc_html($cat->name); ?></a></li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </li>
                    <li class="mobile-menu__item"><a href="<?php echo esc_url(home_url('/parts/')); ?>" class="mobile-menu__link">Запчастини</a></li>
                </ul>

                <!-- Mobile Secondary Menu -->
                <ul class="mobile-menu mobile-menu--secondary">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'top',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'fallback_cb' => function () {
                            echo '<li><a href="' . esc_url(home_url('/o-kompanii/')) . '">Про компанію</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/novosti-sobytiya/')) . '">Агроблог</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/contact-01/')) . '">Контакти</a></li>';
                            echo '<li><a href="' . esc_url(home_url('/support/')) . '">Підтримка</a></li>';
                        },
                    ));
                    ?>
                </ul>
            </div>
        </div>
        <div class="mobile-header-show__shadow"></div>

        <!-- Mobile Search Overlay -->
        <div class="mobile-search-overlay">
            <div class="mobile-search-overlay__inner">
                <form class="mobile-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <input type="text" name="s" placeholder="Пошук..." value="<?php echo get_search_query(); ?>">
                    <button type="submit">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#E30F1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </form>
                <span class="mobile-search-overlay__close">×</span>
            </div>
        </div>

        <main>