<?php
/**
 * Template Name: Агроблог
 * 
 * Custom template for the Agroblog archive page
 * Matches the original Bitrix24 design
 *
 * @package TEX-K
 */

get_header();

// Pagination setup
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 9;

// WP Query for blog posts
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$blog_query = new WP_Query($args);

// Get the header image (can be set via ACF or default)
$header_image = get_template_directory_uri() . '/assets/images/blog/blog_first_bg.jpg';

// Check if ACF field exists for header
if (function_exists('get_field')) {
    $acf_header = get_field('blog_header_image');
    if ($acf_header) {
        $header_image = $acf_header;
    }
}
?>

<!-- Header Banner Section -->
<section class="section inner-page-banner catalog" style="background-image: url('<?php echo esc_url($header_image); ?>');">
    <div class="container">
        <div class="wrap-cols">
            <div class="col col--5 col--sm-12">
                <div class="section__head section__head_left">
                    <h1 class="section__titles section__titles--inline section__titles--bg-blue"><?php _e('Агроблог', 'tex-k'); ?></h1>
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
                        <?php if ($blog_query->have_posts()) : ?>
                            <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                                <div class="col col--4 col--md-6 col--sm-12">
                                    <div class="blog-item">
                                        <div class="blog-item__image-inner">
                                            <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <picture>
                                                    <?php 
                                                    $thumbnail_id = get_post_thumbnail_id();
                                                    $image_webp = wp_get_attachment_image_url($thumbnail_id, 'medium_large');
                                                    $image_jpg = wp_get_attachment_image_url($thumbnail_id, 'medium_large');
                                                    ?>
                                                    <source srcset="<?php echo esc_url($image_webp); ?>" type="image/webp">
                                                    <source srcset="<?php echo esc_url($image_jpg); ?>" type="image/jpeg">
                                                    <img class="blog-item__image" 
                                                         src="<?php echo esc_url($image_jpg); ?>" 
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
                if ($blog_query->max_num_pages > 1) :
                    $big = 999999999;
                    $pages = paginate_links(array(
                        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format'    => '?paged=%#%',
                        'current'   => max(1, $paged),
                        'total'     => $blog_query->max_num_pages,
                        'type'      => 'array',
                        'prev_text' => __('Назад', 'tex-k'),
                        'next_text' => __('Вперед', 'tex-k'),
                    ));
                    ?>
                    <div class="pagenavigation">
                        <?php
                        if (!empty($pages)) {
                            foreach ($pages as $page) {
                                echo $page;
                            }
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
wp_reset_postdata();
get_footer();
?>
