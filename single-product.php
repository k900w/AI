<?php
/**
 * Single product template
 * Точная копия структуры оригинальной страницы товара
 *
 * @package TEX-K
 */

get_header();
?>
<style>
.section {
    padding: 127px 0;
}
.cart__slider_item img {
    object-fit: cover;
}
.cart__slider .slick-prev, .slider-actions_action.slick-prev {
    left: 0;
    border-radius: 0;
}
.cart__slider .slick-next, .slider-actions_action.slick-next {
    right: 0;
    border-radius: 0;
}
.slick-prev:before {
    content: '←';
display: none !important;
}
.slick-next:before {
    content: '→';
display: none !important;
}
.cart__slider_item img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
    border-radius: 0 !important;
    max-height: 350px !important;
}
.cart__options-item_text {
    font-size: 14px;
    color: #000;
    font-weight: 900;
}
.cart__slider_item img {

    object-fit: cover !important;
}

.btn--big {
    padding: 0;
    font-size: 13px;
}
.btn--orange {
    background: #e30f1b;
    color: #fff;
 
}
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 !important;
    font-size: 12px !important;
    font-weight: 400;
    text-decoration: none;
    border-radius: 0 !important;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid #e30f1b;
    text-align: center;
}
.link-with__text--underline {
    border-bottom: 0px !important;
    color: #e30f1b;
}

.link-with__icon--bg-blue {
    background: #e30f1b !important;
    padding: 3px !important;
}
.link-with__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px !important;
    height: 20px !important;
    border-radius: 0 !important;
    flex-shrink: 0;
}

.col {
    position: relative;
    padding: 0;
    display: flex;
    justify-content: space-evenly;
}


element.style {
}
.section {
    padding: 10px;
}

.tabs__item.tabs__item_active {
    background: #e30f1b !important;
    color: white;
    border-color: 0px;
    border-bottom-color: #fff;
}
.tabs__item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 25px;
    cursor: pointer;
    border: 2px solid transparent;
    border-bottom: none;
    background: #f5f5f5;
    color: #333;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: -2px;
    border-radius: 0px !important;
}
.tabs__item.tabs__item_active .tabs__item_icon svg {
    fill: white !important;
}
.fancybox-wrap {
    display: none !important;
}

.wrap-cols {
    position: relative;
    display: -webkit-box;
    gap: 28px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin: 0 -1.3rem;
}
.col--6 {
    width: 46%;
}
.text--grey {
    color: #aeaeae;
    margin-top: 20px;
}
.tabs__content {

    background: none !important;
}
p {
    line-height: 24px;
    font-size: 15px;
}

.col {
    position: relative;
    padding: 0;
    display: flex;
    justify-content: space-evenly;
    flex-direction: column;
}
.section_list__item {
    display: flex;
    flex-wrap: wrap;
    max-width: 100%;
    margin: 0 auto;
    gap: 30px;
}
.tabs__item {
    width: 25%;}
.tabs__caption {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
    border-bottom: 2px solid #e5e5e5;
    gap: 0;
    justify-content: space-between;
}
.tabs__item:hover {
    background: white;
    color: black !important;
}
    </style>
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

