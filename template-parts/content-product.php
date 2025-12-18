<?php
/**
 * Template part for displaying product cards
 *
 * @package TEX-K
 */
?>

<div class="card">
    <div class="card__inner">
        <div class="card__header">
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="card__header_image">
                    <?php the_post_thumbnail('product-thumb', array('class' => 'lazyload')); ?>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="card__body">
            <h3 class="card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            
            <div class="card__descr">
                <?php the_excerpt(); ?>
            </div>
        </div>
        
        <div class="card__footer">
            <?php
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
            
            if ($price) :
                ?>
                <div class="card__options">
                    <div class="card__options_option">
                        <div class="card__options_option_text">Ціна:</div>
                        <div class="card__options_option_value">
                            <?php echo number_format($price, 0, ',', ' '); ?> <?php echo esc_html($currency); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <a href="<?php the_permalink(); ?>" class="btn btn--small btn--orange">Детальніше</a>
        </div>
    </div>
</div>




