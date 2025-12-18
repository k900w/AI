<?php

/**
 * Template Name: Product - Parts (Запчастини)
 * Single product template for spare parts (parts category)
 * Простая карточка товара для запчастей
 *
 * @package TEX-K
 */

get_header();
?>

<div class="container">
    <div class="wrap-cols">
        <div class="col col--12">
            <?php
            // Breadcrumbs
            if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<nav class="breadcrumbs breadcrumbs1">', '</nav>');
            } else {
            ?>
                <nav class="breadcrumbs breadcrumbs1">
                    <li>
                        <a class="breadcrumbs__item" href="<?php echo esc_url(home_url('/')); ?>" title="Головна">Головна</a>
                    </li>
                    <li>
                        <a class="breadcrumbs__item" href="<?php echo esc_url(home_url('/parts/')); ?>" title="Запчастини">Запчастини</a>
                    </li>
                    <?php
                    $terms = wp_get_post_terms(get_the_ID(), 'product_category');
                    if (!empty($terms) && !is_wp_error($terms)) {
                        $term = $terms[0];
                    ?>
                        <li>
                            <a class="breadcrumbs__item" href="<?php echo esc_url(get_term_link($term)); ?>" title="<?php echo esc_attr($term->name); ?>">
                                <?php echo esc_html($term->name); ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <span class="breadcrumbs__item"><?php the_title(); ?></span>
                    </li>
                </nav>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<style>
    .cart__slider .slick-prev, .slider-actions_action.slick-prev {
    left: 0 !important;
    border-radius: 0px !important;
}
    .cart__slider .slick-next, .slider-actions_action.slick-next {
    right: 0 !important;
    border-radius: 0px !important;
}
    .slick-prev:before, .slick-next:before {
        display: none !important;
    }
    .cart__options-item_name {
    text-transform: uppercase !important;
    color: #e30f1b !important;
    text-decoration: underline !important;
}
    main {

    margin-top: 86px !important
}
    .cart__options-item_price {
        font-family: "Proxima Nova Th", sans-serif !important;
    font-size: 3.25rem;
    color: #e30f1b;
    margin-bottom: 2.1rem;

    }
    .cart__options-item_text-stock {

        width: 12rem;
    color: #58c30a;
    margin-bottom: 2.1rem;
    }
    .cart__options-item_text {
    font-size: 14px;
    font-family: "Proxima Nova Th", sans-serif !important;
    color: black;
}
    </style>
    
<section class="section cart cart-parts">
    <div class="container">
        <?php
        while (have_posts()) : the_post();
            $gallery = get_field('product_gallery');
            $sku_field = get_field('product_sku');
            
            // Извлекаем каталожный номер из названия товара (текст в скобках)
            $title = get_the_title();
            $sku = $sku_field;
            
            // Если поле SKU пустое или содержит GUID-подобную строку, пытаемся извлечь из названия
            $is_guid = !empty($sku_field) && (strlen($sku_field) > 20 && preg_match('/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i', $sku_field));
            
            if (empty($sku_field) || $is_guid) {
                // Ищем текст в скобках в названии (приоритет)
                if (preg_match('/\(([^)]+)\)/', $title, $matches)) {
                    $sku = trim($matches[1]);
                } else {
                    // Если скобок нет, проверяем, есть ли каталожный номер в конце названия
                    // Формат: "текст FLA0994D" - берем последнее слово, если оно похоже на каталожный номер
                    $title_parts = explode(' ', trim($title));
                    $last_part = end($title_parts);
                    // Проверяем, что последняя часть похожа на каталожный номер (содержит буквы и цифры, не GUID)
                    if (preg_match('/^[A-Z0-9]+$/i', $last_part) && strlen($last_part) > 3 && strlen($last_part) < 20) {
                        $sku = $last_part;
                    }
                }
            }
            
            $original_price = get_field('product_price');
            $original_currency = get_field('product_currency') ?: 'UAH';
            
            // Конвертируем цену в UAH для товаров категории "Запчасти"
            // Этот шаблон используется только для запчастей, поэтому принудительно конвертируем
            if (function_exists('texk_convert_price_to_uah') && $original_price) {
                $price_data = texk_convert_price_to_uah($original_price, $original_currency, get_the_ID(), true);
                $price = $price_data['price'];
                $currency = $price_data['currency'];
            } else {
                $price = $original_price;
                $currency = $original_currency ?: 'UAH';
            }
            
            $brand = get_field('product_brand');
            if (!$brand) {
                $terms = wp_get_post_terms(get_the_ID(), 'product_category');
                if (!empty($terms) && !is_wp_error($terms)) {
                    $brand = $terms[0]->name;
                }
            }
            $in_cart = function_exists('texk_is_in_cart') ? texk_is_in_cart(get_the_ID()) : false;
        ?>

            <div class="cart__head">
                <h1 class="cart__title"><?php the_title(); ?></h1>
            </div>

            <div class="cart__wrap">
                <div class="cart__left">
                    <div class="cart__slider-wrap">
                        <?php
                        // Собираем все изображения товара
                        $all_images = array();

                        // Добавляем главное изображение первым
                        if (has_post_thumbnail()) {
                            $thumb_id = get_post_thumbnail_id();
                            $thumb_full = wp_get_attachment_image_src($thumb_id, 'full');
                            $thumb_large = wp_get_attachment_image_src($thumb_id, 'large');
                            $thumb_thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail');

                            $all_images[] = array(
                                'full' => $thumb_full[0],
                                'large' => $thumb_large[0],
                                'thumbnail' => $thumb_thumbnail[0],
                                'alt' => get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
                            );
                        }

                        // Добавляем изображения из галереи
                        if ($gallery && is_array($gallery)) {
                            foreach ($gallery as $image) {
                                if (has_post_thumbnail() && isset($image['ID']) && $image['ID'] == get_post_thumbnail_id()) {
                                    continue;
                                }

                                $img_id = is_array($image) && isset($image['ID']) ? $image['ID'] : (is_numeric($image) ? $image : 0);

                                if ($img_id) {
                                    $img_full = wp_get_attachment_image_src($img_id, 'full');
                                    $img_large = wp_get_attachment_image_src($img_id, 'large');
                                    $img_thumbnail = wp_get_attachment_image_src($img_id, 'thumbnail');

                                    $all_images[] = array(
                                        'full' => $img_full[0],
                                        'large' => $img_large[0],
                                        'thumbnail' => $img_thumbnail[0],
                                        'alt' => get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
                                    );
                                } elseif (is_array($image) && isset($image['url'])) {
                                    $all_images[] = array(
                                        'full' => $image['url'],
                                        'large' => isset($image['sizes']['large']) ? $image['sizes']['large'] : $image['url'],
                                        'thumbnail' => isset($image['sizes']['thumbnail']) ? $image['sizes']['thumbnail'] : $image['url'],
                                        'alt' => isset($image['alt']) ? $image['alt'] : get_the_title(),
                                    );
                                }
                            }
                        }

                        if (!empty($all_images)) :
                        ?>
                            <div id="cart-slider" class="cart__slider">
                                <?php foreach ($all_images as $image) : ?>
                                    <div class="cart__slider_item">
                                        <a href="<?php echo esc_url($image['full']); ?>" data-fancybox="gallery" class="fancybox" title="<?php echo esc_attr($image['alt']); ?>">
                                            <img class="lazyload" data-src="<?php echo esc_url($image['large']); ?>" src="<?php echo esc_url($image['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php if (count($all_images) > 1) : ?>
                                <div id="cart-thumbnails" class="cart__thumbnails">
                                    <?php foreach ($all_images as $image) : ?>
                                        <div class="cart__thumbnails_item">
                                            <img class="lazyload" data-src="<?php echo esc_url($image['thumbnail']); ?>" src="<?php echo esc_url($image['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div id="cart-slider" class="cart__slider">
                                <div class="cart__slider_item">
                                    <img class="lazyload" data-src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.png" alt="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="cart__right cart__right3">
                    <div class="cart__options">
                        <?php if ($sku) : ?>
                            <div class="cart__options-item">
                                <span class="cart__options-item_text">Каталоговий номер:</span> <?php echo esc_html($sku); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $wc_product = wc_get_product(get_the_ID());
                        $terms = wp_get_post_terms(get_the_ID(), 'product_category');
                        $brand_term = (!empty($terms) && !is_wp_error($terms)) ? $terms[0] : null;
                        if ($brand_term) : ?>
                            <div class="cart__options-item">
                                <span class="cart__options-item_text">Бренд:</span>
                                <span class="cart__options-item_name"><?php echo esc_html($brand_term->name); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="cart__options-item">
                            <span class="cart__options-item_text-stock">В наявності</span>
                        </div>

                        <?php
                        if (function_exists('wp_enqueue_script')) {
                            wp_enqueue_script('wc-add-to-cart');
                        }
                        $add_url = $wc_product ? esc_url($wc_product->add_to_cart_url()) : '#';
                        $in_cart_wc = (function_exists('WC') && WC()->cart) ? WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id(get_the_ID())) : false;
                        $add_disabled = (!$wc_product || !$wc_product->is_purchasable());
                        ?>
                       

                        <?php if ($price) : ?>
                            <div class="cart__options-item" style="margin-bottom: 0;">
                                <span class="cart__options-item_price"><?php echo number_format((float)$price, 2, '.', ''); ?> <span><?php echo esc_html($currency === 'UAH' ? 'грн' : $currency); ?></span></span>
                            </div>
                            <div class="cart__options-item" style="display: block; font-size: 0.76rem;">
                                <span class="cart__options-item_text" style="color: red">Ціни можуть змінюватися. Будь ласка, уточняйте актуальність цін у менеджерів!</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php
                    // Менеджер
                    $manager_image = get_field('product_manager_image');
                    $manager_name = get_field('product_manager_name');
                    $manager_phone = get_field('product_manager_phone');

                    if ($manager_name) :
                    ?>
                        <div class="cart__manager">
                            <?php if ($manager_image) : ?>
                                <div class="cart__manager_image-inner">
                                    <img class="cart__manager_image lazyload" data-src="<?php echo esc_url(is_array($manager_image) ? $manager_image['url'] : $manager_image); ?>" alt="Менеджер AIKo">
                                </div>
                            <?php endif; ?>
                            <div class="cart__manager_image-info">
                                <div class="cart__manager_image-text">
                                    Менеджер з продажу запчастин<br><br>
                                    <?php echo esc_html($manager_name); ?>
                                    <?php if ($manager_phone) : ?>
                                        <br><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $manager_phone)); ?>"><?php echo esc_html($manager_phone); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form id="configuration">
                        <div class="cart__configuration">
                            <div class="wrap-cols">
                                <div class="col col--6 col col--md-12 col--sm-6">
                                    <a href="<?php echo $add_url; ?>"
                                       data-quantity="1"
                                       data-product_id="<?php the_ID(); ?>"
                                       class="btn btn--orange btn--big btn--box-shadow add_to_cart_button ajax_add_to_cart <?php echo $add_disabled ? 'disabled' : ''; ?>">
                                        <?php echo $in_cart_wc ? 'У кошику' : 'Замовити'; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
