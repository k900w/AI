<?php

/**
 * Single Post Template - Агроблог Article
 * 
 * Template for displaying single blog posts
 * Matches the original Bitrix24 design
 *
 * @package TEX-K
 */

get_header();

// Get the header image
$header_image = get_template_directory_uri() . '/assets/images/blog/article_first_bg.jpg';

// Check for featured image or ACF field
if (has_post_thumbnail()) {
    $header_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
}

if (function_exists('get_field')) {
    $acf_header = get_field('article_header_image');
    if ($acf_header) {
        $header_image = $acf_header;
    }
}

// Get the title - check for custom H1 or use post title
$title = get_the_title();
if (function_exists('get_field')) {
    $meta_h1 = get_field('meta_h1');
    if ($meta_h1) {
        $title = $meta_h1;
    }
}
?>

<?php while (have_posts()) : the_post(); ?>

    <!-- Header Banner Section -->
    <section class="section inner-page-banner article" style="background-image: url('<?php echo esc_url($header_image); ?>');">
        <div class="container">
            <div class="wrap-cols">
                <div class="col col--10 col--sm-12">
                    <div class="section__head section__head_left">
                        <h1 class="section__titles section__titles--inline section__titles--white"><?php echo esc_html($title); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content Section -->
    <section class="section article-content">
        <div class="container">
            <div class="wrap-cols wrap-cols_center">
                <div class="col col--8 col--sm-12">
                    <div class="article-content__detail">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Get similar/related posts
    $categories = get_the_category();
    $similar_posts = array();

    if (!empty($categories)) {
        $category_ids = array();
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }

        $similar_args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'post__not_in'   => array(get_the_ID()),
            'category__in'   => $category_ids,
            'orderby'        => 'rand',
        );

        $similar_query = new WP_Query($similar_args);

        if ($similar_query->have_posts()) :
    ?>
            <!-- Similar Posts Section -->
            <section class="section section_grey">
                <div class="container">
                    <div class="section__head">
                        <div class="section__aico">AIKo</div>
                        <h2 class="section__title"><?php _e('Читайте також', 'tex-k'); ?></h2>
                    </div>
                </div>
                <div class="container">
                    <div class="wrap-cols">
                        <?php while ($similar_query->have_posts()) : $similar_query->the_post(); ?>
                            <div class="col col--4 col--md-6 col--sm-12">
                                <div class="blog-item">
                                    <div class="blog-item__image-inner">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <picture>
                                                    <?php
                                                    $thumbnail_id = get_post_thumbnail_id();
                                                    $image_src = wp_get_attachment_image_url($thumbnail_id, 'medium_large');
                                                    ?>
                                                    <img class="blog-item__image"
                                                        src="<?php echo esc_url($image_src); ?>"
                                                        alt="<?php echo esc_attr(get_the_title()); ?>"
                                                        loading="lazy">
                                                </picture>
                                            <?php else : ?>
                                                <img class="blog-item__image"
                                                    src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-item__image.jpg"
                                                    alt="<?php echo esc_attr(get_the_title()); ?>"
                                                    loading="lazy">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="blog-item__date"><?php echo get_the_date('d F Y'); ?></div>
                                    <div class="blog-item__title"><?php the_title(); ?></div>
                                    <div class="blog-item__read-more">
                                        <a href="<?php the_permalink(); ?>"><?php _e('Детальніше', 'tex-k'); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
    <?php
            wp_reset_postdata();
        endif;
    }
    ?>

<?php endwhile; ?>

<?php get_footer(); ?>