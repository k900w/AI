<?php
/**
 * Template Name: Front Page
 * The front page template
 *
 * @package TEX-K
 */

get_header();
?>

<!-- Slider Section -->
<section class="slider-wrap">
    <div class="slider-banner owl-carousel owl-theme">
        <?php
        // Get banner slides from ACF or default
        $banners = get_field('home_banners');
        if ($banners) {
            foreach ($banners as $banner) {
                ?>
                <a class="banner banner-wrap" href="<?php echo esc_url($banner['link']); ?>">
                    <div class="banner__image">
                        <picture>
                            <source class="owl-lazy" type="image/webp" data-srcset="<?php echo esc_url($banner['image_webp']); ?>">
                            <img class="owl-lazy" data-src="<?php echo esc_url($banner['image']); ?>" alt="<?php echo esc_attr($banner['title']); ?>">
                        </picture>
                    </div>
                    <div class="container">
                        <div class="banner__content">
                            <h1 class="banner__content_title title title--banner"><?php echo esc_html($banner['title']); ?></h1>
                            <?php if ($banner['subtitle']) : ?>
                                <span class="title title--uppercase banner__content_small-title"><?php echo esc_html($banner['subtitle']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php
            }
        } else {
            // Default banners
            ?>
            <a class="banner banner-wrap" href="#">
                <div class="banner__image">
                    <img class="owl-lazy" data-src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-1.jpg" alt="ТЕХНІКА KUHN">
                </div>
                <div class="container">
                    <div class="banner__content">
                        <h1 class="banner__content_title title title--banner">ТЕХНІКА KUHN</h1>
                        <span class="title title--uppercase banner__content_small-title">- Перший дилер компанії KUHN</span>
                    </div>
                </div>
            </a>
            <?php
        }
        ?>
    </div>

    <div class="container">
        <div class="banner__content_actions slider-actions">
            <div class="slider-actions_action button-icon button-icon--blue-icon prevSlider">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492">
                    <path d="M198.608 246.104L382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z"/>
                </svg>
            </div>
            <div class="slider-actions_numbers">
                <span id="banner-current-slider" class="slider-actions_numbers_number slider-actions_numbers_number--current">01</span>
                <span id="banner-all-sliders" class="slider-actions_numbers_number">04</span>
            </div>
            <div class="slider-actions_action button-icon button-icon--blue-icon nextSlider">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492.004 492.004">
                    <path d="M382.678 226.804L163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Product Categories Section -->
<section class="section section_grey">
    <div class="container">
        <div class="product-items product-items--grid">
            <?php
            // Получаем выбранные категории из ACF поля
            // Сначала проверяем в настройках темы (options), затем на странице
            $selected_categories = get_field('home_categories_select', 'option');
            if (!$selected_categories) {
                $selected_categories = get_field('home_categories_select');
            }
            
            // Подготавливаем массив категорий для вывода
            $categories_to_display = array();
            
            if ($selected_categories && is_array($selected_categories) && !empty($selected_categories)) {
                // Если категории выбраны - показываем только их
                foreach ($selected_categories as $cat_id) {
                    $term = get_term($cat_id, 'product_category');
                    if (!$term || is_wp_error($term)) continue;
                    $categories_to_display[] = $term;
                }
            } else {
                // Если ничего не выбрано - показываем все корневые категории
                $categories = get_terms(array(
                    'taxonomy' => 'product_category',
                    'hide_empty' => false,
                    'parent' => 0,
                ));
                
                // Сортируем категории по ACF полю category_order
                if (function_exists('texk_sort_product_categories')) {
                    $categories = texk_sort_product_categories($categories, 'order', 'ASC');
                }
                
                if ($categories && !is_wp_error($categories)) {
                    foreach ($categories as $category) {
                        // Проверяем, нужно ли показывать категорию на главной (старое поле для обратной совместимости)
                        $show_on_home = get_field('category_show_on_home', 'product_category_' . $category->term_id);
                        if ($show_on_home === false || $show_on_home === '0' || $show_on_home === 0) {
                            continue;
                        }
                        $categories_to_display[] = $category;
                    }
                }
            }
            
            // Выводим категории
            if (!empty($categories_to_display)) {
                foreach ($categories_to_display as $category) {
                    // Получаем изображения из категории
                    $category_image = get_field('category_image', 'product_category_' . $category->term_id);
                    $category_bg = get_field('category_background', 'product_category_' . $category->term_id);
                    
                    // Название категории
                    $category_title = $category->name;
                    ?>
                    <div class="product-items__item product-items__item--white-bg product-items__item--start product-items__item--fixed-heght product-items__item--md-center product-items__item--with-image">
                        <?php if ($category_bg) : ?>
                            <img class="lazyload image--section-bg" data-src="<?php echo esc_url($category_bg); ?>" alt="">
                        <?php endif; ?>
                        
                        <div class="content-wrap_full-height">
                            <h3 class="product-items__item_title">
                                <a class="text--black" href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php echo esc_html($category_title); ?>
                                </a>
                            </h3>
                            
                            <div class="product-items__lists-wrap hidden">
                                <ul class="product-items__lists-wrap_lists">
                                    <?php
                                    $subcategories = get_terms(array(
                                        'taxonomy' => 'product_category',
                                        'hide_empty' => false,
                                        'parent' => $category->term_id,
                                    ));
                                    
                                    if ($subcategories && !is_wp_error($subcategories)) {
                                        foreach ($subcategories as $subcat) {
                                            ?>
                                            <li class="product-items__lists-wrap_list">
                                                <a class="product-items__lists-wrap_list_link" href="<?php echo esc_url(get_term_link($subcat)); ?>">
                                                    <span class="product-items__lists-wrap_list_icon icon-wrap icon-wrap--white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path d="M256 0C114.615 0 0 114.615 0 256s114.615 256 256 256 256-114.615 256-256S397.385 0 256 0zm0 480C132.288 480 32 379.712 32 256S132.288 32 256 32s224 100.288 224 224-100.288 224-224 224z" />
                                                            <path d="M427.36 244.64l-112-112-22.72 22.72 84.8 84.64H80v32h297.44l-84.64 84.64 22.56 22.56 112-112c6.204-6.241 6.204-16.319 0-22.56z" />
                                                        </svg>
                                                    </span>
                                                    <span class="product-items__lists-wrap_list_text text--white"><?php echo esc_html($subcat->name); ?></span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            
                            <?php if ($category_image) : ?>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <picture class="image-move-js product-items__item_image--image-absolute" style="width: 100%">
                                        <img class="lazyload product-items__item_image--image-absolute" data-src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category_title); ?>">
                                    </picture>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="btn btn--big btn--orange mt-1 btn--box-shadow hidden">Детальніше</a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Advantages Section -->
<section class="section advantages article">
    <div class="container">
        <div class="section__head section__head_fixed">
            <div class="section__aico">AIKo</div>
            <h2 class="section__title">Наші переваги</h2>
            <div class="section__description">
                <div class="section__text">
                    <?php echo get_field('advantages_description') ?: 'Ми допомагаємо фермерам ефективно вирішувати завдання, пропонуючи передове обладнання, багаторічну експертизу і надійну підтримку'; ?>
                </div>
            </div>
        </div>

        <div class="wrap-cols">
            <?php
            $advantages = get_field('advantages');
            if ($advantages) {
                foreach ($advantages as $advantage) {
                    ?>
                    <article class="article__item col col--4 col--md-6 col--sm-12">
                        <div class="article__item_image-wrap article__item_image-wrap--bg_gray">
                            <?php if ($advantage['image']) : ?>
                                <picture>
                                    <img class="lazyload" alt="<?php echo esc_attr($advantage['title']); ?>" data-src="<?php echo esc_url($advantage['image']); ?>">
                                </picture>
                            <?php endif; ?>
                        </div>
                        <div class="article__item_content-wrap">
                            <h3 class="article__item_title"><?php echo esc_html($advantage['title']); ?></h3>
                            <p class="article__item_text word-break word-break--5"><?php echo esc_html($advantage['description']); ?></p>
                        </div>
                    </article>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section section--with-image about-post">
    <?php
    $about_bg = get_field('about_background');
    if ($about_bg) :
        ?>
        <img class="lazyload image--section-bg" data-src="<?php echo esc_url($about_bg); ?>" alt="" data-sizes="auto">
    <?php endif; ?>
    
    <div class="container">
        <div class="wrap-cols">
            <div class="dflex about-post__content section__titles section__titles--bg-white section__titles--column section__titles--left col col--6 col--sm-9">
                <div class="section__head section__head_left">
                    <div class="section__aico">AIKo</div>
                    <h3 class="section__title"><?php echo get_field('about_title') ?: 'Виконання зобов\'язань і чесність - основа нашої роботи з клієнтом'; ?></h3>
                    <p class="text word-break word-break--5"><?php echo get_field('about_text'); ?></p>
                </div>
                <?php
                $about_link = get_field('about_link');
                if ($about_link) :
                    ?>
                    <a href="<?php echo esc_url($about_link); ?>" class="btn btn--big btn--orange btn--box-shadow">Детальнiше</a>
                <?php endif; ?>
            </div>
            <div class="col col--sm-3">
                <h3 class="rotate-text title title--white"><?php echo get_field('about_rotated_text') ?: '20 РОКІВ НАДІЙНОСТІ'; ?></h3>
            </div>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="section section_grey">
    <div class="container">
        <div class="section__head">
            <div class="section__aico">AIKo</div>
            <h2 class="section__title">Агроблог</h2>
        </div>
        
        <?php
        $blog_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 4,
        ));
        
        if ($blog_posts->have_posts()) :
            ?>
            <div class="product-items agroblog">
                <?php
                while ($blog_posts->have_posts()) : $blog_posts->the_post();
                    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $date = get_the_date('j F Y');
                    ?>
                    <div class="agroblog__item product-items__item product-items__item--start product-items__item--with-image">
                        <?php if ($thumb) : ?>
                            <img class="image--section-bg lazyload" data-src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <div class="agroblog__overlay"></div>
                        <div class="product-items__item_wrap product-items__item_wrap--left content-wrap content-wrap--align-left">
                            <?php if ($date) : ?>
                                <span class="date date--gray dflex mb-1"><?php echo esc_html($date); ?></span>
                            <?php endif; ?>

                            <div class="content-wrap_full-height">
                                <h4 class="product-items__item_title">
                                    <a class="text--white" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>

                                <p class="text text--white"><?php // echo wp_kses_post(get_the_excerpt()); ?></p>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="text text--white text--link b">Детальнiше</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Initialize banner slider if Owl Carousel is available
    if (typeof $.fn.owlCarousel !== 'undefined' && $('.slider-banner').length) {
        $('.slider-banner').owlCarousel({
            items: 1,
            dots: false,
            loop: true,
            lazyLoad: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            onTranslated: function(event) {
                var current = event.item.index + 1;
                var total = event.item.count;
                var display = Math.round(current - total / 2 - 0.5);
                if (display === 1) {
                    $('.prevSlider').addClass('button-icon--bg-blue').addClass('button-icon--white-icon');
                    $('.nextSlider').removeClass('button-icon--bg-blue').removeClass('button-icon--white-icon');
                }
                if (display > total) {
                    display -= total;
                }
                $('#banner-current-slider').text(String(display).padStart(2, '0'));
                $('#banner-all-sliders').text(total);
            },
            onInitialized: function(event) {
                var total = event.item.count;
                $('#banner-all-sliders').text(total);
                $('#banner-current-slider').text('01');
            }
        });
        
        $('.nextSlider').click(function() {
            $('.slider-banner').trigger('next.owl.carousel');
            $(this).addClass('button-icon--bg-blue').addClass('button-icon--white-icon');
            $('.prevSlider').removeClass('button-icon--bg-blue').removeClass('button-icon--white-icon');
        });
        
        $('.prevSlider').click(function() {
            $('.slider-banner').trigger('prev.owl.carousel', [300]);
            $(this).addClass('button-icon--bg-blue').addClass('button-icon--white-icon');
            $('.nextSlider').removeClass('button-icon--bg-blue').removeClass('button-icon--white-icon');
        });
    }
});
</script>

<?php
get_footer();




