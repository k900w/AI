<?php
/**
 * WooCommerce Archive Template for Products
 *
 * @package TEX-K
 */

get_header();
?>

<div class="container">
    <!-- Хлебные крошки -->
    <nav class="breadcrumbs-category">
        <a href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
        <span>›</span>
        <span class="current">Каталог техніки</span>
    </nav>
</div>

<section class="section">
    <div class="container">
        <!-- Заголовок -->
        <div class="category-header">
            <h1 class="category-header__title">Каталог техніки</h1>
            <div class="category-header__description">
                Повний каталог сільськогосподарської техніки від провідних світових виробників.
            </div>
        </div>

        <?php
        // WooCommerce hooks
        do_action('woocommerce_before_main_content');
        ?>

        <?php
        // Получаем корневые категории из кастомной таксономии product_category
        $root_categories = get_terms(array(
            'taxonomy' => 'product_category',
            'parent' => 0,
            'hide_empty' => false,
        ));

        if ($root_categories && !is_wp_error($root_categories) && count($root_categories) > 0) :
            ?>
            <h2 class="section__subtitle" style="margin-bottom: 20px;">Категорії техніки</h2>
            <div class="subcategories-grid">
                <?php foreach ($root_categories as $category) :
                    $category_image = get_field('category_image', 'product_category_' . $category->term_id);
                    $category_bg = get_field('category_background', 'product_category_' . $category->term_id);
                    $products_count = $category->count;
                    ?>
                    <a href="<?php echo esc_url(get_term_link($category, 'product_category')); ?>" class="subcategory-card">
                        <?php
                        // Получаем URL изображений
                        $bg_url = is_array($category_bg) ? $category_bg['url'] : $category_bg;
                        $img_url = is_array($category_image) ? $category_image['url'] : $category_image;
                        ?>
                        <?php if ($bg_url) : ?>
                            <img class="subcategory-card__bg lazyload" src="<?php echo esc_url($bg_url); ?>" data-src="<?php echo esc_url($bg_url); ?>" alt="">
                        <?php endif; ?>

                        <?php if ($img_url) : ?>
                            <img class="subcategory-card__image lazyload" src="<?php echo esc_url($img_url); ?>" data-src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                        <?php else : ?>
                            <div class="subcategory-card__image subcategory-card__image--placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm10 0h2v2h-2zm-6-4h8v2h-8z"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="subcategory-card__content">
                            <h3 class="subcategory-card__title"><?php echo esc_html($category->name); ?></h3>
                            <?php if ($products_count > 0) : ?>
                                <div class="subcategory-card__count"><?php echo $products_count; ?> товарів</div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php
        // WooCommerce shop content
        if (woocommerce_product_loop()) :

            do_action('woocommerce_before_shop_loop');

            woocommerce_product_loop_start();

            if (wc_get_loop_prop('total')) :
                while (have_posts()) :
                    the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                endwhile;
            endif;

            woocommerce_product_loop_end();

            do_action('woocommerce_after_shop_loop');

        else :
            do_action('woocommerce_no_products_found');
        endif;

        do_action('woocommerce_after_main_content');
        ?>

        <?php
        // Резервный вывод товаров, если WooCommerce loop не сработал
        if (!woocommerce_product_loop() && have_posts()) :
            ?>
            <h2 class="section__subtitle" style="margin: 30px 0 20px;">Всі товари</h2>
            <div class="products-grid">
                <?php
                while (have_posts()) : the_post();
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
                    
                    $subtitle = get_field('product_subtitle');
                    ?>
                    <article class="product-card">
                        <div class="product-card__image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('product-thumb', array('class' => 'lazyload')); ?>
                                </a>
                            <?php else : ?>
                                <div class="product-card__image--placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="product-card__content">
                            <h3 class="product-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <?php if ($subtitle) : ?>
                                <div class="product-card__subtitle"><?php echo esc_html($subtitle); ?></div>
                            <?php endif; ?>

                            <?php if (has_excerpt()) : ?>
                                <div class="product-card__excerpt"><?php the_excerpt(); ?></div>
                            <?php endif; ?>

                            <?php if ($price) : ?>
                                <div class="product-card__price">
                                    <span class="product-card__price-label">Ціна:</span>
                                    <?php echo number_format($price, 0, ',', ' '); ?> <?php echo esc_html($currency); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="product-card__footer">
                            <a href="<?php the_permalink(); ?>" class="product-card__btn">Детальніше</a>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <div class="products-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '← Попередня',
                    'next_text' => 'Наступна →',
                ));
                ?>
            </div>
        <?php elseif (!woocommerce_product_loop()) : ?>
            <div class="products-empty">
                <svg class="products-empty__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                </svg>
                <p class="products-empty__text">Товари поки не додані.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
