<?php
/**
 * WooCommerce Category Template
 * Перенаправляет на кастомную таксономию product_category
 *
 * @package TEX-K
 */

get_header();

// Получаем текущий термин product_cat
$current_term = get_queried_object();

// Ищем соответствующий термин в product_category по slug
$product_category_term = get_term_by('slug', $current_term->slug, 'product_category');

if ($product_category_term) {
    // Если найден соответствующий термин, используем его
    $current_term = $product_category_term;
    $taxonomy = 'product_category';
} else {
    // Иначе используем оригинальный
    $taxonomy = 'product_cat';
}
?>

<div class="container">
    <!-- Хлебные крошки -->
    <nav class="breadcrumbs-category">
        <a href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
        <span>›</span>
        <?php
        // Получаем родительские категории
        $ancestors = get_ancestors($current_term->term_id, $taxonomy);
        $ancestors = array_reverse($ancestors);
        foreach ($ancestors as $ancestor_id) {
            $ancestor = get_term($ancestor_id, $taxonomy);
            if ($ancestor) {
                $term_link = get_term_link($ancestor, $taxonomy);
                echo '<a href="' . esc_url($term_link) . '">' . esc_html($ancestor->name) . '</a>';
                echo '<span>›</span>';
            }
        }
        ?>
        <span class="current"><?php echo esc_html($current_term->name); ?></span>
    </nav>
</div>

<section class="section">
    <div class="container">
        <!-- Заголовок категории -->
        <div class="category-header">
            <h1 class="category-header__title"><?php single_term_title(); ?></h1>
            <?php if (term_description()) : ?>
                <div class="category-header__description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        // Получаем подкатегории
        $subcategories = get_terms(array(
            'taxonomy' => $taxonomy,
            'parent' => $current_term->term_id,
            'hide_empty' => false,
        ));

        if ($subcategories && !is_wp_error($subcategories) && count($subcategories) > 0) :
            ?>
            <h2 class="section__subtitle" style="margin-bottom: 20px;">Підкатегорії</h2>
            <div class="subcategories-grid">
                <?php foreach ($subcategories as $subcat) :
                    $category_image = get_field('category_image', $taxonomy . '_' . $subcat->term_id);
                    $category_bg = get_field('category_background', $taxonomy . '_' . $subcat->term_id);
                    $products_count = $subcat->count;
                    ?>
                    <a href="<?php echo esc_url(get_term_link($subcat, $taxonomy)); ?>" class="subcategory-card">
                        <?php
                        // Получаем URL изображений
                        $bg_url = is_array($category_bg) ? $category_bg['url'] : $category_bg;
                        $img_url = is_array($category_image) ? $category_image['url'] : $category_image;
                        ?>
                        <?php if ($bg_url) : ?>
                            <img class="subcategory-card__bg lazyload" src="<?php echo esc_url($bg_url); ?>" data-src="<?php echo esc_url($bg_url); ?>" alt="">
                        <?php endif; ?>

                        <?php if ($img_url) : ?>
                            <img class="subcategory-card__image lazyload" src="<?php echo esc_url($img_url); ?>" data-src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($subcat->name); ?>">
                        <?php else : ?>
                            <div class="subcategory-card__image subcategory-card__image--placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm10 0h2v2h-2zm-6-4h8v2h-8z"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="subcategory-card__content">
                            <h3 class="subcategory-card__title"><?php echo esc_html($subcat->name); ?></h3>
                            <?php if ($products_count > 0) : ?>
                                <div class="subcategory-card__count"><?php echo $products_count; ?> товарів</div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php
        // Вывод товаров категории
        if (have_posts()) :
            ?>
            <h2 class="section__subtitle" style="margin: 30px 0 20px;">Товари в категорії</h2>
            <div class="products-grid">
                <?php
                while (have_posts()) : the_post();
                    $price = get_field('product_price');
                    $currency = get_field('product_currency') ?: 'UAH';
                    $subtitle = get_field('product_subtitle');
                    $sku = get_field('product_sku');
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
        <?php elseif (!$subcategories || is_wp_error($subcategories) || count($subcategories) === 0) : ?>
            <div class="products-empty">
                <svg class="products-empty__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                </svg>
                <p class="products-empty__text">Товари в цій категорії поки не додані.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();

