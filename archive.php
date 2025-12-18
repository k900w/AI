<?php

/**
 * Archive Template - Blog Categories
 * 
 * Template for displaying blog archives (categories, tags, date archives)
 * Matches the original Bitrix24 design
 *
 * @package TEX-K
 */

get_header();

// Get the header image
$header_image = get_template_directory_uri() . '/assets/images/blog/blog_first_bg.jpg';

// Archive title
$archive_title = __('Агроблог', 'tex-k');

if (is_category()) {
    $archive_title = single_cat_title('', false);
    // Check for ACF header image on category
    if (function_exists('get_field')) {
        $acf_header = get_field('category_header_image', get_queried_object());
        if ($acf_header) {
            $header_image = $acf_header;
        }
    }
} elseif (is_tag()) {
    $archive_title = single_tag_title('', false);
} elseif (is_date()) {
    if (is_year()) {
        $archive_title = get_the_date('Y');
    } elseif (is_month()) {
        $archive_title = get_the_date('F Y');
    } elseif (is_day()) {
        $archive_title = get_the_date('d F Y');
    }
} elseif (is_author()) {
    $archive_title = get_the_author();
}
?>

<!-- Header Banner Section -->
<section class="section inner-page-banner catalog" style="background-image: url('<?php echo esc_url($header_image); ?>');">
    <div class="container">
        <div class="wrap-cols">
            <div class="col col--5 col--sm-12">
                <div class="section__head section__head_left">
                    <h1 class="section__titles section__titles--inline section__titles--bg-blue"><?php echo esc_html($archive_title); ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts List Section -->
<section class="section section_tabs">
    <div class="container">
        <div class="wrap-cols">
            <div class="col col--12">
                <div class="blog">
                    <div class="wrap-cols">
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
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
                                                        <source srcset="<?php echo esc_url($image_src); ?>" type="image/jpeg">
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
                                        <div class="blog-item__date">
                                            <?php echo get_the_date('d F Y'); ?>
                                        </div>
                                        <div class="blog-item__title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </div>
                                        <div class="blog-item__read-more">
                                            <a href="<?php the_permalink(); ?>"><?php _e('Детальніше', 'tex-k'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <div class="col col--12">
                                <div class="blog-no-posts">
                                    <h2 class="blog-no-posts__title"><?php _e('Статей поки немає', 'tex-k'); ?></h2>
                                    <p class="blog-no-posts__text"><?php _e('Скоро тут з\'являться цікаві матеріали', 'tex-k'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                // Pagination
                $pagination = paginate_links(array(
                    'type'      => 'array',
                    'prev_text' => __('Назад', 'tex-k'),
                    'next_text' => __('Вперед', 'tex-k'),
                ));

                if (!empty($pagination)) :
                ?>
                    <div class="pagenavigation">
                        <?php
                        foreach ($pagination as $page) {
                            echo $page;
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>