<?php endwhile; ?>
</div>
</section>

<!-- Модальные окна -->
<div style="display:none">
    <div class="modal" id="modal-basket">
        <div class="modal__header">
            Оформити замовлення
        </div>
        <div class="modal__body">
            <div class="container">
                <div class="wrap-cols">
                    <div class="col col--12">
                        <form action="" class="form" id="basket-form">
                            <div class="wrap-cols">
                                <div class="col col--12">
                                    <div class="form-group form-group_text">
                                        <input class="form-control" type="text" name="name" id="name" autocomplete="off" placeholder=" " required>
                                        <label for="name" class="form-label">Введіть ваше ім'я <span>*</span></label>
                                    </div>
                                </div>
                                <div class="col col--12">
                                    <div class="form-group form-group_text">
                                        <input class="form-control" type="tel" name="phone" id="phone" autocomplete="off" placeholder=" " required>
                                        <label for="phone" class="form-label">Введіть Ваш телефон <span>*</span></label>
                                    </div>
                                </div>
                                <div class="col col--12">
                                    <div class="form-group form-group_text">
                                        <input class="form-control" type="email" name="email" id="email" autocomplete="off" placeholder=" ">
                                        <label for="email" class="form-label">Введіть Ваш e-mail</label>
                                    </div>
                                </div>
                                <div class="col col--12">
                                    <div class="form-group">
                                        <label for="text" class="form-label">Додати коментар</label>
                                        <textarea class="form-control" id="comment" name="comment"></textarea>
                                    </div>
                                </div>
                                <div class="col col--12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn--orange btn--big btn--box-shadow" value="Оформити замовлення">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        // Initialize product gallery slider with Slick
        if (typeof $.fn.slick !== 'undefined' && $('#cart-slider').length && $('#cart-thumbnails').length) {
            var $mainSlider = $('#cart-slider');
            var $thumbSlider = $('#cart-thumbnails');

            $mainSlider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: true,
                asNavFor: '#cart-thumbnails',
                prevArrow: '<div class="slider-actions_action button-icon button-icon--blue-icon slick-prev slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492"><path d="M198.608 246.104L382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z"></path></svg></div>',
                nextArrow: '<div class="slider-actions_action button-icon button-icon--blue-icon slick-next slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492.004 492.004"><path d="M382.678 226.804L163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z"></path></svg></div>',
                infinite: true,
                speed: 300,
            });

            $thumbSlider.slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '#cart-slider',
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                arrows: true,
                prevArrow: '<svg class="cart__thumbnails_prev slick-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492"><path d="M198.608 246.104L382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z"></path></svg>',
                nextArrow: '<svg class="cart__thumbnails_next slick-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492.004 492.004"><path d="M382.678 226.804L163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z"></path></svg>',
                infinite: true,
                speed: 300,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        }
                    }
                ]
            });
        }

        // Initialize Fancybox for gallery
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind('[data-fancybox="gallery"]', {});
            Fancybox.bind('.fancybox', {
                groupAll: true
            });
        }
    });
</script>

<?php
get_footer();