<section class="section cart">
    <div class="container">
        <?php
        while (have_posts()) : the_post();
            $gallery = get_field('product_gallery');
            $brand = get_field('product_brand');
            $sku = get_field('product_sku');
            $original_price = get_field('product_price');
            $original_currency = get_field('product_currency') ?: 'UAH';
            
            // Конвертируем цену в UAH для товаров категории "Запчасти"
            if (function_exists('texk_convert_price_to_uah')) {
                $price_data = texk_convert_price_to_uah($original_price, $original_currency, get_the_ID());
                $price = $price_data['price'];
                $currency = $price_data['currency'];
            } else {
                $price = $original_price;
                $currency = $original_currency;
            }
            
            $characteristics = get_field('product_characteristics');
            $documents = get_field('product_documents');
            $product_features = get_field('product_features'); // Repeater field для "Особливості моделі"
            ?>
            
            <div class="cart__head">
                <h1 class="cart__title"><?php the_title(); ?></h1>
                <?php
                $subtitle = get_field('product_subtitle');
                if ($subtitle) :
                    ?>
                    <h3 class="cart__subtitle"><?php echo esc_html($subtitle); ?></h3>
                <?php endif; ?>
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
                            $thumb_medium = wp_get_attachment_image_src($thumb_id, 'medium');
                            $thumb_thumbnail = wp_get_attachment_image_src($thumb_id, 'thumbnail');
                            
                            $all_images[] = array(
                                'id' => $thumb_id,
                                'full' => $thumb_full[0],
                                'large' => $thumb_large[0],
                                'medium' => $thumb_medium[0],
                                'thumbnail' => $thumb_thumbnail[0],
                                'alt' => get_post_meta($thumb_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
                            );
                        }
                        
                        // Добавляем изображения из галереи
                        if ($gallery && is_array($gallery)) {
                            foreach ($gallery as $image) {
                                // Пропускаем главное изображение, если оно уже добавлено
                                if (has_post_thumbnail() && isset($image['ID']) && $image['ID'] == get_post_thumbnail_id()) {
                                    continue;
                                }
                                
                                $img_id = is_array($image) && isset($image['ID']) ? $image['ID'] : (is_numeric($image) ? $image : 0);
                                
                                if ($img_id) {
                                    $img_full = wp_get_attachment_image_src($img_id, 'full');
                                    $img_large = wp_get_attachment_image_src($img_id, 'large');
                                    $img_medium = wp_get_attachment_image_src($img_id, 'medium');
                                    $img_thumbnail = wp_get_attachment_image_src($img_id, 'thumbnail');
                                    
                                    $all_images[] = array(
                                        'id' => $img_id,
                                        'full' => $img_full[0],
                                        'large' => $img_large[0],
                                        'medium' => $img_medium[0],
                                        'thumbnail' => $img_thumbnail[0],
                                        'alt' => get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
                                    );
                                } elseif (is_array($image) && isset($image['url'])) {
                                    // Если это массив ACF
                                    $all_images[] = array(
                                        'id' => isset($image['ID']) ? $image['ID'] : 0,
                                        'full' => $image['url'],
                                        'large' => isset($image['sizes']['large']) ? $image['sizes']['large'] : $image['url'],
                                        'medium' => isset($image['sizes']['medium']) ? $image['sizes']['medium'] : $image['url'],
                                        'thumbnail' => isset($image['sizes']['thumbnail']) ? $image['sizes']['thumbnail'] : $image['url'],
                                        'alt' => isset($image['alt']) ? $image['alt'] : get_the_title(),
                                    );
                                }
                            }
                        }
                        
                        if (!empty($all_images)) :
                            ?>
                            <!-- Основной слайдер изображений -->
                            <div id="cart-slider" class="cart__slider">
                                <?php foreach ($all_images as $image) : ?>
                                    <div class="cart__slider_item">
                                        <a href="<?php echo esc_url($image['full']); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($image['alt']); ?>" class="fancybox" title="<?php echo esc_attr($image['alt']); ?>">
                                            <img class="lazyload" data-src="<?php echo esc_url($image['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" src="<?php echo esc_url($image['large']); ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Миниатюры изображений -->
                            <div id="cart-thumbnails" class="cart__thumbnails">
                                <?php foreach ($all_images as $image) : ?>
                                    <div class="cart__thumbnails_item">
                                        <img src="<?php echo esc_url($image['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <!-- Fallback если нет изображений -->
                            <div id="cart-slider" class="cart__slider">
                                <div class="cart__slider_item">
                                    <img class="lazyload" data-src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.png" alt="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                            </div>
                            <div id="cart-thumbnails" class="cart__thumbnails">
                                <div class="cart__thumbnails_item">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder.png" alt="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="cart__left-icons">
                        <a href="javascript:void(0)" class="link-with" onclick="window.print();">
                            <span class="link-with__icon link-with__icon--big link-with__icon--bg-white">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 481.6 481.6" xml:space="preserve">
                                    <g>
                                        <path d="M381.6,309.4c-27.7,0-52.4,13.2-68.2,33.6l-132.3-73.9c3.1-8.9,4.8-18.5,4.8-28.4c0-10-1.7-19.5-4.9-28.5l132.2-73.8c15.7,20.5,40.5,33.8,68.3,33.8c47.4,0,86.1-38.6,86.1-86.1S429,0,381.5,0s-86.1,38.6-86.1,86.1c0,10,1.7,19.6,4.9,28.5l-132.1,73.8c-15.7-20.6-40.5-33.8-68.3-33.8c-47.4,0-86.1,38.6-86.1,86.1s38.7,86.1,86.2,86.1c27.8,0,52.6-13.3,68.4-33.9l132.2,73.9c-3.2,9-5,18.7-5,28.7c0,47.4,38.6,86.1,86.1,86.1s86.1-38.6,86.1-86.1S429.1,309.4,381.6,309.4z M381.6,27.1c32.6,0,59.1,26.5,59.1,59.1s-26.5,59.1-59.1,59.1s-59.1-26.5-59.1-59.1S349.1,27.1,381.6,27.1z M100,299.8c-32.6,0-59.1-26.5-59.1-59.1s26.5-59.1,59.1-59.1s59.1,26.5,59.1,59.1S132.5,299.8,100,299.8z M381.6,454.5c-32.6,0-59.1-26.5-59.1-59.1c0-32.6,26.5-59.1,59.1-59.1s59.1,26.5,59.1,59.1C440.7,428,414.2,454.5,381.6,454.5z"/>
                                    </g>
                                </svg>
                            </span>
                            <span class="link-with__text">Поділитися</span>
                        </a>

                        <a href="javascript:void(0)" class="link-with" onclick="window.print();">
                            <span class="link-with__icon link-with__icon--big link-with__icon--bg-blue">
                                <svg viewBox="-15 0 457 457.14286" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m388.210938 148.9375c-.457032-.367188-1.003907-.644531-1.554688-.914062-.550781-.183594-1.097656-.367188-1.738281-.460938-1.734375-.367188-3.566407-.183594-5.210938.460938-1.1875.453124-2.195312 1.1875-3.019531 2.007812-1.644531 1.648438-2.648438 4.023438-2.648438 6.492188 0 2.378906 1.003907 4.753906 2.648438 6.402343.824219.914063 1.832031 1.550781 3.019531 2.011719 1.097657.457031 2.285157.726562 3.476563.726562.542968 0 1.1875-.089843 1.734375-.183593.640625-.179688 1.1875-.359375 1.738281-.542969.550781-.277344 1.097656-.550781 1.554688-.824219.546874-.367187 1.003906-.734375 1.464843-1.1875 1.640625-1.648437 2.648438-4.023437 2.648438-6.402343 0-2.46875-1.007813-4.753907-2.648438-6.492188-.460937-.457031-.917969-.820312-1.464843-1.09375zm0 0"/>
                                    <path d="m351.820312 152.960938c-.277343-.550782-.546874-1.011719-.820312-1.554688-.367188-.460938-.730469-.914062-1.191406-1.375-2.558594-2.558594-6.582032-3.378906-9.964844-2.007812-1.097656.453124-2.101562 1.1875-2.925781 2.007812-1.734375 1.738281-2.742188 4.023438-2.742188 6.492188 0 1.191406.273438 2.378906.730469 3.476562.460938 1.09375 1.097656 2.101562 2.011719 2.925781.824219.914063 1.828125 1.550781 2.925781 2.011719 1.097656.457031 2.285156.726562 3.566406.726562 2.375 0 4.753906-1.003906 6.398438-2.738281.914062-.824219 1.558594-1.832031 2.011718-2.925781.457032-1.097656.734376-2.285156.734376-3.476562 0-.640626-.09375-1.1875-.183594-1.828126-.183594-.546874-.367188-1.1875-.550782-1.734374zm0 0"/>
                                    <path d="m402.820312 104.210938h-60.980468v-95.066407c0-5.050781-4.09375-9.144531-9.144532-9.144531h-238.042968c-5.050782 0-9.144532 4.09375-9.144532 9.144531v95.066407h-60.980468c-13.488282 0-24.4570315 10.96875-24.4570315 24.453124v197.472657c0 13.488281 10.9687495 24.457031 24.4570315 24.457031h60.980468v97.40625c0 5.050781 4.09375 9.144531 9.144532 9.144531h238.042968c5.050782 0 9.144532-4.09375 9.144532-9.144531v-97.40625h60.980468c13.488282 0 24.457032-10.96875 24.457032-24.457031v-197.472657c0-13.484374-10.96875-24.453124-24.457032-24.453124zm-299.027343-85.925782h219.761719v85.925782h-219.761719zm0 420.570313v-174.945313h219.761719v174.945313zm305.199219-112.71875c0 3.402343-2.769532 6.171875-6.171876 6.171875h-60.980468v-68.398438h28.6875c5.046875 0 9.140625-4.09375 9.140625-9.140625 0-5.050781-4.09375-9.144531-9.140625-9.144531h-313.707032c-5.046874 0-9.140624 4.09375-9.140624 9.144531 0 5.046875 4.09375 9.140625 9.140624 9.140625h28.6875v68.398438h-60.980468c-3.402344 0-6.171875-2.769532-6.171875-6.171875v-197.472657c0-3.402343 2.769531-6.167968 6.171875-6.167968h378.292968c3.402344 0 6.171876 2.765625 6.171876 6.167968zm0 0"/>
                                    <path d="m133.4375 314.277344h110.09375c5.050781 0 9.144531-4.09375 9.144531-9.144532 0-5.046874-4.09375-9.140624-9.144531-9.140624h-110.09375c-5.050781 0-9.144531 4.09375-9.144531 9.140624 0 5.050782 4.09375 9.144532 9.144531 9.144532zm0 0"/>
                                    <path d="m293.910156 342.242188h-160.472656c-5.050781 0-9.144531 4.09375-9.144531 9.140624 0 5.050782 4.09375 9.144532 9.144531 9.144532h160.472656c5.050782 0 9.144532-4.09375 9.144532-9.144532 0-5.046874-4.09375-9.140624-9.144532-9.140624zm0 0"/>
                                    <path d="m293.910156 388.492188h-160.472656c-5.050781 0-9.144531 4.09375-9.144531 9.140624 0 5.050782 4.09375 9.144532 9.144531 9.144532h160.472656c5.050782 0 9.144532-4.09375 9.144532-9.144532 0-5.046874-4.09375-9.140624-9.144532-9.140624zm0 0"/>
                                </svg>
                            </span>
                            <span class="link-with__text">Друкувати</span>
                        </a>
                    </div>
                </div>

                <div class="cart__right cart__right4">
                    <div class="cart__options">
                        <?php
                        $terms = wp_get_post_terms(get_the_ID(), 'product_category');
                        if (!empty($terms) && !is_wp_error($terms)) {
                            $term = $terms[0];
                            ?>
                            <div class="cart__options-item">
                                <span class="cart__options-item_text">Бренд:</span>
                                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="cart__options-item_name"><?php echo esc_html($term->name); ?></a>
                                <a href="<?php echo esc_url(home_url('/parts/filter/' . $term->slug . '/')); ?>" class="cart__options-item_link">Запчастини для <?php echo esc_html($term->name); ?></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <form id="configuration">
                        <div class="cart__configuration">
                            <span class="title title--uppercase title--blue">Конфігурація</span>

                            <div class="cart__configuration_wrap">
                                <!-- Configuration options can be added here via ACF -->
                            </div>

                            <div class="wrap-cols mb-1">
                                <div class="col col--6 col col--md-6 col--sm-6">
                                    <a href="#modal-demo" class="btn btn--white-orange btn--big btn--box-shadow show-modal-demo">Замовити демо показ</a>
                                </div>
                                <div class="col col--6 col col--md-6 col--sm-6">
                                    <a href="#modal-config" class="btn btn--orange btn--big btn--box-shadow show-modal-config">Розрахувати вартість конфігурації</a>
                                </div>
                            </div>

                            <div class="dflex jusct-center mb-1">
                                <span class="text text--grey">Ми надішлемо розрахунок протягом 60 хвилин</span>
                            </div>

                            <div class="wrap-cols">
                                <div class="col col--6 col col--md-6 col--sm-6">
                                    <a href="javascript:void(0)" class="link-with add_to_comparison" data-id="<?php the_ID(); ?>" data-comparison="0">
                                        <span class="link-with__icon link-with__icon--bg-blue">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58.182 58.182">
                                                <path d="M58.168 30.707l-7.993-18.685c.158-.423.249-.879.249-1.356a3.88 3.88 0 00-3.88-3.879 3.866 3.866 0 00-3.145 1.616h-8.946a5.823 5.823 0 00-10.724.002h-8.946a3.878 3.878 0 00-7.025 2.263c0 .477.091.932.249 1.356L.014 30.707H0c0 6.068 5.211 10.99 11.637 10.99 6.428 0 11.636-4.922 11.636-10.99h-.014L15.655 12.93h8.074a5.843 5.843 0 002.129 2.574v28.779H14.222v2.586c0 3.556 2.909 6.465 6.465 6.465h16.808c3.556 0 6.465-2.909 6.465-6.465v-2.586H32.323v-28.78a5.851 5.851 0 002.129-2.573h8.073L34.91 30.707h-.001v.001l-.004.009.005.002c.007 6.063 5.214 10.978 11.636 10.978 6.428 0 11.636-4.922 11.636-10.99a.033.033 0 01-.014 0zm-38.425 0H3.53l6.984-16.328a3.878 3.878 0 002.245-.001l6.984 16.329zm18.682 0l6.995-16.328a3.864 3.864 0 002.248 0l6.985 16.328H38.425z"/>
                                            </svg>
                                        </span>
                                        <span class="link-with__text link-with__text--color-blue link-with__text--underline">Додати в порівняння</span>
                                    </a>
                                </div>
                                <div class="col col--6 col col--md-6 col--sm-6">
                                    <a href="javascript:void(0)" class="link-with add_to_favorite" data-favorite="0" data-id="<?php the_ID(); ?>">
                                        <span class="link-with__icon link-with__icon--bg-blue">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.574 15.362l-1.267 7.767a.75.75 0 001.103.777L12 20.264l6.59 3.643a.75.75 0 001.103-.777l-1.267-7.767 5.36-5.494a.75.75 0 00-.423-1.265l-7.378-1.127L12.678.433c-.247-.526-1.11-.526-1.357 0L8.015 7.476.637 8.603a.75.75 0 00-.423 1.265z"/>
                                            </svg>
                                        </span>
                                        <span class="link-with__text link-with__text--color-blue link-with__text--underline">У обране</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section_grey section_tabs">
    <div class="container">
        <div class="wrap-cols">
            <div class="col col--12">
                <div class="tabs tabs_blog">
                    <div class="tabs tabs_blue">
                        <ul class="tabs__caption">
                            <li class="tabs__item tabs__item_active">
                                <span class="tabs__item_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 426.667 426.667">
                                        <path d="M192 192h42.667v128H192z"/>
                                        <path d="M213.333 0C95.467 0 0 95.467 0 213.333s95.467 213.333 213.333 213.333S426.667 331.2 426.667 213.333 331.2 0 213.333 0zm0 384c-94.08 0-170.667-76.587-170.667-170.667S119.253 42.667 213.333 42.667 384 119.253 384 213.333 307.413 384 213.333 384z"/>
                                        <path d="M192 106.667h42.667v42.667H192z"/>
                                    </svg>
                                </span>
                                <span>Все про продукт</span>
                            </li>
                            <li class="tabs__item">
                                <span class="tabs__item_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M404.476 256c0-8.656 7.018-15.673 15.673-15.673h7.539c-3.241-35.788-17.457-68.453-39.258-94.591l-5.277 5.277c-6.12 6.121-16.045 6.121-22.165 0-6.121-6.121-6.121-16.044 0-22.165l5.277-5.277c-26.138-21.801-58.804-36.017-94.591-39.258v7.539c0 8.656-7.018 15.673-15.673 15.673-8.656 0-15.673-7.018-15.673-15.673v-7.539c-35.788 3.241-68.453 17.457-94.591 39.258l5.277 5.277c6.121 6.121 6.121 16.044 0 22.165-6.12 6.121-16.045 6.121-22.165 0l-5.277-5.277c-21.801 26.138-36.017 58.804-39.258 94.591h7.539c8.656 0 15.673 7.018 15.673 15.673 0 8.656-7.018 15.673-15.673 15.673h-7.539c2.466 27.231 11.286 52.653 24.969 74.769h293.438c13.683-22.116 22.503-47.538 24.969-74.769h-7.539c-8.658 0-15.675-7.017-15.675-15.673zm-64.388-61.923l-41.663 41.663A46.74 46.74 0 01303.02 256c0 25.927-21.093 47.02-47.02 47.02s-47.02-21.093-47.02-47.02 21.093-47.02 47.02-47.02a46.74 46.74 0 0120.26 4.595l41.663-41.663c6.12-6.121 16.044-6.121 22.165 0 6.121 6.121 6.121 16.044 0 22.165zM134.083 377.789c31.224 31.256 74.351 50.619 121.917 50.619s90.693-19.363 121.917-50.619H134.083z"/>
                                        <path d="M256 0C114.508 0 0 114.497 0 256c0 141.493 114.497 256 256 256 141.493 0 256-114.497 256-256C512 114.507 397.503 0 256 0zm0 459.755c-112.343 0-203.755-91.439-203.755-203.755C52.245 143.729 143.57 52.245 256 52.245c112.271 0 203.755 91.325 203.755 203.755 0 112.301-91.396 203.755-203.755 203.755z"/>
                                    </svg>
                                </span>
                                <span>Характеристики</span>
                            </li>
                            <li class="tabs__item">
                                <span class="tabs__item_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M151 376h210v61H151z"/>
                                        <path d="M76 60c-8.291 0-15 6.709-15 15v422c0 8.291 6.709 15 15 15h360c8.291 0 15-6.709 15-15V75c0-8.291-6.709-15-15-15h-90v15c0 24.814-20.186 45-45 45h-90c-24.814 0-45-20.186-45-45V60H76zm60 106c8.284 0 15 6.714 15 15 0 8.284-6.716 15-15 15s-15-6.716-15-15c0-8.286 6.716-15 15-15zm0 60c8.284 0 15 6.714 15 15 0 8.284-6.716 15-15 15s-15-6.716-15-15c0-8.286 6.716-15 15-15zm0 60c8.284 0 15 6.714 15 15 0 8.284-6.716 15-15 15s-15-6.716-15-15c0-8.286 6.716-15 15-15zm60-120h180c8.291 0 15 6.709 15 15s-6.709 15-15 15H196c-8.291 0-15-6.709-15-15s6.709-15 15-15zm0 60h180c8.291 0 15 6.709 15 15s-6.709 15-15 15H196c-8.291 0-15-6.709-15-15s6.709-15 15-15zm0 60h180c8.291 0 15 6.709 15 15s-6.709 15-15 15H196c-8.291 0-15-6.709-15-15s6.709-15 15-15zm180 60c8.291 0 15 6.709 15 15v91c0 8.291-6.709 15-15 15H136c-8.291 0-15-6.709-15-15v-91c0-8.291 6.709-15 15-15h240z"/>
                                        <path d="M301 90c8.284 0 15-6.716 15-15V45c0-8.286-6.716-15-15-15h-15c0-16.569-13.431-30-30-30s-30 13.431-30 30h-15c-8.284 0-15 6.714-15 15v30c0 8.284 6.716 15 15 15h90z"/>
                                    </svg>
                                </span>
                                <span>Інструкції, документи</span>
                            </li>
                            <li class="tabs__item">
                                <span class="tabs__item_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M408.26 194.342H300.586v-48.22c0-8.656-7.018-15.674-15.673-15.674H227.48v-18.709h57.429c8.656 0 15.674-7.018 15.674-15.673s-7.018-15.673-15.674-15.673H66.658c-8.656 0-15.673 7.018-15.673 15.673s7.018 15.673 15.673 15.673h57.433v18.709H66.657c-8.656 0-15.673 7.018-15.673 15.674v70.045H31.347v-24.214c0-8.656-7.018-15.673-15.673-15.673C7.018 176.278 0 183.296 0 191.952v151.822c0 8.656 7.018 15.673 15.673 15.673 8.656 0 15.673-7.018 15.673-15.673v-24.219h19.637v60.121c0 4.157 1.651 8.143 4.591 11.082l36.258 36.258a15.674 15.674 0 0011.082 4.591h269.087c4.158 0 8.144-1.652 11.082-4.591l36.257-36.258a15.674 15.674 0 004.591-11.082V210.015c.003-8.657-7.015-15.673-15.671-15.673zm-89.201 165.627h-34.15c-8.656 0-15.673-7.018-15.673-15.673 0-8.656 7.018-15.673 15.673-15.673h34.15c8.656 0 15.673 7.018 15.673 15.673 0 8.656-7.018 15.673-15.673 15.673zm0-54.336h-34.15c-8.656 0-15.673-7.018-15.673-15.673 0-8.656 7.018-15.673 15.673-15.673h34.15c8.656 0 15.673 7.018 15.673 15.673 0 8.655-7.018 15.673-15.673 15.673zM490.958 195.289l-35.678 13.007v173.101l35.678 13.006C501.13 398.111 512 390.6 512 379.677V210.015c0-10.884-10.838-18.443-21.042-14.726z"/>
                                    </svg>
                                </span>
                                <span>Пакети модернізації</span>
                            </li>
                        </ul>

                        <div class="tabs__content tabs__content_active">
                            <div class="wrap-cols section_list__item">
                                <div class="col col--6 col--sm-12 col--md-12 section_list__item_content mb--md-15">
                                    <?php
                                    $product_description_title = get_field('product_description_title');
                                    if ($product_description_title) {
                                        echo '<h3 class="section__titles">' . esc_html($product_description_title) . '</h3>';
                                    }
                                    ?>
                                    <div class="text">
                                        <?php
                                        $product_description = get_field('product_description');
                                        if ($product_description) {
                                            echo wp_kses_post($product_description);
                                        } else {
                                            the_content();
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $product_description_image = get_field('product_description_image');
                                if ($product_description_image) {
                                    $img_url = is_array($product_description_image) ? $product_description_image['url'] : $product_description_image;
                                    $img_alt = is_array($product_description_image) && isset($product_description_image['alt']) ? $product_description_image['alt'] : get_the_title();
                                    ?>
                                    <div class="col col--6 col--sm-12 section_list__item_image_col">
                                        <div class="section_list__item_image_inner">
                                            <picture>
                                                <source data-srcset="<?php echo esc_url($img_url); ?>" type="image/jpg">
                                                <img class="section_list__item_image lazyload" data-src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                                            </picture>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="tabs__content">
                            <div class="cart_specifications">
                                <?php if ($characteristics) : ?>
                                    <div class="table">
                                        <table>
                                            <?php foreach ($characteristics as $char) : ?>
                                                <tr>
                                                    <td><?php echo esc_html($char['name']); ?></td>
                                                    <td><?php echo esc_html($char['value']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tabs__content">
                            <div class="cart_docs wrap-cols">
                                <?php
                                if ($documents && is_array($documents)) {
                                    foreach ($documents as $doc_row) {
                                        // Handle repeater structure (file, lang, title)
                                        $doc_file = isset($doc_row['file']) ? $doc_row['file'] : $doc_row;
                                        
                                        // Handle both array and direct values
                                        if (is_array($doc_file)) {
                                            $doc_url = isset($doc_file['url']) ? $doc_file['url'] : '';
                                            $doc_filename = isset($doc_file['filename']) ? $doc_file['filename'] : basename($doc_url);
                                            $doc_size = isset($doc_file['filesize']) ? $doc_file['filesize'] : 0;
                                        } else {
                                            $doc_url = $doc_file;
                                            $doc_filename = basename($doc_url);
                                            $doc_size = 0;
                                        }
                                        
                                        if (empty($doc_url)) continue;
                                        
                                        // Get custom title or use filename
                                        $doc_title = !empty($doc_row['title']) ? $doc_row['title'] : $doc_filename;
                                        $doc_lang = !empty($doc_row['lang']) ? $doc_row['lang'] : '';
                                        ?>
                                        <div class="col col--6 col--sm-12 col--md-12">
                                            <div class="cart_docs__item">
                                                <div class="cart_docs__item-icon-inner">
                                                    <a class="fancyboxPdf" href="<?php echo esc_url($doc_url); ?>" target="_blank">
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/cart/docs_pdf.png" alt="" class="cart_docs__item-icon">
                                                    </a>
                                                </div>
                                                <div class="cart_docs__item-content">
                                                    <a class="cart_docs__item-title fancyboxPdf" href="<?php echo esc_url($doc_url); ?>" target="_blank"><?php echo esc_html($doc_title); ?></a>
                                                    <?php if ($doc_lang) : ?>
                                                        <div class="cart_docs__item-lang"><?php echo esc_html($doc_lang); ?></div>
                                                    <?php endif; ?>
                                                    <?php if ($doc_size) : ?>
                                                        <div class="cart_docs__item-size"><?php echo size_format($doc_size, 2); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="tabs__content">
                            <div class="cart_pack wrap-cols">
                                <?php
                                $upgrade_packages = get_field('product_upgrade_packages');
                                if ($upgrade_packages && !empty($upgrade_packages)) {
                                    foreach ($upgrade_packages as $package) {
                                        ?>
                                        <div class="col col--6 col--sm-12 col--md-12">
                                            <div class="cart_pack__item">
                                                <h3 class="cart_pack__item_title"><?php echo esc_html($package['title']); ?></h3>
                                                <?php if ($package['description']) : ?>
                                                    <div class="cart_pack__item_text"><?php echo wp_kses_post($package['description']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Секция "Особливості моделі"
$product_features = get_field('product_features');
if ($product_features) :
    ?>
    <section class="section section_list section_grey">
        <div class="container">
            <div class="section__head">
                <div class="section__aico">AIKo</div>
                <h2 class="section__title">Особливості моделі</h2>
            </div>
        </div>

        <div class="container">
            <?php
            foreach ($product_features as $feature) {
                ?>
                <div class="wrap-cols section_list__item">
                    <div class="col col--6 col--sm-12 section_list__item_image_col">
                                    <?php
                                    $feature_image = is_array($feature['image']) ? $feature['image'] : null;
                                    if ($feature_image && isset($feature_image['url'])) :
                                        ?>
                                        <div class="section_list__item_image_inner">
                                            <picture>
                                                <?php
                                                $feature_image_webp = is_array($feature['image_webp']) ? $feature['image_webp'] : null;
                                                if ($feature_image_webp && isset($feature_image_webp['url'])) :
                                                    ?>
                                                    <source data-srcset="<?php echo esc_url($feature_image_webp['url']); ?>" type="image/webp">
                                                <?php endif; ?>
                                                <source data-srcset="<?php echo esc_url($feature_image['url']); ?>" type="image/jpg">
                                                <img class="section_list__item_image lazyload" data-src="<?php echo esc_url($feature_image['url']); ?>" alt="<?php echo esc_attr($feature['title']); ?>">
                                            </picture>
                                        </div>
                                    <?php endif; ?>
                    </div>
                    <div class="col col--6 col--sm-12 col--md-12 section_list__item_content">
                        <h2 class="section_list__item_title"><?php echo esc_html($feature['title']); ?></h2>
                        <div class="section_list__item_text">
                            <?php echo wp_kses_post($feature['text']); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <?php
endif;
?>
<!--
<section class="section">
    <div class="container">
        <div class="wrap-cols">
            <div class="col col--7 col--md-12">
                <div class="wrap-cols pd-2">
                    <div class="col--5 col--md-12 centered-md-content">
                        <?php
                        $consultant_image = get_field('product_consultant_image');
                        $consultant_name = get_field('product_consultant_name');
                        $consultant_position = get_field('product_consultant_position');
                        if ($consultant_image && is_array($consultant_image) && isset($consultant_image['url'])) :
                            ?>
                            <picture>
                                <img class="section_list__item_image lazyload" data-src="<?php echo esc_url($consultant_image['url']); ?>" alt="<?php echo esc_attr($consultant_name ?: 'Консультант'); ?>">
                            </picture>
                            <?php if ($consultant_name) : ?>
                                <div class="centered-md-content__text text b mb-05"><?php echo esc_html($consultant_name); ?></div>
                            <?php endif; ?>
                            <?php if ($consultant_position) : ?>
                                <span class="text"><?php echo esc_html($consultant_position); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col col--7 col--md-12">
                        <div class="content-wrap dflex centered-md-content">
                            <h3>Потрібна професійна консультація?</h3>
                            <p class="content-wrap_full-height text mb-1">Допоможу вибрати оптимальну конфігурацію обладнання з урахуванням ваших завдань і потреб.</p>
                            <a href="#modal-consultation" class="btn btn--orange btn--small btn--box-shadow show-modal-consultation">Замовити консультацію</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col--5 col--md-12">
                <div class="content-wrap dflex pd-2 box-shadow-standart centered-md-content pdb--md-2 pdt--md-2">
                    <h3>Фінансування техніки</h3>
                    <div class="content-wrap_full-height centered-md-content">
                        <p class="text mb-1">Бракує коштів на покупку? Ми обрали найвигідніші умови з розрахунком платежів і відправкою заявки на сайті.</p>
                        <div class="wrap-cols mb--md-2">
                            <div class="col col--6">
                                <div class="link-with">
                                    <span class="link-with__icon link-with__icon--blue link-with__icon--no-padding link-with__icon--big">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
                                            <path d="M368.411 463.073c-3.015-4.628-9.21-5.937-13.838-2.922-31.986 20.835-69.167 31.848-107.52 31.848-108.773 0-197.267-88.493-197.267-197.266 0-39.499 11.629-77.607 33.632-110.209 3.09-4.578 1.883-10.793-2.695-13.883-4.577-3.09-10.794-1.883-13.884 2.695-24.239 35.918-37.053 77.898-37.053 121.398 0 58.034 22.6 112.594 63.636 153.631s95.597 63.636 153.631 63.636c42.239 0 83.193-12.134 118.437-35.09 4.629-3.014 5.937-9.21 2.921-13.838zM402.006 432.749c-3.944-3.867-10.275-3.804-14.143.139l-.332.337c-3.89 3.92-3.865 10.252.055 14.143a9.97 9.97 0 007.044 2.901 9.97 9.97 0 007.099-2.957l.414-.42c3.868-3.944 3.807-10.275-.137-14.143zM442.512 163.889a9.968 9.968 0 007.071 2.929 9.972 9.972 0 007.071-2.929l16.658-16.658c11.869-11.871 11.869-31.186 0-43.057l-35.7-35.7c-5.751-5.75-13.397-8.917-21.528-8.917-8.133 0-15.778 3.167-21.528 8.917l-16.658 16.657a10.001 10.001 0 000 14.142l4.729 4.729-11.982 11.982a214.756 214.756 0 00-84.588-35.037V64.003h22.001c5.522 0 10-4.477 10-10V10c0-5.523-4.478-10-10-10H186.053c-5.522 0-10 4.477-10 10v44.002c0 5.523 4.478 10 10 10h22.001v16.965a215.962 215.962 0 00-80.46 32.262c-4.611 3.041-5.884 9.243-2.844 13.855 3.042 4.611 9.245 5.884 13.855 2.843 32.202-21.235 69.704-32.459 108.451-32.459 108.773 0 197.267 88.493 197.267 197.267 0 36.887-10.242 72.857-29.619 104.017-2.916 4.69-1.479 10.856 3.212 13.774a9.993 9.993 0 0013.773-3.212c21.351-34.334 32.635-73.955 32.635-114.579 0-44.813-13.487-87.547-38.521-123.59l11.982-11.982 4.727 4.726zM266.055 78.297a221.437 221.437 0 00-19.001-.83 219.032 219.032 0 00-19.001.828V64.003h38.001v14.294zm-48.001-34.295h-22.001V20.001h102.004v24.001h-80.003zm195.479 111.123a221.74 221.74 0 00-12.849-14.023 221.791 221.791 0 00-14.023-12.849l10.107-10.107 26.871 26.871-10.106 10.108zm-9.692-58.192l-.006-.005-4.723-4.723 9.587-9.586a10.374 10.374 0 017.385-3.059c2.789 0 5.412 1.086 7.385 3.06l35.7 35.699c4.072 4.072 4.072 10.699 0 14.772l-9.586 9.585-4.714-4.714-.014-.015-41.014-41.014z"/>
                                            <path d="M247.055 152.992c-5.522 0-10 4.477-10 10v22.001c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10v-22.001c0-5.523-4.478-10-10-10zM347.278 194.508a10.074 10.074 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.21 2.931 7.07a10.072 10.072 0 007.069 2.93c2.631 0 5.21-1.07 7.07-2.93 1.86-1.86 2.93-4.44 2.93-7.07s-1.069-5.21-2.93-7.07zM378.795 284.733h-22.001c-5.522 0-10 4.477-10 10s4.478 10 10 10h22.001c5.522 0 10-4.477 10-10s-4.478-10-10-10zM347.278 380.815a10.074 10.074 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.22 2.931 7.07a10.029 10.029 0 007.069 2.93c2.631 0 5.21-1.06 7.07-2.93 1.86-1.86 2.93-4.43 2.93-7.07 0-2.63-1.069-5.2-2.93-7.07zM247.055 394.473c-5.522 0-10 4.477-10 10v22.001c0 5.523 4.478 10 10 10s10-4.477 10-10v-22.001c0-5.522-4.478-10-10-10zM160.97 380.815a10.077 10.077 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.21 2.931 7.07a10.029 10.029 0 007.069 2.93c2.63 0 5.21-1.06 7.07-2.93 1.86-1.86 2.93-4.43 2.93-7.07a10.067 10.067 0 00-2.93-7.07zM137.314 284.733h-22.001c-5.522 0-10 4.477-10 10s4.478 10 10 10h22.001c5.522 0 10-4.477 10-10 .001-5.523-4.477-10-10-10zM160.97 194.508a10.076 10.076 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93-1.86 1.86-2.931 4.44-2.931 7.07s1.07 5.21 2.931 7.07a10.072 10.072 0 007.069 2.93c2.63 0 5.21-1.07 7.07-2.93 1.86-1.86 2.93-4.44 2.93-7.07s-1.069-5.21-2.93-7.07zM325.133 216.654a10 10 0 00-12.25-1.483l-82.548 49.974c-.893.507-2.143 1.242-2.989 1.908-8.641 6.171-14.292 16.275-14.292 27.679 0 18.75 15.253 34.002 34.001 34.002 11.36 0 21.431-5.606 27.608-14.192.739-.915 1.428-2.116 1.989-3.105l49.964-82.533a10.002 10.002 0 00-1.483-12.25zm-65.711 84.623l-.826 1.364c-2.526 3.675-6.755 6.093-11.542 6.093-7.719 0-14-6.28-14-14 0-4.788 2.419-9.019 6.096-11.545l1.356-.821a13.899 13.899 0 016.547-1.634c7.72 0 14.001 6.28 14.001 14.001 0 2.362-.594 4.588-1.632 6.542zm15.627-25.811a34.259 34.259 0 00-8.727-8.726l22.115-13.388-13.388 22.114z"/>
                                            <path d="M247.055 121.499c-95.523 0-173.237 77.712-173.237 173.235S151.531 467.97 247.055 467.97s173.236-77.713 173.236-173.236-77.713-173.235-173.236-173.235zm0 326.47c-84.494 0-153.236-68.741-153.236-153.235s68.741-153.235 153.236-153.235c84.494 0 153.235 68.741 153.235 153.235s-68.741 153.235-153.235 153.235zM108.178 140.495a10.077 10.077 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.21 2.931 7.07a10.072 10.072 0 007.069 2.93c2.63 0 5.21-1.07 7.07-2.93 1.86-1.86 2.93-4.44 2.93-7.07 0-2.629-1.069-5.209-2.93-7.07z"/>
                                        </svg>
                                    </span>
                                    <span class="link-with__text b">Рішення від 48 годин</span>
                                </div>
                            </div>
                            <div class="col col--6">
                                <div class="link-with">
                                    <span class="link-with__icon link-with__icon--blue link-with__icon--no-padding link-with__icon--big">
                                        <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 49a1 1 0 011 1h2c0-1.654-1.346-3-3-3v-2h-2v2H8v3c0 1.654 1.346 3 3 3h2a1 1 0 011 1v1h-3a1 1 0 01-1-1H8c0 1.654 1.346 3 3 3v2h2v-2h3v-3c0-1.654-1.346-3-3-3h-2a1 1 0 01-1-1v-1zM50 10c0-1.654-1.346-3-3-3s-3 1.346-3 3 1.346 3 3 3 3-1.346 3-3zm-4 0a1 1 0 112 0 1 1 0 01-2 0zM55 13c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm0 4a1 1 0 110-2 1 1 0 010 2zM46.18 18.452l8.005-12 1.664 1.11-8.004 12zM46 37h-4c-1.654 0-3 1.346-3 3v16c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3V40c0-1.654-1.346-3-3-3zm1 19a1 1 0 01-1 1h-4a1 1 0 01-1-1V40a1 1 0 011-1h4a1 1 0 011 1zM34 49h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM34 37h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM34 25h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM22 25h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM39 28v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3h-4c-1.654 0-3 1.346-3 3zm8 0v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1z"/>
                                            <path d="M63 13c0-6.617-5.383-12-12-12H16c-2.757 0-5 2.243-5 5v35.051C5.402 41.558 1 46.272 1 52c0 6.065 4.935 11 11 11h36c2.757 0 5-2.243 5-5V24.819c5.666-.956 10-5.885 10-11.819zM3 52c0-4.963 4.037-9 9-9s9 4.037 9 9-4.037 9-9 9-9-4.037-9-9zm14-9.786V40a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-1.521A11.089 11.089 0 0017 42.214zM51 58c0 1.654-1.346 3-3 3H18.305C21.139 59.008 23 55.72 23 52c0-1.801-.444-3.498-1.214-5H22c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3h-4c-1.654 0-3 1.346-3 3v1.426a11.006 11.006 0 00-2-.376V6c0-1.654 1.346-3 3-3h28.381a12.089 12.089 0 00-2.3 2H17c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h25.081c2.198 2.448 5.377 4 8.919 4zM40.623 7C39.597 8.767 39 10.813 39 13s.597 4.233 1.623 6H17V7zM51 23c-5.514 0-10-4.486-10-10S45.486 3 51 3s10 4.486 10 10-4.486 10-10 10z"/>
                                        </svg>
                                    </span>
                                    <span class="link-with__text b">Ставка від 10%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                            -->

                            <style>

    
/* Главный контейнер, в котором размещены все три колонки */
.consultation-block {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 48px;
  padding: 48px 64px;
  max-width: 1200px;
  margin: 0 auto;
  background-color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  border-radius: 8px;
}

/* Левая колонка с изображением и подписью */
.consultation-left {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  width: 280px;
}

.consultant-image img {
  /* Задаём фиксированные размеры и обрезку для отображения только левой части исходного фото */
  width: 280px;
  height: 280px;
  border-radius: 4px;
  /* cover + left alignment позволяет показать только левую область изображения (фото специалиста) */
  object-fit: cover;
  object-position: left center;
}

.consultant-info {
  margin-top: 12px;
  line-height: 1.2;
}

.consultant-name {
  margin: 0;
  font-weight: 700;
  font-size: 18px;
}

.consultant-title {
  margin: 4px 0 0;
  font-size: 14px;
  color: #555;
}

/* Центральная колонка с текстом и кнопкой */
.consultation-middle {
  max-width: 340px;
}

.consultation-middle h2 {
  margin-top: 0;
  margin-bottom: 24px;
  font-size: 32px;
  font-weight: 700;
  line-height: 1.2;
}

.consultation-middle p {
  margin-top: 0;
  margin-bottom: 32px;
  font-size: 16px;
  line-height: 1.5;
  color: #333;
}

.cta-button {
  display: inline-block;
  background-color: #e10613;
  color: #fff;
  padding: 14px 28px;
  text-decoration: none;
  font-weight: 700;
  font-size: 16px;
  border-radius: 4px;
  transition: background-color 0.2s ease;
}

.cta-button:hover {
  background-color: #b1040f;
}

/* Правая колонка с фоном и информацией о финансировании */
.consultation-right {
  flex: 1;
  /* Чуть более светлый фон, как на макете */
  background-color: #fafafa;
  padding: 32px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.consultation-right h3 {
  margin-top: 0;
  margin-bottom: 24px;
  font-size: 28px;
  font-weight: 700;
}

.consultation-right p {
  margin-top: 0;
  margin-bottom: 32px;
  font-size: 16px;
  line-height: 1.5;
  color: #333;
}

/* Контейнер для характеристик финансирования */
.finance-features {
  display: flex;
  /* Больший интервал между пунктами для визуальной гармонии */
  gap: 72px;
  /* Не переносим элементы на новую строку, чтобы они были в одну линию */
  flex-wrap: nowrap;
}

.feature {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 16px;
  font-weight: 600;
  color: #000;
}

.feature i {
  font-size: 32px;
  color: #e10613;
}
.breadcrumbs {
    position: absolute;
    z-index: 1;
    top: 0 !important;} 
@media (max-width: 768px) {
    .consultation-block {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 48px;
    padding: 48px 64px;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    flex-direction: column;
}
}
   </style>
   <div class="consultation-block">
      <!-- Левая колонка: фото специалиста и подпись -->
      <div class="consultation-left">
        <div class="consultant-image">
          <!-- Изображение взято из загруженного файла -->
          <img
            src="/wp-content/uploads/2025/12/consult.webp"
            alt="Игорь Чабарай"
          />
        </div>
        <div class="consultant-info">
          <p class="consultant-name">Игорь Чабарай</p>
          <p class="consultant-title">Специалист по&nbsp;технике&nbsp;KUHN</p>
        </div>
      </div>

      <!-- Центральная колонка: заголовок, текст и кнопка -->
      <div class="consultation-middle">
        <h2>Нужна профессиональная<br />консультация?</h2>
        <p>
          Помогу выбрать оптимальную конфигурацию оборудования с учётом ваших
          задач и потребностей.
        </p>
        <a href="#modal-consultation" class="cta-button show-modal-consultation">Заказать консультацию</a>
      </div>

      <!-- Правая колонка: финансирование техники -->
      <div class="consultation-right">
        <h3>Финансирование техники</h3>
        <p>
          Нехватает средств на покупку? Мы выбрали самые выгодные условия с
          расчётом платежей и отправкой заявки на сайте.
        </p>
        <div class="finance-features">
          <div class="feature">
          <svg style="fill: #e10613;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
                                                        <path d="M368.411 463.073c-3.015-4.628-9.21-5.937-13.838-2.922-31.986 20.835-69.167 31.848-107.52 31.848-108.773 0-197.267-88.493-197.267-197.266 0-39.499 11.629-77.607 33.632-110.209 3.09-4.578 1.883-10.793-2.695-13.883-4.577-3.09-10.794-1.883-13.884 2.695-24.239 35.918-37.053 77.898-37.053 121.398 0 58.034 22.6 112.594 63.636 153.631s95.597 63.636 153.631 63.636c42.239 0 83.193-12.134 118.437-35.09 4.629-3.014 5.937-9.21 2.921-13.838zM402.006 432.749c-3.944-3.867-10.275-3.804-14.143.139l-.332.337c-3.89 3.92-3.865 10.252.055 14.143a9.97 9.97 0 007.044 2.901 9.97 9.97 0 007.099-2.957l.414-.42c3.868-3.944 3.807-10.275-.137-14.143zM442.512 163.889a9.968 9.968 0 007.071 2.929 9.972 9.972 0 007.071-2.929l16.658-16.658c11.869-11.871 11.869-31.186 0-43.057l-35.7-35.7c-5.751-5.75-13.397-8.917-21.528-8.917-8.133 0-15.778 3.167-21.528 8.917l-16.658 16.657a10.001 10.001 0 000 14.142l4.729 4.729-11.982 11.982a214.756 214.756 0 00-84.588-35.037V64.003h22.001c5.522 0 10-4.477 10-10V10c0-5.523-4.478-10-10-10H186.053c-5.522 0-10 4.477-10 10v44.002c0 5.523 4.478 10 10 10h22.001v16.965a215.962 215.962 0 00-80.46 32.262c-4.611 3.041-5.884 9.243-2.844 13.855 3.042 4.611 9.245 5.884 13.855 2.843 32.202-21.235 69.704-32.459 108.451-32.459 108.773 0 197.267 88.493 197.267 197.267 0 36.887-10.242 72.857-29.619 104.017-2.916 4.69-1.479 10.856 3.212 13.774a9.993 9.993 0 0013.773-3.212c21.351-34.334 32.635-73.955 32.635-114.579 0-44.813-13.487-87.547-38.521-123.59l11.982-11.982 4.727 4.726zM266.055 78.297a221.437 221.437 0 00-19.001-.83 219.032 219.032 0 00-19.001.828V64.003h38.001v14.294zm-48.001-34.295h-22.001V20.001h102.004v24.001h-80.003zm195.479 111.123a221.74 221.74 0 00-12.849-14.023 221.791 221.791 0 00-14.023-12.849l10.107-10.107 26.871 26.871-10.106 10.108zm-9.692-58.192l-.006-.005-4.723-4.723 9.587-9.586a10.374 10.374 0 017.385-3.059c2.789 0 5.412 1.086 7.385 3.06l35.7 35.699c4.072 4.072 4.072 10.699 0 14.772l-9.586 9.585-4.714-4.714-.014-.015-41.014-41.014z"></path>
                                                        <path d="M247.055 152.992c-5.522 0-10 4.477-10 10v22.001c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10v-22.001c0-5.523-4.478-10-10-10zM347.278 194.508a10.074 10.074 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.21 2.931 7.07a10.072 10.072 0 007.069 2.93c2.631 0 5.21-1.07 7.07-2.93 1.86-1.86 2.93-4.44 2.93-7.07s-1.069-5.21-2.93-7.07zM378.795 284.733h-22.001c-5.522 0-10 4.477-10 10s4.478 10 10 10h22.001c5.522 0 10-4.477 10-10s-4.478-10-10-10zM347.278 380.815a10.074 10.074 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.22 2.931 7.07a10.029 10.029 0 007.069 2.93c2.631 0 5.21-1.06 7.07-2.93 1.86-1.86 2.93-4.43 2.93-7.07 0-2.63-1.069-5.2-2.93-7.07zM247.055 394.473c-5.522 0-10 4.477-10 10v22.001c0 5.523 4.478 10 10 10s10-4.477 10-10v-22.001c0-5.522-4.478-10-10-10zM160.97 380.815a10.077 10.077 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.21 2.931 7.07a10.029 10.029 0 007.069 2.93c2.63 0 5.21-1.06 7.07-2.93 1.86-1.86 2.93-4.43 2.93-7.07a10.067 10.067 0 00-2.93-7.07zM137.314 284.733h-22.001c-5.522 0-10 4.477-10 10s4.478 10 10 10h22.001c5.522 0 10-4.477 10-10 .001-5.523-4.477-10-10-10zM160.97 194.508a10.076 10.076 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93-1.86 1.86-2.931 4.44-2.931 7.07s1.07 5.21 2.931 7.07a10.072 10.072 0 007.069 2.93c2.63 0 5.21-1.07 7.07-2.93 1.86-1.86 2.93-4.44 2.93-7.07s-1.069-5.21-2.93-7.07zM325.133 216.654a10 10 0 00-12.25-1.483l-82.548 49.974c-.893.507-2.143 1.242-2.989 1.908-8.641 6.171-14.292 16.275-14.292 27.679 0 18.75 15.253 34.002 34.001 34.002 11.36 0 21.431-5.606 27.608-14.192.739-.915 1.428-2.116 1.989-3.105l49.964-82.533a10.002 10.002 0 00-1.483-12.25zm-65.711 84.623l-.826 1.364c-2.526 3.675-6.755 6.093-11.542 6.093-7.719 0-14-6.28-14-14 0-4.788 2.419-9.019 6.096-11.545l1.356-.821a13.899 13.899 0 016.547-1.634c7.72 0 14.001 6.28 14.001 14.001 0 2.362-.594 4.588-1.632 6.542zm15.627-25.811a34.259 34.259 0 00-8.727-8.726l22.115-13.388-13.388 22.114z"></path>
                                                        <path d="M247.055 121.499c-95.523 0-173.237 77.712-173.237 173.235S151.531 467.97 247.055 467.97s173.236-77.713 173.236-173.236-77.713-173.235-173.236-173.235zm0 326.47c-84.494 0-153.236-68.741-153.236-153.235s68.741-153.235 153.236-153.235c84.494 0 153.235 68.741 153.235 153.235s-68.741 153.235-153.235 153.235zM108.178 140.495a10.077 10.077 0 00-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.077 10.077 0 00-2.931 7.07c0 2.64 1.07 5.21 2.931 7.07a10.072 10.072 0 007.069 2.93c2.63 0 5.21-1.07 7.07-2.93 1.86-1.86 2.93-4.44 2.93-7.07 0-2.629-1.069-5.209-2.93-7.07z"></path>
                                                    </svg>
            <span>Решение от&nbsp;48&nbsp;часов</span>
          </div>
          <div class="feature">
          <svg   style="fill: #e10613;" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13 49a1 1 0 011 1h2c0-1.654-1.346-3-3-3v-2h-2v2H8v3c0 1.654 1.346 3 3 3h2a1 1 0 011 1v1h-3a1 1 0 01-1-1H8c0 1.654 1.346 3 3 3v2h2v-2h3v-3c0-1.654-1.346-3-3-3h-2a1 1 0 01-1-1v-1zM50 10c0-1.654-1.346-3-3-3s-3 1.346-3 3 1.346 3 3 3 3-1.346 3-3zm-4 0a1 1 0 112 0 1 1 0 01-2 0zM55 13c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm0 4a1 1 0 110-2 1 1 0 010 2zM46.18 18.452l8.005-12 1.664 1.11-8.004 12zM46 37h-4c-1.654 0-3 1.346-3 3v16c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3V40c0-1.654-1.346-3-3-3zm1 19a1 1 0 01-1 1h-4a1 1 0 01-1-1V40a1 1 0 011-1h4a1 1 0 011 1zM34 49h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM34 37h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM34 25h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM22 25h-4c-1.654 0-3 1.346-3 3v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3zm1 7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1zM39 28v4c0 1.654 1.346 3 3 3h4c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3h-4c-1.654 0-3 1.346-3 3zm8 0v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4a1 1 0 011-1h4a1 1 0 011 1z"></path>
                                                        <path d="M63 13c0-6.617-5.383-12-12-12H16c-2.757 0-5 2.243-5 5v35.051C5.402 41.558 1 46.272 1 52c0 6.065 4.935 11 11 11h36c2.757 0 5-2.243 5-5V24.819c5.666-.956 10-5.885 10-11.819zM3 52c0-4.963 4.037-9 9-9s9 4.037 9 9-4.037 9-9 9-9-4.037-9-9zm14-9.786V40a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-1.521A11.089 11.089 0 0017 42.214zM51 58c0 1.654-1.346 3-3 3H18.305C21.139 59.008 23 55.72 23 52c0-1.801-.444-3.498-1.214-5H22c1.654 0 3-1.346 3-3v-4c0-1.654-1.346-3-3-3h-4c-1.654 0-3 1.346-3 3v1.426a11.006 11.006 0 00-2-.376V6c0-1.654 1.346-3 3-3h28.381a12.089 12.089 0 00-2.3 2H17c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h25.081c2.198 2.448 5.377 4 8.919 4zM40.623 7C39.597 8.767 39 10.813 39 13s.597 4.233 1.623 6H17V7zM51 23c-5.514 0-10-4.486-10-10S45.486 3 51 3s10 4.486 10 10-4.486 10-10 10z"></path>
                                                    </svg>
            <span>Ставка от&nbsp;10%</span>
          </div>
        </div>
      </div>
    </div>

<section class="section" style="background-image: url(<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/cart/bg1.jpg);background-position: center center;">
    <div class="container">
        <div class="wrap-cols">
            <div class="col col--5 col--md-8 col--sm-12">
                <div class="section__head section__head_left">
                    <div class="section__aico">AIKo</div>
                    <h2 class="section__title section__title--white text--white">Влаштуйте тест-драйв на вашому полі</h2>
                    <div class="section__description">
                        <div class="section__text text--white mb-1">
                            Перевірте техніку в справі перед покупкою. Привеземо, продемонструємо, відповімо на будь-які питання. Ніяких зобов'язань з вашого боку.
                        </div>
                    </div>
                    <a href="#modal-test_drive" class="btn btn--orange btn--small btn--box-shadow show-modal-test_drive">Замовити тест-драйв</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section_grey">
    <div class="container">
        <div class="section__head">
            <div class="section__aico">AIKo</div>
            <h2 class="section__title">ВАС МОЖУТЬ ТАКОЖ ЗАЦІКАВИТИ</h2>
        </div>

        <div class="wrap-cols">
            <?php
            // Related products
            $related = get_posts(array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_category',
                        'field' => 'term_id',
                        'terms' => wp_get_post_terms(get_the_ID(), 'product_category', array('fields' => 'ids')),
                    ),
                ),
            ));

            if ($related) :
                foreach ($related as $related_post) :
                    setup_postdata($related_post);
                    $related_thumb = get_the_post_thumbnail_url($related_post->ID, 'medium');
                    ?>
                    <div class="col col--3 col--md-6 col--sm-12">
                        <div class="card">
                            <div class="card__inner">
                                <div class="card__header">
                                    <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>" class="card__header_image">
                                        <?php if ($related_thumb) : ?>
                                            <picture>
                                                <img class="lazyload" data-srcset="<?php echo esc_url($related_thumb); ?>" alt="<?php echo esc_attr(get_the_title($related_post->ID)); ?>">
                                            </picture>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="card__body">
                                    <h3 class="card__title">
                                        <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>"><?php echo esc_html(get_the_title($related_post->ID)); ?></a>
                                    </h3>
                                    <?php
                                    $related_subtitle = get_field('product_subtitle', $related_post->ID);
                                    if ($related_subtitle) :
                                        ?>
                                        <p class="card__descr"><?php echo esc_html($related_subtitle); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="card__footer">
                                    <a href="<?php echo esc_url(get_permalink($related_post->ID)); ?>" class="btn btn--orange btn--mgt btn--small btn--box-shadow">Детальніше</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Initialize product gallery slider with Slick
    if (typeof $.fn.slick !== 'undefined' && $('#cart-slider').length && $('#cart-thumbnails').length) {
        var $mainSlider = $('#cart-slider');
        var $thumbSlider = $('#cart-thumbnails');
        
        // Основной слайдер с красными стрелками
        $mainSlider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: '#cart-thumbnails',
            prevArrow: '<div class="slider-actions_action button-icon button-icon--blue-icon slick-prev slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492"><path d="M198.608 246.104L382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z"></path></svg></div>',
            nextArrow: '<div class="slider-actions_action button-icon button-icon--blue-icon slick-next slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492.004 492.004"><path d="M382.678 226.804L163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z"></path></svg></div>',
            lazyLoad: 'ondemand',
            infinite: true,
            speed: 300,
        });
        
        // Слайдер миниатюр с черными стрелками
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
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                }
            ]
        });
        
        // Синхронизация при клике на миниатюру
        $thumbSlider.on('click', '.cart__thumbnails_item', function() {
            var index = $(this).index();
            $mainSlider.slick('slickGoTo', index);
        });
    }
    
    // Initialize tabs - точно как в оригинале Bitrix
    var $tabsContainer = $('.tabs.tabs_blue');
    if ($tabsContainer.length) {
        var $tabsItems = $tabsContainer.find('.tabs__item');
        var $tabsContent = $tabsContainer.find('.tabs__content');
        
        // Обработчик клика на таб
        $tabsItems.on('click', function(e) {
            e.preventDefault();
            
            var $clickedTab = $(this);
            var tabIndex = $tabsItems.index($clickedTab);
            
            // Убираем активный класс со всех табов
            $tabsItems.removeClass('tabs__item_active');
            
            // Добавляем активный класс к кликнутому табу
            $clickedTab.addClass('tabs__item_active');
            
            // Скрываем весь контент
            $tabsContent.removeClass('tabs__content_active');
            
            // Показываем соответствующий контент по индексу
            if ($tabsContent.length > tabIndex) {
                $tabsContent.eq(tabIndex).addClass('tabs__content_active');
            }
        });
        
        // Инициализация: показываем первый таб, если он активен
        var $activeTab = $tabsItems.filter('.tabs__item_active');
        if ($activeTab.length === 0) {
            // Если нет активного таба, активируем первый
            $tabsItems.first().addClass('tabs__item_active');
            $tabsContent.first().addClass('tabs__content_active');
        } else {
            // Показываем контент активного таба
            var activeIndex = $tabsItems.index($activeTab);
            if ($tabsContent.length > activeIndex) {
                $tabsContent.eq(activeIndex).addClass('tabs__content_active');
            }
        }
    }
    
    // Initialize Fancybox for gallery
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="gallery"]', {
            // Options
        });
        
        // Bind fancybox class links
        Fancybox.bind('.fancybox', {
            groupAll: true,
        });
    }
});
</script>

<?php
        endwhile;
get_footer();
